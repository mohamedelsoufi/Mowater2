<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\FirebaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirebaseController extends Controller
{
    public function storeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required',
            'platform' => 'nullable',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $user = auth('api')->user()->id;
        $validator = $request->all();
        $validator['user_id'] = $user;
        $notification = FirebaseNotification::create($validator);

        return responseJson(1, 'success', $notification);
    }

    public function deleteToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails())
            return responseJson(0, $validator->errors());
        $user = FirebaseNotification::where('user_id', $request->user_id);
        $user->delete();

        return responseJson(1, 'success');
    }
}
