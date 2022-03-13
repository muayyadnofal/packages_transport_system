<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CodeCheckRequest;
use App\Models\ResetCodePassword;
use App\Models\Sender;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class CodeCheckController extends Controller
{
    use HttpResponse;

    public function check(CodeCheckRequest $request): \Illuminate\Http\Response
    {
        // find the code
        $passwordReset = ResetCodePassword::where('code', $request->code)->first();

        // check if it does not expire: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return self::failure('password reset code has expired', 422);
        }

        // find user's email
        $user = Sender::where('email', $passwordReset->email)->first();

        // update user password
        $user->forceFill(['password' => bcrypt($request->password)])->save();

        // delete current code
        $passwordReset->delete();

        return self::success('password reset successful', 200);
    }
}
