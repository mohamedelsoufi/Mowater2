<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class TestDriveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_id' => 'required|exists:vehicles,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'branch_id' => 'required|exists:branches,id',
            'date' => 'required|date',
            'time' => 'required',
            'driving_license_for_test' => 'required|image|max:10000',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator,$response);
    }
}
