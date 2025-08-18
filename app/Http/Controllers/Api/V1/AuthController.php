<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateRequest;

use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function authenticate(AuthenticateRequest $request)
    {
        try
        {
            $credentials = $request->validated();
            if (! $token = JWTAuth::attempt($credentials)) {
                return response('Invalid credential','401');
            }
            $user = auth()->user();
            $token = JWTAuth::fromUser($user);
            $cookie = cookie('token',$token,120,null,null,null,true);
            return response(['access_token' => $token],'200')->withCookie($cookie);
        } catch (Exception $e) {
            return response('Internal Server Error','500');
        }
    }
    public function logout()
    {
        $cookie = cookie('token',null,-1,null,null,null,true);
        return response('','200')->withCookie($cookie);
    }
}
