<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:wenches,name_en,'.$this->id,
            'name_ar' => 'required|unique:wenches,name_ar,'.$this->id,
            'address_en' => 'nullable',
            'address_ar' => 'nullable',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'email' => 'required_without:id|email|unique:organization_users,email,'.$this->id,
            'password' => 'required_without:id',
            'user_name' => 'required_without:id',
        ];
    }

}
