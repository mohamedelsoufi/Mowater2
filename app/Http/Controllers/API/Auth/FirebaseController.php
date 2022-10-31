<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\ShowUserRequest;
use App\Http\Requests\API\StoreFirebaseTokenRequest;
use App\Models\FirebaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FirebaseController extends Controller
{
    public function storeToken(StoreFirebaseTokenRequest $request)
    {
        try {
            $user = auth('api')->user()->id;
            $requested_data = $request->all();
            $requested_data['user_id'] = $user;
            $notification = FirebaseNotification::create($requested_data);

            return responseJson(1, 'success', $notification);
        } catch (\Exception $e) {
            return responseJson(1, 'error', $e->getMessage());
        }
    }

    public function getUserTokens()
    {
        try {
            $user_id = getAuthAPIUser()->id;
            $user = FirebaseNotification::where('user_id', $user_id)->get();
            return responseJson(1, 'success', $user);
        } catch (\Exception $e) {
            return responseJson(1, 'error', $e->getMessage());
        }
    }

    public function deleteUserTokens()
    {
        try {
            $user_id = getAuthAPIUser()->id;
            $tokens = FirebaseNotification::where('user_id', $user_id);
            $tokens->delete();

            return responseJson(1, 'success');
        } catch (\Exception $e) {
            return responseJson(1, 'error', $e->getMessage());
        }
    }

    public function deleteUserToken(Request $request)
    {
        try {
            $user_id = getAuthAPIUser()->id;
            $user = FirebaseNotification::where('user_id', $user_id)
                ->where('fcm_token', $request->device_token)->first();
            $user->delete();

            return responseJson(1, 'success');
        } catch (\Exception $e) {
            return responseJson(1, 'error', $e->getMessage());
        }
    }
}
