<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         try {
            $request->headers->set('Accept', 'application/json');
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response('Invalid Token')->setStatusCode(401);
        } 

        return $next($request);
    }
}
