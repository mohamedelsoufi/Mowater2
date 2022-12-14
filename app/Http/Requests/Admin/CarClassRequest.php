<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CarClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:car_classes,name_en,'.$this->id,
            'name_ar' => 'required|unique:car_classes,name_ar,'.$this->id,
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
