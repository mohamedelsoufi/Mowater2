<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ReserveWenchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'nickname' => 'required',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'from' => 'required',
            'to' => 'required',
            'date' => 'required|date',
            'address' => 'required',
            'distinctive_mark' => 'nullable',
            'time' => 'required',//|date_format:h:i',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
            'owen_vehicles' => 'required_if:is_mawater_card,1|array',
            'owen_vehicle.*.id' => 'required_if:is_mawater_card,1|exists:vehicles,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}

