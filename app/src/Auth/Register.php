<?php

namespace App\src\Auth;

use App\Events\Registered;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Sender;
use App\Models\Traveler;
use App\Traits\HttpResponse;

class Register
{
    use HttpResponse;

    private $request;

    public function __construct($type)
    {
        $this->request = new RegisterRequest();
        $this->registerByType($type);
    }

    private function registerByType($type) {
        if ($type == 'traveler') {
            return $this->register(Traveler::class);
        }

        else if ($type == 'sender') {
            return $this->register(Sender::class);
        }
    }

    private function register($model): \Illuminate\Http\Response
    {
        $user = $model::create(array_merge($this->request->all(), ['password' => bcrypt($this->request->password)]));
        event(new Registered($user));
        return self::success('user Registered successfully, please verify your email address', 201);
    }
}
