<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use App\Notifications\VerifySenderEmail;

class Sender extends Auth
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifySenderEmail());
    }

    public function getFacadeAccessor()
    {
        return 'sender.password';
    }
}
