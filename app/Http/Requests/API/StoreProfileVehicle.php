<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreProfileVehicle extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_type' => 'required|in:' . vehicle_type(),
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'outside_color_id' => 'required|exists:colors,id',
            'manufacturing_year' => 'required|numeric',
            'number_plate' => 'required',
            'vehicle_name' => 'required',
            'wheel_size' => 'required',
            'chassis_number' => 'required|unique:vehicles,chassis_number',
            'battery_size' => 'required',
            'maintenance_history' => 'required|date',
            'maintenance_history_km' => 'nullable',
            'tire_installation_date' => 'required|date',
            'tire_installation_date_km' => 'nullable',
            'tire_warranty_expiration_date' => 'required|date',
            'tire_warranty_expiration_date_km' => 'nullable',
            'battery_installation_date' => 'required|date',
            'battery_installation_date_km' => 'nullable',
            'battery_warranty_expiry_date' => 'required|date',
            'battery_warranty_expiry_date_km' => 'nullable',
            'vehicle_registration_expiry_date' => 'required|date',
            'vehicle_registration_expiry_date_km' => 'nullable',
            'vehicle_insurance_expiry_date' => 'required|date',
            'vehicle_insurance_expiry_date_km' => 'nullable',
            'images.*' => 'required|image|max:10000',
            'additional_maintenance' => 'nullable|array',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new ValidationException($validator, $response);
    }
}
