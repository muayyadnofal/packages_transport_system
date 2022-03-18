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

    public function notifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function image(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function userNotifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifySenderEmail());
    }
}
