<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MailRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Models\Sender;
use App\Models\Traveler;
use App\Models\User;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    use HttpResponse;

    private $traveler, $sender;

    public function __construct(ISender $sender, ITraveler $traveler)
    {
        $this->sender = $sender;
        $this->traveler = $traveler;
    }

    private $mailRequest, $verifyRequest;

    public function verifyTraveler(Request $request, Traveler $user): \Illuminate\Http\Response
    {
        // check if the url is a valid signed url
        if (! URL::hasValidSignature($request)) {
            return self::failure('invalid verification link', 422);
        }

        // check if user has already verified his Email
        if($user->hasVerifiedEmail()) {
            return self::failure('Already verified', 422);
        }

        // verify user email
        $user->markEmailAsVerified();
        return self::success('user verified successfully', 200);
    }

    public function verifySender(Request $request, Sender $user): \Illuminate\Http\Response
    {
        // check if the url is a valid signed url
        if (! URL::hasValidSignature($request)) {
            return self::failure('invalid verification link', 422);
        }

        // check if user has already verified his Email
        if($user->hasVerifiedEmail()) {
            return self::failure('Already verified', 422);
        }

        // verify user email
        $user->markEmailAsVerified();
        return self::success('user verified successfully', 200);
    }

    // resent email verification link
    public function resend(MailRequest $request, $type): \Illuminate\Http\Response
    {
        $user = [];
        if ($type == 'traveler') {
            $user = $this->traveler->findWhereFirst('email', $request->email);
        }

        else if ($type == 'sender') {
            $user = $this->sender->findWhereFirst('email', $request->email);
        }

        // check if user has already verified his Email
        if($user->hasVerifiedEmail()) {
            return self::failure('Already verified', 422);
        }

        // send email verification
        $user->sendEmailVerificationNotification();
        return self::success('verification link sent', 200);
    }
}
