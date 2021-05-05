<?php

namespace App\Http\Middleware;

use App\Models\Error;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return response()->json(new Error('Unauthorized. You must be authentified.'), 401);
        }

        return $next($request);
    }
}
