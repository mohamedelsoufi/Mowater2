<?php

namespace App\Http\Middleware\Organization;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasContactMiddleware
{
    public function handle(Request $request, Closure $next, $per)
    {
        $user = Auth::guard('web')->user();
        $model_type = $user->organizable_type;
        $model_id = $user->organizable_id;
        $model = new $model_type;
        $data = $model->find($model_id);
        if (auth('web')->user()->hasPermission([$per . '-contact-' . $data->name_en]))
            return $next($request);

        else abort(404);
        return $next($request);
    }
}
