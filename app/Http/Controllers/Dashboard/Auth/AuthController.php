<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function home()
    {
        return view('admin.home');
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

//        $remember_me = $request->has('remember_me') ? true : false;
        $user = Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1]);
        if ($user) {
            $request->session()->regenerate();

            return redirect()->route('admin.home');
        }
        return redirect()->back()->with(['error' => __('message.invalid_login')]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('dashboard.login');
    }
}
