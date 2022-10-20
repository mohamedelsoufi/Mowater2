<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalPropertyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_ar' => 'required|unique:rental_properties,name_ar,' . $this->id,
            'name_en' => 'required|unique:rental_properties,name_en,' . $this->id,
            'description_ar' => 'required',
            'description_en' => 'required',
        ];
    }
}
