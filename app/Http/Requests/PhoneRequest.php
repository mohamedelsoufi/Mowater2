<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country_code' => 'required',
            'phone' => 'required|integer',
            'title_en' => 'nullable|max:255',
            'title_ar' => 'nullable|max:255',
        ];
    }
}
