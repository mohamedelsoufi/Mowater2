<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReserveDeliveryManRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'delivery_man_id'=>'required|exists:delivery_man,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'category_id' => 'required|exists:categories,id',
            'day_to_go' => 'required',
            'from' => 'required',
            'to' => 'required',
            'address' => 'required',
            'distinctive_mark' => 'nullable',
            'request_type' => 'required|in:single,repetitive',
            'number_of_repetitions'=>'required_if:request_type,repetitive',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new ValidationException($validator, $response);
    }
}
