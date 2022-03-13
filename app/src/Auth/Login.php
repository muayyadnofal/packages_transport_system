<?php

namespace App\src\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Login
{
    use HttpResponse;

    private $request;

    public function __construct($guard)
    {
        $this->request = new LoginRequest();
        $this->login($guard);
    }

    private function login($guard): \Illuminate\Http\Response
    {
        $credentials = $this->request->only(['email', 'password']);
        $token = Auth::guard($guard)->attempt($credentials);

        if (!$token) {
            return self::failure('invalid login details', 422);
        }

        // get user info
        $user = Auth::guard($guard)->user();

        //check if the user has verified his email
        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return self::failure('please verify your email then try again', 422);
        }
        $user['token'] =  $token;

        // return handled logged in response
        return self::returnData($user->type, new LoginResource($user), 'logged in successfully', 201);
    }
}
