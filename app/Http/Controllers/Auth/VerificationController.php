<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MailRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Models\Sender;
use App\Models\Traveler;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    use HttpResponse;

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

    public function resend(MailRequest $request, $type): \Illuminate\Http\Response
    {
        $this->mailRequest = $request;

        if ($type == 'traveler') {
            return $this->resendEmail(Traveler::class);
        }

        else if ($type == 'sender') {
            return $this->resendEmail(Sender::class);
        }

        return self::failure('page not found', 404);
    }

    // resent email verification link
    private function resendEmail($model): \Illuminate\Http\Response
    {
        $user = $model::where('email', $this->mailRequest->email)->first();
        if(! $user) {
            return self::failure('no user could be found with this email address', 422);
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
