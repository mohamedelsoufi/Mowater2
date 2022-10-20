<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class AdRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title_en' => 'required|unique:ads,title_en,'.$this->id,
            'title_ar' => 'required|unique:ads,title_ar,'.$this->id,
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'ad_type_id' => 'required_without:id|exists:ad_types,id',
            'module_type' => 'required_unless:ad_type_id,4|nullable',
            'link' => 'required_if:ad_type_id,4|nullable|url',
            'image' => 'required_without:id|image|max:10000',
            'price' => 'required|between:0,9999999999.99',
            'negotiable' => 'required|boolean',
            'start_date' => 'required',
            'end_date' => 'required',
            'country_id' => 'required',
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
