<?php

namespace Aliqsm\LaravelAuthkit\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    public string $token;


    public function __construct(string $token)
    {
        $this->token = $token;
    }


    public function via(object $notifiable): array
    {
        return ['mail'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        $url = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->email,
        ]);

        return (new MailMessage)
            ->subject('بازیابی رمز عبور')
            ->view('emails.reset-password', [
                'user' => $notifiable,
                'url' => $url,
            ]);
    }
}
