<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\grading_scale;
use App\Models\setting\manufacturer;
use App\Models\setting\product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('setting.product', [
            'products' => product::query()->with('Manufacturer')->get(),
            'manufacturers' => manufacturer::query()->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:products', 'description' => 'present', 'manufacturer_id' => "required"]);
        product::create($validate);
        toast("product added successfully", "success");
        return redirect()->back();
    }


    /**
     * though i have define this method but in view it is not implemented :)
     */

    public function update(Request $request, product $product): RedirectResponse
    {
        if (
            product::query()
            ->where('id', '!=', $product->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('product already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('products')->ignore($product)],
                'description' => 'present',
                'manufacturer_id' => 'required'
            ]
        );
        $product->update($validate);
        toast("product updated successfully", "success");
        return redirect()->back();
    }
}
