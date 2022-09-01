<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreTrafficClearingOfficeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'traffic_clearing_service_id' => 'required|exists:traffic_clearing_services,id',
            'first_name' => 'required',
            'last_name' => 'required',
            'nickname' => 'required',
            'country_code' => 'required',
            'phone' => 'required|integer',
            'nationality' => 'required',
            'id_type' => 'required|in:passport,national_id',
            'personal_id' => 'required',
            'smart_card_expiry_date' => 'required|date',
            'date' => 'required_if:traffic_clearing_service_id,1,3,4,6|date',
            'is_mawater_card' => 'required|boolean',
            'barcode' => 'required_if:is_mawater_card,1|exists:discount_card_users,barcode',
            'chassis_number' => 'required_if:traffic_clearing_service_id,1,3,4,6',
            'number_plate' => 'required',
            'brand_id' => 'required_if:traffic_clearing_service_id,5|exists:brands,id',
            'car_model_id' => 'required_if:traffic_clearing_service_id,5|exists:brands,id',
            'car_class_id' => 'required_if:traffic_clearing_service_id,5|exists:brands,id',
            'manufacturing_year' => 'required_if:traffic_clearing_service_id,5|numeric',
            'smart_card_id' => 'required_if:traffic_clearing_service_id,5|image|max:10000',
            'vehicle_ownership' => 'required_if:traffic_clearing_service_id,5|image|max:10000',
            'disclaimer_image' => 'required_if:traffic_clearing_service_id,5|image|max:10000',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = responseJson(0,'error',$validator->errors());
        throw new ValidationException($validator,$response);
    }
}
