<?php

namespace App\Http\Controllers\setting;

use App\Helper\MediaHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\setting\GradeScaleRequest;
use App\Models\image;
use App\Models\setting\grade;
use App\Models\setting\grading_scale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeScaleController extends Controller
{
    public function index(): View
    {
        return view('setting.grade-scale.grade-scale', [
            'grading_scales' => grading_scale::query()->with('Grade')->get()
        ]);
    }

    public function create(): View
    {
        return view('setting.grade-scale.create_grade_scale', [
            'grades' => grade::query()->get()
        ]);
    }

    public function store(GradeScaleRequest $request,MediaHelper $helper): RedirectResponse
    {
        DB::transaction(function () use ($request,$helper) {
            $grading_scale = grading_scale::create($request->except('imgae') +  ['entered_by' => auth()->user()->id]);
            
            if ($request->hasFile('image')) {
                foreach ($request->image as $key => $image) {
                    $imageName = $helper->uploadSingleImage($request->image[$key]);
                    
                    image::create(
                        [
                            'imageable_type' => grading_scale::NAMESPACE,
                            'imageable_id' => $grading_scale->id,
                            'name' => $imageName
                        ]
                    );
                }
            }
        });

        toast("Grading scale inserted successfully","success");
        return redirect()->route('grade-scale.index');
    }
}
