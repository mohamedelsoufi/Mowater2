<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminBrokerRequestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'unique:agencies,name_en',
            'name_ar' => 'unique:agencies,name_ar',
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'tax_number' => 'unique:brokers,tax_number',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'year_founded' => 'nullable|numeric',
            'email' => 'required_without:id|email|unique:organization_users,email,' . $this->id,
            'password' => 'required_without:id',
            'user_name' => 'required_without:id',
        ];
    }


}
