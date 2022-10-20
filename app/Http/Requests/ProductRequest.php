<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required',//|unique:products,name_en,' . $this->id,
            'name_ar' => 'required',//|unique:products,name_ar,' . $this->id,
            'description_en' => 'nullable',//|unique:products,description_en,' . $this->id,
            'description_ar' => 'nullable',//|unique:products,description_ar,' . $this->id,
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'car_class_id' => 'required|exists:car_classes,id',
            'manufacturing_year' => 'required_without:id|numeric',
            'price' => 'required',
            'type' => 'required',
            'category_id'=>'exists:categories,id',
            'sub_category_id'=>'nullable|exists:sub_categories,id',
            'is_new' => 'required',
            'status'=>'required|in:' . g_status(),
            'images' => 'required_if:id,' . !$this->id,
            'images.*' => 'image|max:10000',
            'discount_type'=>'nullable|in:amount,percentage',
            'discount_value'=>'nullable|between:0,9999999999.99',
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
