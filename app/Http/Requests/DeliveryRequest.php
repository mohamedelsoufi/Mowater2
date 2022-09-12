<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:delivery_man,name_en,' . $this->id,
            'name_ar' => 'required|unique:delivery_man,name_ar,' . $this->id,
//            'manufacturing_year' => 'required',
            'country_id' => 'required|exists:countries,id',
//            'gender'=>'required',
//            'city_id' => 'required|exists:cities,id',
//            'area_id' => 'required|exists:areas,id',
//            'car_class_id' => 'required|exists:car_classes,id',
//            'brand_id' => 'required|exists:brands,id',
//            'category_id' => 'required|exists:categories,id',
//            'car_model_id' => 'required|exists:car_models,id',
            'email' => 'required_without:id|email|unique:organization_users,email,'.$this->id,
            'password' => 'required_without:id|confirmed',
            'password_confirmation' => 'required_without:id|same:password',
            'user_name' => 'required_without:id',
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
