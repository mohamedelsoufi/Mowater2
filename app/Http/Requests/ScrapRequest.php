<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScrapRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:scraps,name_en,' . $this->id,
//            'name_ar' => 'required|unique:scraps,name_ar,' . $this->id,
//            'description_en' => 'required|unique:scraps,description_en,' . $this->id,
//            'description_ar' => 'required|unique:scraps,description_ar,' . $this->id,
//            'brand_id' => 'required|exists:brands,id',
//            'tax_number' => 'required|unique:scraps,tax_number,' . $this->id,
//            'logo' => 'required_without:id|image|max:10000',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
//            'year_founded' => 'numeric',
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
