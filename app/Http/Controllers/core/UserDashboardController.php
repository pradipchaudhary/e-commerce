<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\core\offer;
use App\Models\core\order_log;
use App\Models\setting\shipping;
use App\Models\shipping_method;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $order_logs = order_log::query()
            ->where('user_id', auth()->id())
            ->with(
                'User.userDetail',
                'Stock.Esns',
                'insurance',
                'Shipping'
            )
            ->latest()
            ->get()
            ->groupBy('token')
            ->values();

        return view('user.dashboard', [
            'order_logs' => $order_logs
        ]);
    }

    public function detail($token)
    {
        $order = order_log::query()
            ->where('token', $token)
            ->where('user_id', auth()->id())
            ->first();

        abort_if($order == null, 404);

        $order_logs = order_log::query()
            ->where('token', $token)
            ->with('User.userDetail', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'shippingMethod', 'insurance', 'Shipping')
            ->with('Stock.Esns', function ($q) use ($order) {
                $q->where('user_id', $order->user_id);
            })
            ->latest()
            ->get();

        $insurance_cost = 0;
        $shipping_costs = 0;
        $total_cost = 0;

        $shipping = shipping::query()
            ->where('id', $order_logs[0]->shipping_id)
            ->first();

        if ($order_logs->sum('quantity') >= $shipping->quantity) {
            $shipping_costs = 0;
        } else {
            $shipping_costs = $shipping->cost;
        }

        foreach ($order_logs as $key => $order_log) {
            $total_cost += $order_log->quantity * $order_log->price;
            $insurance_cost += (($order_log->insurance->percent / 100) * $order_log->quantity * $order_log->price);
        }
        abort_if(!$order_logs->count(), 404);

        return view('user.user_order_detail', [
            'item_cost' => $total_cost,
            'order_logs' => $order_logs,
            'date' => date('d-m-Y', strtotime($order_logs[0]->updated_at)),
            'insurance_cost' => round($insurance_cost, config('CONSTANT.DECIMAL_PLACE')),
            'shipping_cost' => round($shipping_costs, config('CONSTANT.DECIMAL_PLACE')),
            'total_cost' => round(($total_cost + $insurance_cost + $shipping_costs), config('CONSTANT.DECIMAL_PLACE'))
        ]);
    }

    public function offerView()
    {
        $user = auth()->user();
        $offers = offer::query()
            ->where('user_id', $user->id)
            ->with('Stock', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'offerPrevPriceLog')
            ->get();

        return view('user.offer-view', [
            'offers' => $offers
        ]);
    }


    public function passwordChangeView(): View
    {
        return view('user.password_change');
    }

    public function passwordChange(Request $request)
    {
        $request->validate(['old_password' => 'required', 'new_password' => 'required', 'confirm_password' => 'required']);
        $user = auth()->user();

        if (Hash::check($request->old_password, $user->password)) {
            if ($request->new_password == $request->confirm_password) {
                User::query()
                    ->where('id', $user->id)
                    ->update([
                        'password' => Hash::make($request->new_password)
                    ]);

                Alert::success("Password changed successfully");
                return redirect()->back();
            } else {
                Alert::error("Old password didn't match to our records");
                return redirect()->back();
            }
        } else {
            Alert::error("Old password didn't match to our records");
            return redirect()->back();
        }
    }
}
