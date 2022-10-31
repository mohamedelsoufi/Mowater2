<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreFirebaseTokenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fcm_token' => 'required',
            'platform' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new ValidationException($validator, $response);
    }
}
