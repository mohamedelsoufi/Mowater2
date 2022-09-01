<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ShowDeliveryManRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:delivery_man,id'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new ValidationException($validator, $response);
    }
}
