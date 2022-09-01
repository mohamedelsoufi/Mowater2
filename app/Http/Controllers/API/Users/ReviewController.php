<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function add_review(Request $request)
    {
        $rules = [
            'reviewable_type' => 'required|in:Agency,CarShowroom,Garage,RentalOffice,SpecialNumber,Wench',
            'reviewable_id' => 'required',
            'rate' => 'required|between:0,99.99',
            'review' => 'required|string|max:255',
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $class = 'App\\Models\\' . $request->reviewable_type; // 'App\\Models\Product'
        $model = new $class;               // $model = Product
        $record = $model->find($request->reviewable_id); // $record = Product::find(1);

        if (!$record) {
            return responseJson(0, 'error');
        }

        $user = auth('api')->user();

        $data = Review::create([
            'reviewable_type'=>$class,
            'reviewable_id'=>$request->reviewable_id,
            'user_id' => $user->id,
            'rate' => $request->rate,
            'review' => $request->review,
        ]);

        return responseJson(1, 'success', $data);

    }
}
