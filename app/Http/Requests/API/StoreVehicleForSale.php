<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreVehicleForSale extends FormRequest
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
            'manufacturing_year' => 'required|numeric',
            'traveled_distance' => ['required', 'nullable', 'numeric', 'between:0,999999999999999.99'],
            'traveled_distance_type' => ['required', 'in:km,mile'],
            'outside_color_id' => 'nullable|exists:colors,id',
            'inside_color_id' => 'nullable|exists:colors,id',
            'in_bahrain' => ['required', 'boolean'],
            'country_id' => ['required_if:in_bahrain,0', 'nullable', 'exists:countries,id'],
            'guarantee' => ['required', 'boolean'],
            'guarantee_year' => ['required_if:guarantee,1', 'nullable', 'integer'],
            'guarantee_month' => ['required_if:guarantee,1', 'nullable', 'in:01,02,03,04,05,06,07,08,09,10,11,12'],
            'transmission_type' => 'nullable|in:' . transmission_type(),
            'engine_size' => 'nullable|in:' . engine_size(),
            'cylinder_number' => 'nullable|numeric|in:' . cylinder_number(),
            'fuel_type' => 'required|in:' . fuel_type(),
            'wheel_drive_system' => 'nullable|in:' . wheel_drive_system(),
            'specifications' => 'nullable|in:' . specifications(),
            'status' => ['required', 'in:' . status()],
            'insurance' => ['required', 'boolean'],
            'insurance_month' => ['required_if:insurance,1', 'nullable', 'in:01,02,03,04,05,06,07,08,09,10,11,12'],
            'insurance_year' => ['required_if:insurance,1', 'nullable', 'integer'],
            'start_with_fingerprint' => 'nullable|boolean',
            'remote_start' => 'nullable|boolean',
            'screen' => 'nullable|boolean',
            'seat_upholstery' => 'nullable|nullable:' . seat_upholstery(),
            'air_conditioning_system' => 'nullable|in:' . air_conditioning_system(),
            'windows_control' => 'nullable|in:' . windows_control(),
            'wheel_size' => 'nullable|in:' . wheel_size(),
            'wheel_type' => 'nullable|in:' . wheel_type(),
            'sunroof' => 'nullable|in:' . sunroof(),
            'selling_by_plate' => ['required', 'boolean'],
            'number_plate' => ['required_if:selling_by_plate,1'],
            'price_is_negotiable' => ['required', 'boolean'],
            'location' => 'nullable|string',
            'additional_notes' => 'nullable',
            'price' => 'required|between:0,9999999999.99',
            'front_side_image' => 'required|image|max:10000',
            'back_side_image' => 'required|image|max:10000',
            'right_side_image' => 'required|image|max:10000',
            'left_side_image' => 'required|image|max:10000',
            'inside_vehicle_image' => 'required|image|max:10000',
            'vehicle_dashboard_image' => 'required|image|max:10000',
            'traffic_pdf' => 'required|mimes:pdf',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator, $response);
    }
}
