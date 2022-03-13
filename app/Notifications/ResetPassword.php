<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword as Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public function toMail($notifiable): MailMessage
    {
        $url = url(config('app.client_url'). '/password/reset?token='. $this->token);
        return (new MailMessage)
            ->line('email reset password url')
            ->action('ResetPassword link: ', $url);
    }
}
