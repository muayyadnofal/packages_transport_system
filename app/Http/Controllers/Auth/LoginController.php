<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\Sender;
use App\Models\Traveler;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Traits\HttpResponse;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use HttpResponse;

    private $traveler, $sender;

    public function __construct(ISender $sender, ITraveler $traveler)
    {
        $this->sender = $sender;
        $this->traveler = $traveler;
    }

    // login users into the system
    public function login(LoginRequest $request, $type): \Illuminate\Http\Response
    {
        $credentials = $request->all();
        $token = Auth::guard($type)->attempt($credentials);

        if (!$token) {
            return self::failure('invalid login details', 422);
        }

        // get user info
        $user = Auth::guard($type)->user();

        //check if the user has verified his email
        if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
            return self::failure('please verify your email then try again', 422);
        }

        $user['token'] =  $token;

        // return handled logged in response
        return self::returnData('user', new LoginResource($user), 'logged in successfully', 201);
    }
}
