<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class RentalReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rental_office_car_id' => 'required|exists:rental_office_cars,id',
            'branch_id' => 'required|exists:branches,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required|in:GCC|local',
            'id_type' => 'required|in:passport,national_id',
            'id_number' => 'required|string',
            'credit_card_number' => 'nullable',
            'insurance_amount' => 'required_without:credit_card_number|between:0,99999999999999.99',
            'receive_type' =>'required|in:branch,location',
            'address' =>'required_if:receive_type,location',
            'start_date' =>'required',
            'end_date' =>'required',
            'price' => 'required|between:0,99999999999999.99',
            'personal_ID_for_rental' => 'required|image|max:10000',
            'driving_license_for_rental' => 'required|image|max:10000',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
