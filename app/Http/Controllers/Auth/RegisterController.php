<?php

namespace App\Http\Controllers\Auth;

use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SenderAuthRequest;
use App\Http\Requests\Auth\TravelerAuthRequest;
use App\Models\Sender;
use App\Models\Traveler;
use App\Repositories\Contracts\ISender;
use App\Repositories\Contracts\ITraveler;
use App\src\Register;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use HttpResponse;

    private $traveler, $sender;

    public function __construct(ISender $sender, ITraveler $traveler)
    {
        $this->sender = $sender;
        $this->traveler = $traveler;
    }

    // register new user
    public function register(Request $request, SenderAuthRequest $sRequest, TravelerAuthRequest $tRequest): \Illuminate\Http\Response
    {
        $user = [];
        if ($request->role == 'traveler') {
            $data = array_merge($request->all(), ['password' => bcrypt($request->password)]);
            $user = $this->traveler->create($data);
        }
        else if ($request->role == 'sender') {
            $data = array_merge($request->all(), ['password' => bcrypt($request->password)]);
            $user = $this->sender->create($data);
        }
        event(new Registered($user));
        return self::success('user Registered successfully, please verify your email address', 201);
    }
}
