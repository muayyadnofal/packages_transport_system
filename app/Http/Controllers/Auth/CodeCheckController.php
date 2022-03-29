<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CodeCheckRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\ResetCodePassword;
use App\Models\Sender;
use App\Models\Traveler;
use App\Repositories\Contracts\IResetCodePassword;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class CodeCheckController extends Controller
{
    use HttpResponse;

    private $request;

    public function __construct(ISender $sender, ITraveler $traveler, IResetCodePassword $reset)
    {
        $this->sender = $sender;
        $this->traveler = $traveler;
        $this->reset = $reset;
    }

    public function check(CodeCheckRequest $request): \Illuminate\Http\Response
    {
        // find the code
        $passwordReset = $this->reset->findWhereFirst('code', $request->code);

        // check if it does not expire: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return self::failure('password reset code has expired', 422);
        }

        // find user's email
        if ($request->role == 'sender') {
            $user = $this->sender->findWhereFirst('email', $passwordReset->email);
        }

        if ($request->role == 'traveler') {
            $user = $this->traveler->findWhereFirst('email', $passwordReset->email);
        }

        // update user password
        $user->forceFill(['password' => bcrypt($request->password)])->save();

        // delete current code
        $passwordReset->delete();

        return self::success('password reset successful', 200);
    }
}
