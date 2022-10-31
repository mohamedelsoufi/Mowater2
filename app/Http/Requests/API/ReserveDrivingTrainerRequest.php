<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ReserveDrivingTrainerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'driving_trainer_id' => 'required|exists:driving_trainers,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'age' => 'required|numeric',
            'is_previous_license' => 'required|boolean',
            'attended_the_theoretical_driving_training_session' => 'required|boolean',
            'training_type_id' => 'required|exists:training_types,id',
            'session.*.date' => 'required',
            'session.*.time' => 'required',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator,$response);
    }
}
