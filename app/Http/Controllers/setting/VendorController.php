<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\vendor;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class VendorController extends Controller
{
    public function index(): View
    {
        return view('setting.vendors', ['vendors' => vendor::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:vendors', 'description' => 'present']);
        vendor::create($validate);
        toast("vendor added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, vendor $vendor): RedirectResponse
    {
        if (vendor::query()
            ->where('id', '!=', $vendor->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('vendor already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('vendors')->ignore($vendor)],
                'description' => 'present'
            ]
        );
        $vendor->update($validate);
        toast("vendor updated successfully", "success");
        return redirect()->back();
    }
}
