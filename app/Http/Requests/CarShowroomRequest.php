<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarShowroomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_en' => 'required|unique:car_showrooms,name_en,'.$this->id,
            'name_ar' => 'required|unique:car_showrooms,name_ar,'.$this->id,
            'description_en' => 'required|unique:car_showrooms,description_en,'.$this->id,
            'description_ar' => 'required|unique:car_showrooms,description_ar,'.$this->id,
            'tax_number' => 'required|unique:car_showrooms,tax_number,'.$this->id,
            'logo' => 'required_without:id|image|max:10000',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'year_founded' => 'required|numeric',
            'email' => 'required_without:id|email|unique:organization_users,email,'.$this->id,
            'password' => 'required_without:id',
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
