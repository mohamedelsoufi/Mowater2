<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = auth('api')->user();
        return [
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'nickname' => 'nullable|string|max:50',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'date',
            'phone' => ['nullable', 'integer', Rule::unique('users')->ignore($user->id)],
            'phone_code' => 'required',
            'nationality' => 'nullable|in:GCC,Foreign',
            'country_id' => 'nullable|exists:countries,id',
            'city_id' => 'nullable|exists:cities,id',
            'area_id' => 'nullable|exists:areas,id',
            'profile_image' => 'image|max:10000',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, $validator->errors());
        throw new ValidationException($validator, $response);
    }
}
