<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'price' => 'required|between:0,9999999999.99',
            'category_id' => 'exists:categories,id',
            'sub_category_id'=>'nullable|exists:sub_categories,id',
            'images.*' => 'image|max:10000',
            'discount'=> 'nullable|between:0,9999999999.99',
            'discount_type'=>'nullable|in:amount,percentage',
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
