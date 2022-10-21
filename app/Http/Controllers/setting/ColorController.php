<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\color;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ColorController extends Controller
{
    public function index(): View
    {
        return view('setting.color', ['colors' => color::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:colors', 'description' => 'present']);
        color::create($validate);
        toast("color added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, color $color): RedirectResponse
    {
        if (color::query()
            ->where('id', '!=', $color->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('color already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('colors')->ignore($color)],
                'description' => 'present'
            ]
        );
        $color->update($validate);
        toast("color updated successfully", "success");
        return redirect()->back();
    }
}
