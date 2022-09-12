<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainVehicleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_type' => 'required|in:'.vehicle_type(),
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required|numeric',
            'body_shape' => 'required|in:'.body_shape(),
            'engine' => 'required',
            'fuel_type' => 'required|in:'.fuel_type(),
            'passengers_number' => 'required|numeric',
            'doors_number' => 'required|numeric',
            'start_engine_with_button' => 'required|boolean',
            'seat_adjustment' => 'required|boolean',
            'steering_wheel' => 'required|boolean',
            'ambient_interior_lighting' => 'required|boolean',
            'seat_heating_cooling_function' => 'required|boolean',
            'remote_engine_start' => 'required|boolean',
            'manual_steering_wheel_tilt_and_movement' => 'required|boolean',
            'automatic_steering_wheel_tilt_and_movement' => 'required|boolean',
            'child_seat_restraint_system' => 'required|boolean',
            'steering_wheel_controls' => 'required|boolean',
            'seat_upholstery' => 'required|in:'.seat_upholstery(),
            'air_conditioning_system' => 'required|boolean',
            'electric_windows' => 'required|in:'.electric_windows(),
            'car_info_screen' => 'nullable',
            'seat_memory_feature' => 'required|boolean',
            'sunroof' => 'required|in:'.sunroof(),
            'interior_embroidery' => 'required|boolean',
            'side_awnings' => 'required|boolean',
            'seat_massage_feature' => 'required|boolean',
            'air_filtration' => 'required|boolean',
            'car_gear_shift_knob' => 'required|in:'.car_gear_shift_knob(),
            'front_lighting' => 'required|in:'.front_lighting(),
            'side_mirror' => 'required|boolean',
            'tire_type_and_size' => 'required',
            'roof_rails' => 'required|boolean',
            'electric_back_door' => 'required|boolean',
            'transparent_coating' => 'required|in:'.transparent_coating(),
            'toughened_glass' => 'required|boolean',
            'back_lights' => 'required|in:'.back_lights(),
            'fog_lights' => 'required|boolean',
            'daytime_running_lights' => 'required|boolean',
            'automatically_closing_doors' => 'required|boolean',
            'roof' => 'required|in:'.roof(),
            'rear_spoiler' => 'required|boolean',
            'Electric_height_adjustment_for_headlights' => 'required|boolean',
            'back_space' => 'required',
            'keyless_entry_feature' => 'required|boolean',
            'sensitive_windshield_wipers_rain' => 'required|boolean',
            'weight' => 'required',
            'injection_type' => 'required|in:'.injection_type(),
            'determination' => 'nullable',
            'fuel_tank_capacity' => 'required',
            'fuel_consumption' => 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $validator->after(function ($validator) {
                if ($this->id != null) {
                    $validator->errors()->add('update_modal', $this->id);
                }
            });
        }
    }
}
