<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class ControlOriginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request)->header('Access-Control-Allow-Origin', config('app.allowed_url'));
    }
}