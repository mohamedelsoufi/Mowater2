<?php

namespace App\Http\Requests\API;

use Dotenv\Exception\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ReserveVehicleRequest extends FormRequest
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
            'id_number' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'color_id' => 'required|exists:colors,id',
//            'price' => 'required|between:0,99999999999999.99',
            'branch_id' => 'nullable|exists:branches,id',
            'id_type' => 'required|in:passport,national_id',
            'personal_ID' => 'required|image|max:10000',
            'driving_license' => 'required|image|max:10000',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator,$response);
    }
}
