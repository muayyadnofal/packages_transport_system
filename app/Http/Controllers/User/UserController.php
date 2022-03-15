<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sender\SenderResource;
use App\Http\Resources\User\UserResource;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponse;

    public function getMyInfo(): \Illuminate\Http\Response
    {
        $user = auth()->user();
        return self::returnData('user', new UserResource($user), 'user info', 200);
    }
}
