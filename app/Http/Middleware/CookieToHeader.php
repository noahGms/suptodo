<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CookieToHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->cookie('token_bearer')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->cookie('token_bearer'));
        }
        return $next($request);
    }
}
