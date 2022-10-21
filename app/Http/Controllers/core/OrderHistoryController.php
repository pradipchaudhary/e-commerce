<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Mail\DeliveryMail;
use App\Models\core\esn;
use App\Models\core\order_log;
use App\Models\setting\shipping;
use App\Models\shipping_method;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderHistoryController extends Controller
{
    public function index()
    {
        return view('order.order-report', [
            'users' => User::query()
                ->where('id', '!=', config('CONSTANT.SUPERADMIN_ID'))
                ->where('status', true)
                ->whereHas('userDetail')
                ->get(),
            'shipping_methods' => shipping_method::query()->get()
        ]);
    }

    public function orderHistoryReport()
    {
        $order_log = order_log::query()
            ->with('User.userDetail', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'Stock.Esns', 'shippingMethod', 'insurance', 'Shipping')
            ->when(request('user_id'), function ($query) {
                $query->where('user_id', request('user_id'));
            })
            ->when(request('token'), function ($query) {
                $query->where('token', request('token'));
            })
            ->when(request('from') && request('to'), function ($query) {
                $query->whereBetween('order_at', [request('from'), request('to')]);
            })
            ->latest()
            ->get()
            ->groupBy('token')
            ->values();
        return response()->json($order_log);
    }

    public function switchPaidStatus(Request $request)
    {
        try {
            order_log::query()->where('id', $request->order['id'])->update([
                'is_paid' => true
            ]);
            return response()->json(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function dispatchOrder(Request $request)
    {
        DB::beginTransaction();

        try {
            $esnArray = [];

            $order_log = order_log::query()
                ->where('id', $request->order_log_id)
                ->with('Stock', 'User')
                ->first();
            if (!$order_log->is_paid) {
                toast("First change status to paid to dispatch order", "error");
                return redirect()->back();
            }
            $shipping_method = shipping_method::query()
                ->where('id', $request->shipping_method_id)
                ->first();

            foreach ($request->esn as $esn) {
                $esn = esn::query()->where('esn', $esn)->first();

                if ($esn == null) {
                    toast("ESN / IMEI doesn't match", "error");
                    return redirect()->back();
                } else {
                    $esnArray[] = $esn->esn;
                    $esn->update(['user_id' => $order_log->user_id]);
                }
            }

            $order_log->update(['shipping_method_id' => $request->shipping_method_id, 'track_id' => $request->track_id]);


            $order_log->update(['is_dispatch' => true]);
            Mail::to($order_log->User->email)->send(new DeliveryMail($order_log->User, $order_log, $shipping_method, $request->track_id, $esnArray));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            toast("Something went wrong", "error");
            return redirect()->back();
        }

        toast("ESN assigned successfully", "success");
        return redirect()->back();
    }

    public function switchDeliverStatus(Request $request)
    {
        try {
            order_log::query()->where('id', $request->order['token'])->update([
                'is_delivered' => true
            ]);
            return response()->json(true);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function viewOrderDetail($token)
    {
        $order = order_log::query()->where('token', $token)->first();
        abort_if($order == null, 404);
        $order_logs = order_log::query()
            ->where('token', $token)
            ->with(
                'User.userDetail.Country',
                'User.userDetail.State',
                'Stock.Product.Manufacturer',
                'Stock.Status',
                'Stock.GradingScale',
                'Stock.Color',
                'shippingMethod',
                'insurance',
                'Shipping'
            )
            ->with('Stock.Esns', function ($q) use ($order) {
                $q->where('user_id', $order->user_id);
            })
            ->latest()
            ->get();

        abort_if(!$order_logs->count(), 404);
        $insurance_cost = 0;
        $shipping_costs = 0;
        $total_costs = 0;

        $shipping = shipping::query()
            ->where('id', $order_logs[0]->shipping_id)
            ->first();

        if ($order_logs->sum('quantity') >= $shipping->quantity) {
            $shipping_costs = 0;
        } else {
            $shipping_costs = $shipping->cost;
        }

        foreach ($order_logs as $key => $order_log) {
            $total_costs += $order_log->quantity * $order_log->price;
            $insurance_cost += (($order_log->insurance->percent / 100) * $order_log->quantity * $order_log->price);
        }

        return view('order.order-detail', [
            'order_logs' => $order_logs,
            'insurance_cost' => round($insurance_cost, config('CONSTANT.DECIMAL_PLACE')),
            'shipping_methods' => shipping_method::query()->get(),
            'shipping_cost' => round($shipping_costs, config('CONSTANT.DECIMAL_PLACE')),
            'total_cost' => round(($total_costs + $insurance_cost + $shipping_costs), config('CONSTANT.DECIMAL_PLACE')),
            'item_cost' => $total_costs
        ]);
    }
}
