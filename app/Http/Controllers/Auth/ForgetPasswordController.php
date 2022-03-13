<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MailRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetCodePassword;
use App\Models\Sender;
use App\Models\Traveler;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    use HttpResponse;

    private $request;

    public function sendResetLink(MailRequest $request, $type): \Illuminate\Http\Response
    {
        $this->request = $request;

        if($type == 'traveler') {
            return $this->sendResetLinkEmail(Traveler::class);
        }

        else if($type == 'sender') {
            return $this->sendResetLinkEmail(Sender::class);
        }

        return self::failure('page not found', 404);
    }

    private function sendResetLinkEmail($model): \Illuminate\Http\Response
    {
        if (! $model::where('email', $this->request->all())->first()) {
            return self::failure('email not found', 404);
        }

        $data['email'] = $this->request->email;
        // Delete all old code that user send before.
        ResetCodePassword::where('email', $this->request->all())->delete();

        // Generate random code
        $data['code'] = mt_rand(100000, 999999);

        // Create a new code
        $codeData = ResetCodePassword::create($data);

        // Send email to user
        Mail::to($this->request->email)->send(new SendCodeResetPassword($codeData->code));

        return self::success('password code sent successfully', 200);
    }
}
