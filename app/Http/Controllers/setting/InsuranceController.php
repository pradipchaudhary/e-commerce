<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\insurance;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index(): View
    {
        return view('setting.insurance', [
            'insurances' => insurance::query()->get()
        ]);
    }

    public function update(Request $request, insurance $insurance): RedirectResponse
    {
        if ($insurance->status) {
            $insurance->update($request->all());
        } else {
            $insurance->update(['description' => $request->description]);
        }
        toast("Insurance updated successfully", 'success');

        return redirect()->back();
    }
}
