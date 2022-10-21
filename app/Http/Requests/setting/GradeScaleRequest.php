<?php

namespace App\Http\Requests\setting;

use Illuminate\Foundation\Http\FormRequest;

class GradeScaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'grade_id' => 'required',
            'name' => 'required',
            'image.*'=>'required_if:grade_id,1',
            'screen'=>'required',
            'apperance'=>'present',
            'other'=>'present',
            'bezel'=>'present',
            'lcd'=>'required_if:grade_id,2',
            'functionality'=>'required_if:grade_id,2',
        ];
    }
}
