<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CodeCheckRequest;
use App\Models\ResetCodePassword;
use App\Models\Sender;
use App\Models\Traveler;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class CodeCheckController extends Controller
{
    use HttpResponse;

    private $request;

    public function check(CodeCheckRequest $request, $type): \Illuminate\Http\Response
    {
        $this->request = $request;

        if ($type == 'sender') {
            return $this->checkForUser(Sender::class);
        }

        else if ($type == 'traveler') {
            return $this->checkForUser(Traveler::class);
        }

        return self::failure('page not found', 404);
    }

    private function checkForUser($model): \Illuminate\Http\Response
    {
        // find the code
        $passwordReset = ResetCodePassword::where('code', $this->request->code)->first();

        // check if it does not expire: the time is one hour
        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return self::failure('password reset code has expired', 422);
        }

        // find user's email
        $user = $model::where('email', $passwordReset->email)->first();

        // update user password
        $user->forceFill(['password' => bcrypt($this->request->password)])->save();

        // delete current code
        $passwordReset->delete();

        return self::success('password reset successful', 200);
    }
}
