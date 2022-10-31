<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_type' => 'required|in:' . vehicle_type(),
//            'ghamara_count' => ['required_if:vehicle_type,pickups'],
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required|numeric',
            'is_new' => 'required|boolean',
            'traveled_distance' => 'required_if:is_new,0|nullable|numeric|between:0,999999999999999.99',
            'traveled_distance_type' => 'required_if:is_new,0|nullable|in:km,mile',
            'outside_color_id' => 'nullable|exists:colors,id',
            'inside_color_id' => 'nullable|exists:colors,id',
            'in_bahrain' => 'required_if:is_new,0|nullable|boolean',
            'country_id' => 'required_if:in_bahrain,0|nullable|exists:countries,id',
            'guarantee' => 'required_if:is_new,0|nullable|boolean',
            'guarantee_year' => 'required_if:guarantee,1|nullable|nullable|integer',
            'guarantee_month' => 'required_if:is_new,0|nullable|required_if:guarantee,1|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'transmission_type' => 'nullable|in:' . transmission_type(),
            'engine_size' => 'nullable|in:' . engine_size(),
            'cylinder_number' => 'nullable|numeric|in:' . cylinder_number(),
            'fuel_type' => 'nullable|in:' . fuel_type(),
            'doors_number' => 'nullable|numeric',
            'start_engine_with_button' => 'nullable|boolean',
            'seat_adjustment' => 'nullable|boolean',
            'seat_heating_cooling_function' => 'nullable|boolean',
            'fog_lights' => 'nullable|boolean',
            'seat_massage_feature' => 'nullable|boolean',
            'seat_memory_feature' => 'nullable|boolean',
            'front_lighting' => 'nullable|in:' . front_lighting(),
            'electric_back_door' => 'nullable|boolean',
            'wheel_drive_system' => 'nullable|in:' . wheel_drive_system(),
            'specifications' => 'nullable|in:' . specifications(),
            'status' => 'nullable|in:' . status(),
            'insurance' => 'required_if:is_new,0|nullable|boolean',
            'insurance_month' => 'required_if:is_new,0|nullable|required_if:insurance,1', 'in:01,02,03,04,05,06,07,08,09,10,11,12',
            'insurance_year' => 'required_if:insurance,1|nullable|integer',
            'coverage_type' => 'nullable|in:' . coverage_type(),
            'start_with_fingerprint' => 'nullable|boolean',
            'remote_start' => 'nullable|boolean',
            'screen' => 'nullable|boolean',
            'seat_upholstery' => 'nullable|in:' . seat_upholstery(),
            'air_conditioning_system' => 'nullable|in:' . air_conditioning_system(),
            'windows_control' => 'nullable|in:' . windows_control(),
            'wheel_size' => 'nullable|in:' . wheel_size(),
            'wheel_type' => 'nullable|in:' . wheel_type(),
            'sunroof' => 'nullable|in:' . sunroof(),
            'selling_by_plate' =>'required_if:is_new,0|nullable|boolean',
            'number_plate' => 'required_if:selling_by_plate,1|nullable',
            'price_is_negotiable' => 'required_if:is_new,0|nullable|boolean',
            'location' => 'nullable|string',
            'additional_notes' => 'nullable',
            'price' => 'required|between:0,9999999999.99',
            'discount' => 'required_with:discount_type|between:0,9999999999.99',
            'discount_type' => 'nullable|in:percentage,amount',
            'availability' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'images.*.*' => 'required|image|max:10000',
            'color.*' => 'nullable|exists:colors,id',


        ];
    }

    public function messages()
    {
        return [
            'traveled_distance.required_if' => __('words.traveled_distance'),
            'traveled_distance_type.required_if' => __('words.traveled_distance_type'),
            'car_status.required_if' => __('words.car_status'),
            'guarantee.required_if' => __('words.guarantee'),
            'year.required_if' => __('words.year'),
            'month.required_if' => __('words.month'),
            'certified_maintenance.required_if' => __('words.certified_maintenance'),
            'selling_by_plate.required_if' => __('words.selling_by_plate'),
            'number_plate.required_if' => __('words.number_plate'),
            'price_is_negotiable.required_if' => __('words.price_is_negotiable'),
            'in_bahrain.required_if' => __('words.in_bahrain'),
            'country.required_if' => __('words.country'),
            'city.required_if' => __('words.city'),
            'area.required_if' => __('words.area_s'),
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $validator->after(function ($validator) {
                if ($this->is_new == 0) {
                    $validator->errors()->add('used', $this->is_new);
                }
            });
        }
    }
}
