<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\MailRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetCodePassword;
use App\Models\Sender;
use App\Models\Traveler;
use App\Models\User;
use App\Repositories\Contracts\IResetCodePassword;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    use HttpResponse;

    private $traveler, $sender, $reset;

    public function __construct(ISender $sender, ITraveler $traveler, IResetCodePassword $reset)
    {
        $this->sender = $sender;
        $this->traveler = $traveler;
        $this->reset = $reset;
    }

    public function sendResetLink(MailRequest $request): \Illuminate\Http\Response
    {
        if($request->role == 'traveler') {
            $this->traveler->findWhereFirst('email', $request->all());
        }

        else if($request->role == 'sender') {
            $this->sender->findWhereFirst('email', $request->all());
        }

        $data['email'] = $request->email;
        // Delete all old code that user send before.
        $this->reset->findAndDelete('email', $request->all());

        // Generate random code
        $data['code'] = mt_rand(100000, 999999);

        // Create a new code
        $codeData = $this->reset->create($data);

        // Send email to user
        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));

        return self::success('password code sent successfully', 200);
    }
}
