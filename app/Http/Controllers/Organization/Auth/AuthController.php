<?php

namespace App\Http\Controllers\Organization\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('guest:web')->only('organization.login');
//    }

    public function login()
    {
        return view('organization.auth.login');
    }

    public function home()
    {
        return view('organization.home');
    }

    public function authenticate(OrganizationUserRequest $request)
    {
//        return $request;
        $remember_me = $request->has('remember_me') ? true : false;
        $user = Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password,'active' => 1], $remember_me);
        if ($user) {
            $request->session()->regenerate();

            return redirect()->route('organization.home');
        }
        return redirect()->back()->with(['error'=>__('message.invalid_login')]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('organization.login');
    }
}
