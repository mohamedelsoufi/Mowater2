<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\RegisterUserRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Http\Requests\API\UserChangePasswordRequest;
use App\Http\Requests\API\UserForgotPasswordRequest;
use App\Http\Requests\API\UserResetForgottenPasswordRequest;
use App\Mail\APIForgetPasswordMail;
use App\Mail\APIRegisterMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    //login
    public function login()
    {
        $data = request()->username;

        $fieldType = filter_var($data, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [$fieldType => $data, 'password' => \request()->password, 'active' => 1];

        if (!$token = auth('api')->attempt($credentials)) {
            return responseJson(0, 'Unauthorized');
        }
        return responseJson(1, 'success', ['token' => $token, 'user' => \auth('api')->user()]);
    }

    //logout
    public function logout()
    {
        auth('api')->logout();
        auth('api')->invalidate();
        return responseJson(1, 'success');
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    //register
    public function register(RegisterUserRequest $request)
    {
        try {
            $nickname = $request->nickname;
            $name = $request->first_name . ' ' . $request->last_name;
            $email = $request->email;

            $validator = $request->except(['profile_image']);
            $default_img = 'default-profile-image.png';

            if ($request->has('profile_image')) {
                $image = $request->profile_image->store('api_profile_images');
                $validator['profile_image'] = $image;
            }

            $validator['profile_image'] = $default_img;

            DB::beginTransaction();
            $user = User::create($validator);
            $token = JWTAuth::fromUser($user);

            if ($request->has('email')) {
                $verification_code = Str::random(50); //Generate verification code

                DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verification_code]);

                $subject = "Please verify your email address.";

//                Mail::send('API.verify-email', ['name' => $name, 'nickname' => $nickname, 'verification_code' => $verification_code],
//                    function ($mail) use ($email, $name, $subject) {
//                        $mail->from(getenv('MAIL_FROM_ADDRESS'), getenv('APP_NAME'));
//                        $mail->to($email, $name);
//                        $mail->subject($subject);
//                    });
                $details = [
                    'name' => $name,
                    'nickname' => $nickname,
                    'verification_code' => $verification_code
                ];
                Mail::to($email)->send(new APIRegisterMail($details));
            }

            DB::commit();
            return responseJson(1, 'success', ['token' => $token, 'user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(0, 'error', __('message.something_wrong'));
        }

    }

    // verification email
    public function verifyUser($verification_code)
    {
        $check = DB::table('user_verifications')->where('token', $verification_code)->first();

        if (!is_null($check)) {
            $user = User::find($check->user_id);

            if ($user->is_verified == 1) {
                return responseJson(1, 'success', 'Account already verified..');
            }

            $user->update(['is_verified' => 1]);
            DB::table('user_verifications')->where('token', $verification_code)->delete();

            $success_msg = 'You have successfully verified your email address.';
            return view('API.verified');
//            return responseJson(1, 'success', 'You have successfully verified your email address.');
        }
        $error_msg = 'Verification code is invalid.';
        return view('API.invalid-verification');
//        return responseJson(0, 'error', 'Verification code is invalid.');

    }

    //update
    public function update(UpdateUserRequest $request)
    {
        try {
            $user = auth('api')->user();
            if (!$user)
                return responseJson(0, __('message.user_not_registered'));
            $request->merge([
                'id' => $user->id
            ]);

            $validator = $request->except(['profile_image']);

            if ($request->has('profile_image')) {
                $image_path = public_path('uploads/');
                if (File::exists($image_path . $user->getRawOriginal('profile_image'))) {
                    File::delete($image_path . $user->getRawOriginal('profile_image'));
                }

                $image = $request->profile_image->store('api_profile_images');
                $validator['profile_image'] = $image;
            }

            $user->update($validator);
            $get_user = $user->refresh();

            return responseJson(1, 'success', $get_user);
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(0, 'error', __('message.something_wrong'));
        }
    }

    // change password
    public function changePassword(UserChangePasswordRequest $request)
    {
        try {
            $user = auth('api')->user();
            $check_pass = Hash::check($request->oldPassword, $user->password);

            if ($check_pass) {
                $user->update([
                    'password' => $request->new_password,
                ]);
                return responseJson(1, 'success');
            }
            return responseJson(1, 'error');
        } catch (\Exception $e) {
            return responseJson(1, 'error', $e->getMessage());
        }
    }

    //
    private function userInForgotPassword($request)
    {
        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        return $user;
    }

    //forget password
    public function forgetPassword(UserForgotPasswordRequest $request)
    {
        try {
            $user = $this->userInForgotPassword($request);
            $verification_code = mt_rand(132546, 978564);
            DB::table('forget_password')->insert(['user_id' => $user->id, 'verification_code' => $verification_code]);

            $details = [
                'name' => $user->first_name . ' ' . $user->last_name,
                'nickname' => $user->nickname,
                'verification_code' => $verification_code
            ];

            Mail::to($user->email)->send(new APIForgetPasswordMail($details));
            return responseJson(1, 'success', 'please check your email');
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(0, 'error', __('message.something_wrong'));
        }
    }

    // reset forgotten password
    public function resetForgottenPassword(UserResetForgottenPasswordRequest $request)
    {
        try {
            $user = $this->userInForgotPassword($request);
            $check_verification = DB::table('forget_password')->where('user_id', $user->id)
                ->where('verification_code', $request->verification_code)->first();
            if ($check_verification) {
                $user->update([
                    'password' => $request->new_password
                ]);
                return responseJson(1, 'success', __('message.updated_successfully'));
            }
            return responseJson(0, 'error', 'verification code or email is wrong');
        } catch (\Exception $e) {
            DB::rollBack();
            return responseJson(0, 'error', __('message.something_wrong'));
        }
    }

    //profile
    public function profile()
    {
        try {
            $user = auth('api')->user();
            return responseJson(1, 'success', $user);
        }catch (\Exception $e) {
            DB::rollBack();
            return responseJson(0, 'error', __('message.something_wrong'));
        }
    }

//update firebase token
    public function updateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => 'required',
            'device_token' => 'required',
            'platform' => 'nullable',
        ]);

        if ($validator->fails()) {
            return responseJson(0, $validator->errors());
        }
        try {
            $user = auth('api')->user();
            if (!$user)
                return responseJson(0, __('message.user_not_registered'));

            $data = $user->update($request->only('fcm_token', 'device_token', 'platform'));
            return responseJson(1, 'success', $data);
        } catch (\Exception $e) {
            report($e);
            return responseJson(0, 'error', $e->getMessage());
        }
    }

}
