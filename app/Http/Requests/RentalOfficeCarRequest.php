<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalOfficeCarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'vehicle_type' => 'required|in:' . vehicle_type(),
            'ghamara_count' => ['required_if:vehicle_type,pickups'],
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacture_year' => 'required|max:255',
            'color' => 'required|max:255',
            'daily_rental_price' => 'nullable|numeric',
            'weekly_rental_price' => 'nullable|numeric',
            'monthly_rental_price' => 'nullable|numeric',
            'yearly_rental_price' => 'nullable|numeric',
            'available' => 'nullable'
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
