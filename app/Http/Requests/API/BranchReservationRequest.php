<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BranchReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
//            'reservable_type' => 'required|in:Branch,Garage',
            'reservable_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'nickname' => 'required',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'address' => 'required|max:255',
//            'from' => 'required',
//            'to' => 'required',
            'date' => 'required|date',
            'time' => 'required',//|date_format:h:i',
            'products' => 'nullable|array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'required|numeric',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
            'owen_vehicles' => 'required_if:is_mawater_card,1|array',
            'owen_vehicle.*.id' => 'required_if:is_mawater_card,1|exists:vehicles,id',
            'delivery' => 'required|boolean',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required',
            'chassis_number' => 'required',
            'number_plate' => 'required',
            'nationality' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}

