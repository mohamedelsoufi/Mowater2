<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReserveBrokerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'branch_id'=>'required|exists:branches,id',
            'service_type'=>'required|in:renewal,transfer_from_one_company_to_another,transfer_to_another_person,first_once',
            'package_id'=>'required|exists:broker_packages,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'birth_date'=>'required',
            'nationality' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required',
            'chassis_number' => 'required',
            'number_plate' => 'required',
            'engine_size'=>'required',
            'number_of_cylinders'=>'required|numeric',
            'vehicle_value'=>'required|between:0,99999999999999.99',
            'driving_license_for_broker' => 'required|image|max:10000',
            'vehicle_ownership_for_broker'=>'required|image|max:10000',
            'no_accident_certificate_for_broker'=>'required_if:service_type,transfer_from_one_company_to_another|image|max:10000',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
            'owen_vehicles' => 'required_if:is_mawater_card,1|array',
            'owen_vehicle.*.id' => 'required_if:is_mawater_card,1|exists:vehicles,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator,$response);
    }
}
