<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reviewable_type' => 'required|in:Agency,CarShowroom,Garage,RentalOffice,SpecialNumber,Wench',
            'reviewable_id' => 'required',
            'rate' => 'required|between:0,99.99',
            'review' => 'required|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator,$response);
    }
}
