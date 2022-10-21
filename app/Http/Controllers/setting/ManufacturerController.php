<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\manufacturer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ManufacturerController extends Controller
{
    public function index(): View
    {
        return view('setting.manufacturer', ['manufacturers' => manufacturer::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:manufacturers', 'description' => 'present']);
        manufacturer::create($validate);
        toast("manufacturer added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, manufacturer $manufacturer): RedirectResponse
    {
        if (manufacturer::query()
            ->where('id', '!=', $manufacturer->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('manufacturer already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('manufacturers')->ignore($manufacturer)],
                'description' => 'present'
            ]
        );
        $manufacturer->update($validate);
        toast("manufacturer updated successfully", "success");
        return redirect()->back();
    }
}
