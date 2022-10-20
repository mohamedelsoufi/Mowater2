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
            'vehicle_type' => 'required|in:' . rental_car_types(),
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacture_year' => 'required|numeric',
            'daily_rental_price' => 'required|between:0,9999999999.99',
            'weekly_rental_price' => 'required|between:0,9999999999.99',
            'monthly_rental_price' => 'required|between:0,9999999999.99',
            'yearly_rental_price' => 'required|between:0,9999999999.99',
            'cars_properties' => 'required|array',
            'cars_properties.*' => 'exists:rental_properties,id',
            'images' => 'required_without:id|array',
            'images.*' => 'image|max:10000',
            'color_id' => 'nullable|exists:colors,id',
            'available' => 'nullable|boolean',
            'active' => 'nullable|boolean',
            'active_number_of_views' => 'nullable|boolean',
        ];
    }
}
