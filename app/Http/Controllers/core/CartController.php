<?php

namespace App\Http\Controllers\core;

use App\Http\Controllers\Controller;
use App\Models\core\cart;
use App\Models\core\offer;
use App\Models\stock;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(): View
    {
        $carts = cart::query()
            ->where('user_id', auth()->id())
            ->with('Stock', 'Stock.Product.Manufacturer', 'Stock.Status', 'Stock.GradingScale', 'Stock.Color')
            ->get();

        $offers = offer::query()
            ->where('user_id', auth()->id())
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

        return view('user.cart', [
            'carts' => $carts,
            'cart_sum' => $sum,
            'offers' => $offers
        ]);
    }

    public function store(Request $request)
    {
        $stock = stock::query()
            ->where('id', $request->stock_id)
            ->first();

        $cart = cart::query()
            ->where('stock_id', $request->stock_id)
            ->where('user_id', auth()->id())
            ->count();

        if ($cart) {
            $msg = "you have already added this item in cart";
        } else {
            if ($request->quantity > $stock->quantity) {
                $msg = 'Insufficent number of quantity in stock';
            } else {
                cart::create([
                    'stock_id' => $request->stock_id,
                    'quantity' => $request->quantity,
                    'user_id' => auth()->id()
                ]);
                $msg = "Successfully added to cart";
            }
        }
        return response()->json($msg);
    }

    public function storeOffer(Request $request)
    {
        DB::beginTransaction();
        try {
            $stock = stock::query()
            ->where('id', $request->stock_id)
            ->first();
            
            $offer = offer::query()
            ->where('stock_id', $request->stock_id)
            ->where('user_id', auth()->id())
            ->count();
            
            if ($stock->price == $request->offer_price) {
                return response()->json("Price cannot be same");
            }

            if ($offer) {
                $msg = "you have already added this item in offer";
            } else {
                if ($request->quantity > $stock->quantity) {
                    $msg = 'Insufficent number of quantity in stock';
                } else {
                    offer::create([
                        'stock_id' => $request->stock_id,
                        'quantity' => $request->quantity,
                        'user_id' => auth()->id(),
                        'price' => $request->offer_price,
                        'status' => offer::STATUS_PENDING
                    ]);
                    $msg = "Successfully added to offer";
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $msg = $e->getMessage();
        }
        return response()->json($msg);
    }

    public function delete(Request $request)
    {
        cart::query()
            ->where('id', $request->cart_id)
            ->where('user_id', auth()->id())
            ->forceDelete();

        return response()->json('Product removed from cart successfully');
    }

    public function deleteOffer(Request $request)
    {
        offer::query()
            ->where('id', $request->offer_id)
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json('Product removed from offer successfully');
    }
    public function addSubtratctQuantity(Request $request)
    {
        $cart = cart::query()->where('id', $request->id)->update([
            'quantity' => $request->quantity
        ]);

        return response()->json($cart);
    }

    public function checkout(Request $request)
    {
        try {
            if (count($request->all()[1]) == 1) {
                if ($request->all()[1][0]['status'] != 1) {
                    return response()->json(['msg' => 'Please accept or reject offer to proceed forward']);
                }
            }
            foreach ($request->all()[0] as $key => $data) {
                $cart = cart::query()
                    ->where('id', $data['id'])
                    ->first();

                if ($cart->quantity != $data['quantity']) {
                    if (
                        stock::query()
                        ->select('id', 'quantity')
                        ->where('id', $cart->stock_id)
                        ->first()->quantity < $data['quantity']
                    ) {
                        return response()->json(['msg' => 'Out of stock']);
                    }
                    $cart->update(['quantity' => $data['quantity']]);
                }
            }
        } catch (\exception $e) {
            return response()->json($e);
        }
        return response()->json(['msg' => '']);
    }
}
