<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\warehouse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class WareHouseController extends Controller
{
    public function index(): View
    {
        return view('setting.warehouse', ['warehouses' => warehouse::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:warehouses', 'description' => 'present']);
        warehouse::create($validate);
        toast("warehouse added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, warehouse $warehouse): RedirectResponse
    {
        if (warehouse::query()
            ->where('id', '!=', $warehouse->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('warehouse already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('warehouses')->ignore($warehouse)],
                'description' => 'present'
            ]
        );
        $warehouse->update($validate);
        toast("warehouse updated successfully", "success");
        return redirect()->back();
    }
}
