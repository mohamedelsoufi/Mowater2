<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'facebook_link' => 'nullable|url',
            'whatsapp_number' => 'nullable|max:255',
            'country_code' => 'required',
            'phone' => 'nullable|integer',
            'website' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ];
    }
}
