<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RequestTechnicalInspectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'technical_inspection_center_id' => 'required|exists:technical_inspection_centers,id',
            'services' =>'required|array',
            'services.*' =>'exists:technical_inspection_center_services,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required',
            'chassis_number' => 'required',
            'number_plate' => 'required',
            'date' => 'required|date',
            'time' => 'required',
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
