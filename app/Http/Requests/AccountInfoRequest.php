<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountInfoRequest extends FormRequest
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
            'business_phone_number_code' => 'required',
            'business_phone_number' => 'required',
            'whatsapp_code' => 'present',
            'whatsapp_number' => 'present',
            'country_id' => 'required',
            'address' => 'required',
            'state_id' => 'required',
            'postal_code' => 'required',
            'city_id'=>'required',
            // 'street_name'=>'required',
        ];
    }
}
