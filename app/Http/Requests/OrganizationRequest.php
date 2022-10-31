<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = auth()->guard('web')->user();

        $model_type = $user->organizable_type;
        $model = new $model_type;
        return [
            'name_en' => 'required|unique:' . $model->getTable() . ',name_en,' . $this->id,
            'name_ar' => 'required|unique:' . $model->getTable() . ',name_ar,' . $this->id,
//            'description_en' => 'required|unique:' . $model->getTable() . ',description_en,' . $this->id,
//            'description_ar' => 'required|unique:' . $model->getTable() . ',description_ar,' . $this->id,
            //'tax_number' => 'required|unique:'.$model->getTable().',tax_number,'.$this->id,
//            'tax_number' => 'required', //not required in driving trainers
//            'logo' => 'required_without:id|image|max:10000',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
//            'year_founded' => 'numeric', //not required in brokers
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            $validator->after(function ($validator) {
                if ($this->id != null) {
                    $validator->errors()->add('update_modal', $this->id);
                }
            });
        }
    }
}
