<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCardRequest extends FormRequest
{
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
            'title_en' => 'required|unique:discount_cards,title_en,'.$this->id,
            'title_ar' => 'required|unique:discount_cards,title_ar,'.$this->id,
            'description_en'=> 'nullable|unique:discount_cards,description_en,'.$this->id,
            'description_ar'=> 'nullable|unique:discount_cards,description_ar,'.$this->id,
            'price'=>'required|between:0,9999999999.99',
            'year'=>'required|numeric',
            'image'=>'image|max:10000',
            'status'=>'required|in:'. discount_card_status(),
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
