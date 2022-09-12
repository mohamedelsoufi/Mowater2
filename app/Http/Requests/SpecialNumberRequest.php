<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialNumberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'special_number_category_id' => 'required|exists:special_number_categories,id',
            'number' => 'required|unique:special_numbers,number,'.$this->id,
            'size' => 'required|in:normal_plate,special_plate',
            'transfer_type' => 'required|in:waiver,own',
            'price' => 'required|numeric|between:0,999999999999999.99',
//            'Include_insurance' => 'required|boolean',
            'special_number_organization_id ' => 'nullable|exists:special_number_organizations,id',
        ];
    }

    public function withValidator($validator)
    {
        if($validator->fails()){
            $validator->after(function ($validator) {
                if ($this->id != null) {
                    $validator->errors()->add('update_modal', $this->id);
                }
            });
        }
    }
}
