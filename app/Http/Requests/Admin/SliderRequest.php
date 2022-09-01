<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
        if ($this->type == 'video_home_slider'){
            return [
                'slider_file.*' => 'nullable|mimes:mp4,flv,m3u8,3gp,mov,avi,wmv|max:10000000',
            ];
        }elseif ($this->type == 'section'){
            return [
                'slider_file.*' => 'nullable|mimes:mp4,flv,m3u8,3gp,mov,avi,wmv,jpeg,png,jpg,gif,svg|max:10000000',
            ];
        }else{
            return [
                'slider_file.*' => 'nullable|image|max:10000',
            ];
        }

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
