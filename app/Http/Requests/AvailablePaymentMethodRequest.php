<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailablePaymentMethodRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'available_payment' => 'nullable|array',
            'available_payment.*' => 'exists:payment_methods,id',
        ];
    }
}
