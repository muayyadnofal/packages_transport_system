<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\Sender;
use App\Models\Traveler;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HttpResponse;

    private $request;

    // login user by type
    public function login(LoginRequest $request, $type): \Illuminate\Http\Response
    {
        $this->request = $request;

        if ($type == 'traveler') {
            return $this->loginByType('traveler');
        }

        else if ($type == 'sender') {
            return $this->loginByType('sender');
        }

        return self::failure('page not found', 404);
    }

    // attempt user info and create a token to user
    private function loginByType($guard): \Illuminate\Http\Response
    {
        $credentials = $this->request->all()                                                                                                                                                                    ;
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
        return self::returnData('user', new LoginResource($user), 'logged in successfully', 201);
    }
}
