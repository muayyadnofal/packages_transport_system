<?php

namespace App\Http\Controllers\Auth;

use App\Events\Registered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Sender;
use App\Models\Traveler;
use App\src\Register;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use HttpResponse;

    private $request;

    // register as a sender or traveler by the chosen type
    public function register(RegisterRequest $request, $type): \Illuminate\Http\Response
    {
        $this->request = $request;

        if ($type == 'traveler') {
            return $this->registerByType(Traveler::class);
        }

        else if ($type == 'sender') {
            return $this->registerByType(Sender::class);
        }

        return self::failure('page not found', 404);
    }

    // add user to database
    public function registerByType($model): \Illuminate\Http\Response
    {
        $user = $model::create(array_merge($this->request->all(), ['password' => bcrypt($this->request->password)]));
        event(new Registered($user));
        return self::success('user Registered successfully, please verify your email address', 201);
    }
}
