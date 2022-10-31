<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ReviewRequest;
use App\Http\Resources\Reviews\ShowReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function add_review(ReviewRequest $request)
    {
        try {
            $class = 'App\\Models\\' . $request->reviewable_type;
            $model = new $class;
            $record = $model->find($request->reviewable_id);

            if (!$record) {
                return responseJson(0, 'error',__('message.something_wrong'));
            }

            $user = getAuthAPIUser();

            $data = Review::create([
                'reviewable_type'=>$class,
                'reviewable_id'=>$request->reviewable_id,
                'user_id' => $user->id,
                'rate' => $request->rate,
                'review' => $request->review,
            ]);

            return responseJson(1, 'success', new ShowReviewResource($data));
        }catch (\Exception $e){
            return responseJson(0,'error',__('message.something_wrong'));
        }
    }
}
