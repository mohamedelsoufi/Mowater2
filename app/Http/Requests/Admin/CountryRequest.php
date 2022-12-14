<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:countries,name_en,'.$this->id,
            'name_ar' => 'required|unique:countries,name_ar,'.$this->id,
            'image' => 'image|max:10000',
            'currency_id' => 'nullable|exists:currencies,id',
        ];
    }

    public function withValidator($validator)
    {
        if($validator->fails()){
            $validator->after(function ($validator) {
                if ($this->id != null) {
                    $validator->errors()->add('update_modal', $this->id);
                }
            });
        }
    }
}
