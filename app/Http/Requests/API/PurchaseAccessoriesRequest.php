<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class PurchaseAccessoriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'accessories_store_id' => 'required|exists:accessories_stores,id',
            'accessories' =>'required|array',
            'accessories.*' =>'exists:accessories,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nickname' => 'required|string',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'home_delivery' => 'required|boolean',
            'address' => 'required_if:home_delivery,1',
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
            'owen_vehicles' => 'required_if:is_mawater_card,1|array',
            'owen_vehicle.*.id' => 'required_if:is_mawater_card,1|exists:vehicles,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator,$response);
    }
}
