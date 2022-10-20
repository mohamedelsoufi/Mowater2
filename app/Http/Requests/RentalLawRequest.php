<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalLawRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title_ar' => 'required|unique:rental_laws,title_ar,' . $this->id,
            'title_en' => 'required|unique:rental_laws,title_en,' . $this->id,
        ];
    }
}
