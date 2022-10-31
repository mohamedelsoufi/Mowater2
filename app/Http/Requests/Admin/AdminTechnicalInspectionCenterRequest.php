<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminTechnicalInspectionCenterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:technical_inspection_centers,name_en,'.$this->id,
            'name_ar' => 'required|unique:technical_inspection_centers,name_ar,'.$this->id,
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'address' => 'nullable',
            'tax_number' => 'unique:technical_inspection_centers,tax_number,'.$this->id,
            'logo' => 'image|max:10000',
            'city_id' => 'required|exists:cities,id',
            'email' => 'required_without:id|email|unique:organization_users,email,'.$this->id,
            'password' => 'required_without:id|confirmed',
            'password_confirmation' => 'required_without:id|same:password',
            'user_name' => 'required_without:id',
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
