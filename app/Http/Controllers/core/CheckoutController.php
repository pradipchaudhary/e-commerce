<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Mail\CheckoutMail;
use App\Models\core\cart;
use App\Models\core\offer;
use App\Models\core\offer_price_prev_log;
use App\Models\core\order_log;
use App\Models\setting\country;
use App\Models\setting\insurance;
use App\Models\setting\shipping;
use App\Models\setting\state;
use App\Models\setting\city;
use App\Models\stock;
use App\Models\stock_log;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = cart::query()->where('user_id', auth()->id())->get();
        $offers = offer::query()->where('user_id', auth()->id())->where('status', offer::STATUS_ACCEPT)->get();

        if ($carts->count() || $offers->count()) {
            $user = User::query()->where('id', auth()->id())->with('userDetail')->first();
            $order_log = order_log::query()
                ->where('user_id', auth()->id())
                ->where('is_checkout', false)
                ->count();

            if ($order_log) {
                return redirect()->route('checkout.orderConfrimation');
            } else {
                return view('checkout', [
                    'countries' => country::query()->where('id', 233)->get(),
                    'user' => $user,
                    'states' => state::query()->where('country_id', $user->userDetail->country_id)->get(),
                    'shippings' => shipping::query()->get(),
                    'cart_quantity_sum' => $carts->sum('quantity'),
                    'insurances' => insurance::query()->get(),
                    'cities' => city::query()->where('id',$user->userDetail->city_id)->get()
                ]);
            }
        } else {
            Alert::error('Sorry you dont have any item in cart');
            return redirect()->route('cart.index');
        }
    }

    public function store(Request $request)
    {
        $user_id = auth()->id();
        DB::beginTransaction();
        try {

            $carts = cart::query()->where('user_id', $user_id)->with('Stock')->get();
            $offers = offer::query()
                ->where('user_id', $user_id)
                ->where('status', offer::STATUS_ACCEPT)
                ->with('Stock')->get();

            foreach ($carts as $key => $cart) {
                $order_log = order_log::create([
                    'user_id' => $user_id,
                    'stock_id' => $cart->stock_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->Stock->price,
                    'insurance_id' => $request->insurance_id,
                    'shipping_id' => $request->shipping_id
                ]);
            }

            foreach ($offers as $key => $offer) {
                $order_log = order_log::create([
                    'user_id' => $user_id,
                    'stock_id' => $offer->stock_id,
                    'quantity' => $offer->quantity,
                    'price' => $offer->price,
                    'insurance_id' => $request->insurance_id,
                    'shipping_id' => $request->shipping_id,
                    'is_offer' => true
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Something went wrong...');
            return redirect()->back();
        }
        return redirect()->route('checkout.orderConfrimation');
    }

    public function orderConfrimation()
    {
        $order_log = order_log::query()
            ->where('user_id', auth()->id())
            ->where('is_checkout', false)
            ->get();

        abort_if(!$order_log->count(), 404);

        $carts = cart::query()
            ->where('user_id', auth()->id())
            ->with('Stock', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color')
            ->get();

        $offers = offer::query()
            ->where('user_id', auth()->id())
            ->where('status', offer::STATUS_ACCEPT)
            ->with('Stock', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color', 'offerPrevPriceLog')
            ->get();

        $sum = 0;
        foreach ($carts as $key => $cart) {
            if ($cart->Stock->quantity > 1) {
                $sum += $cart->quantity * $cart->Stock->price;
            }
        }

        foreach ($offers->where('status', offer::STATUS_ACCEPT) as $key => $offer) {
            if ($offer->Stock->quantity > 1) {
                $sum += $offer->quantity * $offer->price;
            }
        }

        $insurance = insurance::query()
            ->where('id', $order_log[0]->insurance_id)
            ->first();

        $shipping = shipping::query()
            ->where('id', $order_log[0]->shipping_id)
            ->first();

        if ($shipping->quantity > 0 && $shipping->quantity < $order_log->sum('quantity')) {
            $delivery_charge = 0;
        } else {
            $delivery_charge = $shipping->cost;
        }

        if (!$insurance->percent) {
            $insurance_charge = 0;
        } else {
            $insurance_charge = ($insurance->percent / 100) * $sum;
        }

        $total_sum = $sum + $delivery_charge + $insurance_charge;

        return view('order-confirmation', [
            'product_sum' => $sum,
            'total_sum' => $total_sum,
            'delivery_charge' => $delivery_charge,
            'insurance_charge' => $insurance_charge,
            'carts' => $carts,
            'offers' => $offers,
            'insurance' => $insurance,
            'shipping' => $shipping
        ]);
    }

    public function orderConfrimationSubmit(Request $request)
    {

        $user_id = auth()->id();

        DB::beginTransaction();
        try {

            $order_logs = order_log::query()
                ->where('user_id', $user_id)
                ->where('is_checkout', false)
                ->get();
            $token = getUniqueTokenForOrderLog();
            
            foreach ($order_logs as $key => $order_log) {
                $stock = stock::query()->where('id', $order_log->stock_id)->first();
                $stock->update(['quantity' => $stock->quantity - $order_log->quantity]);
                stock_log::create([
                    'stock_id' => $stock->id,
                    'quantity' => $order_log->quantity,
                    'price' => $order_log->price,
                    'is_out' => true,
                    'user_id' => $user_id
                ]);

                $order_log->update(
                    [
                        'is_checkout' => true,
                        'description' => $request->description,
                        'token' => $token,
                        'order_at' => now()
                    ]
                );
            }

            $carts_to_be_deleted = cart::query()->where('user_id', auth()->id())->get();

            foreach ($carts_to_be_deleted as $key => $cart_delete) {
                cart::query()->where('id', $cart_delete->id)->delete();
            }

            $offer = offer::query()
                ->where('user_id', auth()->id())
                ->where('status', offer::STATUS_ACCEPT)
                ->get();

            foreach ($offer as $key => $offer_ind) {
                offer_price_prev_log::query()->where('offer_id', $offer_ind->offer_id)->delete();
                offer::query()->where('id', $offer_ind->id)->delete();
            }


            Mail::to(auth()->user()->email)->send(new CheckoutMail($token));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error($e->getMessage());
            return redirect()->back();
        }
        toast('Your order is confirmed', 'success');
        return redirect()->route('stock_list');
    }
}
