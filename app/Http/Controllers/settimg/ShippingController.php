<?php

namespace App\Http\Controllers\settimg;

use App\Http\Controllers\Controller;
use App\Models\setting\shipping;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(): View
    {
        return view('setting.shipping', [
            'shippings' => shipping::query()->get()
        ]);
    }

    public function freeShippingEdit(Request $request): RedirectResponse
    {
        $shipping = shipping::query()->whereNull('name')->first();

        if ($shipping == null) {
            shipping::create([
                'quantity' => $request->quantity,
                'description' => $request->description
            ]);

            toast('Shipping set successfully', 'success');
        } else {
            $shipping->update([
                'quantity' => $request->quantity,
                'description' => $request->description
            ]);
            toast("Shipping added successfully", 'success');
        }

        return redirect()->back();
    }

    public function store(Request $request): RedirectResponse
    {
        $attribute = $request->validate(['name' => 'required', 'cost' => 'required', 'description' => 'present','quantity'=>'present']);
        shipping::create($attribute);
        toast("Shipping added successfully", 'success');
        return redirect()->back();
    }
}
