<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\shipping_method;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ShippingMethodController extends Controller
{
    public function index(): View
    {
        return view('setting.shipping_method', ['shipping_methods' => shipping_method::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:shipping_methods', 'description' => 'present']);
        shipping_method::create($validate);
        toast("shipping method added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, shipping_method $shipping_method): RedirectResponse
    {
        if (shipping_method::query()
            ->where('id', '!=', $shipping_method->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('shipping method already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('shipping_methods')->ignore($shipping_method)],
                'description' => 'present'
            ]
        );
        $shipping_method->update($validate);
        toast("shipping method updated successfully", "success");
        return redirect()->back();
    }
}
