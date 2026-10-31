<?php

namespace Aliqsm\LaravelAuthkit\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(2),
            [
                'id' => $notifiable->id,
                'hash' => sha1($notifiable->email),
            ]
        );

        return (new MailMessage)
            ->subject('تایید ایمیل حساب کاربری')
            ->view('emails.verify-email', [
                'user' => $notifiable,
                'url' => $url,
            ]);
    }
}
