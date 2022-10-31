<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GetCarModelsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'brand_id' => 'required|exists:brands,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
