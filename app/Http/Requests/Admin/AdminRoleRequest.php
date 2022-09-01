<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name_en' => 'required|unique:roles,name_en,'.$this->id,
            'name_ar' => 'required|unique:roles,name_ar,'.$this->id,
            'description_en' => 'required|unique:roles,description_en,'.$this->id,
            'description_ar' => 'required|unique:roles,description_ar,'.$this->id,
            'permissions' => 'required|min:1',
        ];
    }
}
