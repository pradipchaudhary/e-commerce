<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\status;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class StatusController extends Controller
{
    public function index(): View
    {
        return view('setting.status', ['statuses' => status::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:statuses', 'description' => 'present']);
        status::create($validate);
        toast("status added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, status $status): RedirectResponse
    {
        if (status::query()
            ->where('id', '!=', $status->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('status already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('statuses')->ignore($status)],
                'description' => 'present'
            ]
        );
        $status->update($validate);
        toast("status updated successfully", "success");
        return redirect()->back();
    }
}
