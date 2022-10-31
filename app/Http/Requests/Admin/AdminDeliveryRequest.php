<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required',
            'name_ar' => 'required',
//            'manufacturing_year' => 'required',
            'gender' => 'required|in:male,female',
            'country_id' => 'required|exists:countries,id',
//            'car_class_id' => 'required|exists:car_classes,id',
//            'brand_id' => 'required|exists:brands,id',
//            'car_model_id' => 'required|exists:car_models,id',
            'category_id' => 'required|array|min:1|exists:categories,id',
            'email' => 'required_without:id|email|unique:organization_users,email,' . $this->id,
            'password' => 'required_without:id',
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
