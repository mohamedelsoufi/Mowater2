<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class QuotationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_type'=>'required|in:renewal,transfer_from_one_company_to_another,transfer_to_another_person,first_once',
            'features'=>'required',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required',
            'chassis_number' => 'required',
            'number_plate' => 'required',
            'engine_size'=>'required',
            'number_of_cylinders'=>'required|numeric',
            'vehicle_value'=>'required|between:0,99999999999999.99',
            'is_accident_certificate' => 'required|boolean',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator,$response);
    }
}
