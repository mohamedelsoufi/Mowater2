<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class showCarModelRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'car_model_id' => 'required|exists:car_models,id',
            'brand_id' => 'required|exists:brands,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
