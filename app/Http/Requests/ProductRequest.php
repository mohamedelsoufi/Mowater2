<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required',//|unique:products,name_en,' . $this->id,
            'name_ar' => 'required',//|unique:products,name_ar,' . $this->id,
            'description_en' => 'required',//|unique:products,description_en,' . $this->id,
            'description_ar' => 'required',//|unique:products,description_ar,' . $this->id,
            'price' => 'required',
            'type' => 'required',
            'category_id'=>'exists:categories,id',
            'sub_category_id'=>'exists:sub_categories,id',
            'is_new' => 'required',
            'status'=>'required|in:' . g_status(),
            'images' => 'required_if:id,' . !$this->id,
            'images.*' => 'image|max:10000',
            'discount'=> 'between:0,9999999999.99',
            'discount_type'=>'in:amount,percentage',
            'discount_availability'=>'boolean',
//            'car_models'=>'required',
//            'category_id'=>'required|exists:categories,id'
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
