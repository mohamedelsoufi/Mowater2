<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminInsuranceCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|unique:insurance_companies,name_en,' . $this->id,
            'name_ar' => 'required|unique:insurance_companies,name_ar,' . $this->id,
            'description_en' => 'nullable',
            'description_ar' => 'nullable',
            'tax_number' => 'nullable',
            'logo' => 'nullable|image|max:10000',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'area_id' => 'nullable|exists:areas,id',
            'year_founded' => 'nullable|numeric',
            'email' => 'required_without:id|email|unique:organization_users,email,' . $this->id,
            'password' => 'required_without:id|confirmed',
            'password_confirmation' => 'required_without:id|same:password',
            'user_name' => 'required_without:id',

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
