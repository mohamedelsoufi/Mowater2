<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSpecialNumberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'exists:categories,id',
            'sub_category_id' => 'exists:categories,id',
            'number' => 'unique:special_numbers,number,'.$this->id,
            'size' => 'in:normal_plate,special_plate',
            'transfer_type' => 'in:waiver,own',
            'price' => 'required|numeric|between:0,999999999999999.99',
            'Include_insurance' => 'boolean',
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
