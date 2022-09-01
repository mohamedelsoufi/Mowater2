<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|unique:sections,name_en,'.$this->id,
            'name_ar' => 'required|unique:sections,name_ar,'.$this->id,
            'section_id' => 'nullable|exists:sections,id',
            'reservation_cost_type' => 'required|in:amount,discount',
            'reservation_cost' => 'required|numeric|between:0,999999999999999.99',
            //'image' => 'required|image'
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
