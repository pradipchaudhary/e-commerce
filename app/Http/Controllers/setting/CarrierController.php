<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\carrier;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class CarrierController extends Controller
{
    public function index(): View
    {
        return view('setting.vendor', ['vendors' => carrier::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:vendors', 'description' => 'present']);
        carrier::create($validate);
        toast("carrier added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, carrier $carrier): RedirectResponse
    {
        if (carrier::query()
            ->where('id', '!=', $carrier->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('carrier already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('carriers')->ignore($carrier)],
                'description' => 'present'
            ]
        );
        $carrier->update($validate);
        toast("carrier updated successfully", "success");
        return redirect()->back();
    }
}
