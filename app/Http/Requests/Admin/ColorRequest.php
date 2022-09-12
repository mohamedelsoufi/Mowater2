<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'color_code' => 'required|unique:colors,color_code,'.$this->id,
            'color_name' => 'required|unique:colors,color_name,'.$this->id,
            'color_name_ar' => 'required|unique:colors,color_name_ar,'.$this->id,
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
