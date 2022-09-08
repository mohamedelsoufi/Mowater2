<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminTrafficClearingOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'unique:traffic_clearing_offices,name_en,'.$this->id,
            'name_ar' => 'unique:traffic_clearing_offices,name_ar,'.$this->id,
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'tax_number' => 'unique:traffic_clearing_offices,tax_number,'.$this->id,
            'logo' => 'image|max:10000',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'year_founded' => 'nullable|numeric',
            'email' => 'required_without:id|email|unique:organization_users,email,'.$this->id,
            'password' => 'required_without:id|confirmed',
            'password_confirmation' => 'required_without:id|same:password',
            'user_name' => 'required_without:id',
        ];
    }
}
