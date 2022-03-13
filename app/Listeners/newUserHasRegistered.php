<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class newUserHasRegistered
{
    public function handle($event)
    {
        $event->user->sendEmailVerificationNotification();
    }
}
