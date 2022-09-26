<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminAdRequest extends FormRequest
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
            'ref_name' => 'required_without:id|exists:sections,ref_name',
            'ad_type_id' => 'required_without:id|exists:ad_types,id',
            'link' => 'required_if:ad_type_id,4|nullable|url',
            'image' => 'required_without:id|image|max:10000',
            'price' => 'required|between:0,9999999999.99',
            'negotiable' => 'required|boolean',
            'status' => 'required|in:'.ad_status(),
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }
}
