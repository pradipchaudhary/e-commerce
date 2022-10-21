<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "warehouse_id" => "required",
            "manufacturer_id" => "required",
            "product_id" => "required",
            "grading_scale_id" => "required",
            "color_id" => "required",
            "vendor_id" => "sometimes",
            "status_id" => "required",
            "quantity" => "required",
            "price" => "required",
            "carrier_id" => "required",
        ];
    }
}
