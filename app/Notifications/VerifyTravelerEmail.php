<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyTravelerEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected function verificationUrl($notifiable) {
        $appUrl = config('app.client_url', config('app.url'));

        $url = URL::temporarySignedRoute(
            'verification.verifyT',
            Carbon::now()->addMinutes(60),
            ['type' => $notifiable->id]
        );

        return str_replace(url('/api/verification/verify/traveler'), $appUrl, $url);
    }
}
