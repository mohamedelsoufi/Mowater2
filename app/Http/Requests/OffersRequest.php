<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_id.*'=>'numeric',
            'vehicle_discount_type.*'=>'',
            'vehicle_discount_value.*'=>'between:0,9999999999.99',
            'product_id.*'=>'',
            'product_discount_type.*'=>'',
            'product_discount_value.*'=>'between:0,9999999999.99',
            'service_id.*'=>'',
            'service_discount_type.*'=>'',
            'service_discount_value.*'=>'between:0,9999999999.99',
//            'vehicle_number_of_uses_times.*' => 'required|in:'. number_of_uses_times(),
            'vehicle_specific_number.*' =>['nullable','numeric'],
//            'product_number_of_uses_times.*' => 'required|in:'. number_of_uses_times(),
            'product_specific_number.*' =>'nullable|numeric',
//            'service_number_of_uses_times.*' => 'required|in:'. number_of_uses_times(),
            'service_specific_number.*' =>'nullable|numeric',
        ];
    }
    public function messages()
    {
        $messages =[];
        foreach ($this->get('vehicle_discount_value') as $key => $val) {
            $messages["vehicle_discount_value.$key"] = "$val is not a valid active url";
        }
        return $messages;
    }
}
