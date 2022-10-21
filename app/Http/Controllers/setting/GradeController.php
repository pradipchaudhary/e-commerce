<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\setting\grade;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class GradeController extends Controller
{
    public function index(): View
    {
        return view('setting.grade', ['grades' => grade::query()->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate(['name' => 'required|unique:grades', 'description' => 'present']);
        grade::create($validate);
        toast("Grade added successfully", "success");
        return redirect()->back();
    }

    public function update(Request $request, grade $grade): RedirectResponse
    {
        if (grade::query()
            ->where('id', '!=', $grade->id)
            ->where('name', $request->name)
            ->first() != null
        ) {
            Alert::error('Grade already exist');
            return redirect()->back();
        }
        $validate = $request->validate(
            [
                'name' => ['required', Rule::unique('grades')->ignore($grade)],
                'description' => 'present'
            ]
        );
        $grade->update($validate);
        toast("Grade updated successfully", "success");
        return redirect()->back();
    }
}
