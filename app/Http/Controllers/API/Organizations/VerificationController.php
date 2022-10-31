<?php

namespace App\Http\Controllers\API\Organizations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verifications(Request $request)
    {

        $rules = [
            'model_type' => 'required|in:SpecialNumber',
            'model_id' => 'required'
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }


        $class = 'App\\Models\\' . $request->model_type; // 'App\\Models\Product'
        $model = new $class;               // $model = Product
        $record = $model->find($request->model_id); // $record = Product::find(1);

        if (!$record) {
            return responseJson(0, 'error');
        }

        $client = auth('api')->user();

        //return $client;

        $data = $record->verifications()->attach($client->id);

        return responseJson(1, 'success');


    }
}
