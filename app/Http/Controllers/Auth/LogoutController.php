<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    use HttpResponse;

    public function logout(Request $request): \Illuminate\Http\Response
    {
        // take the token from the header __auth token
        $token = $request->bearerToken();

        // return error if token fails
        if (!$token) {
            return self::failure('some thing went wrong', 422);
        }

        // delete the token if it's true
        try {
            JWTAuth::setToken($token)->invalidate();
        } catch (TokenInvalidException $ex) {
            return self::failure('some thing went wrong', 422);
        }
        return self::success('logged out successfully', 200);
    }
}
