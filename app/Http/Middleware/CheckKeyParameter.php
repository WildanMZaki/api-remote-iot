<?php

namespace App\Http\Middleware;

use Closure;

class CheckKeyParameter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('key') || $request->query('key') != env('API_KEY', `@p1|<ey123`)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Forbidden!!'
            ], 401);
        }

        return $next($request);
    }
}