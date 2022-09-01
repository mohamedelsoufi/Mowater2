<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVerifiedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // auth user
        $user = \auth('api')->user();
        if (!$user)
            return responseJson(0, __('message.user_not_registered'));
        if ($user->email != ''){
            {
                if ($user->is_verified == 0)
                {
                    return responseJson(0,'error','Verify your email ..');
                }
            }
        }
        return $next($request);
    }
}
