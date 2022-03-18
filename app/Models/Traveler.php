<?php

namespace App\Models;

use App\Notifications\VerifyEmail;
use App\Notifications\VerifyTravelerEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Traveler extends Auth
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userNotifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyTravelerEmail());
    }
}
