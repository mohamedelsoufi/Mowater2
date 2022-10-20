<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailableVehicleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'available_vehicles' => 'nullable|array',
            'available_vehicles.*' => 'exists:vehicles,id',
        ];
    }
}
