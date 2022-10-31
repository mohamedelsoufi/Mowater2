<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'from' => 'required',
            'to' => 'required',
            'duration' => 'required|numeric',
            'work_days' => 'required|array',
        ];
    }
}
