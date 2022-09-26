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
            'available_payment_methods' => 'nullable|array|exists:payment_methods,' . $this->id,
        ];
    }
}
