<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class GetLookingUpBranchesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'model_type' => 'required|in:Agency,CarShowroom,Garage,RentalOffice,SpecialNumberOrganization,Wench',
            'model_id' => 'required',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'product_id' => 'nullable|exists:products,id',
            'service_id' => 'nullable|exists:services,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0, 'error', $validator->errors());
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
