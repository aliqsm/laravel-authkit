<?php

namespace Aliqsm\LaravelAuthkit\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecurityEventNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public array $data = [];


    public function __construct(array $data)
    {
        $this->data = $data;
        $this->afterCommit();
    }


    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getSubject())
            ->view($this->getView(), [
                'user' => $notifiable,
                'data' => $this->data,
            ]);
    }



    public function toDatabase(object $notifiable): array
    {
        return [
            'event' => $this->data['event'],
            'title' => $this->getSubject(),
            'ip' => $this->data['ip'] ?? null,
            'user_agent' => $this->data['user_agent'] ?? null,
            'time' => $this->data['time'] ?? null,
            'meta' => $this->data['meta'] ?? [],
        ];
    }


    private function getView(): string
    {
        return match ($this->data['event']) {
            'two_factor_enabled'      => 'emails.2fa.2fa-enabled',
            'two_factor_disabled'     => 'emails.2fa.2fa-disabled',
            '2fa_recovery_codes_regenerated' => 'emails.2fa.recovery-codes-regenerated',
            '2fa_recovery_codes_empty' => 'emails.2fa.recovery-codes-empty',
            'password_changed'  => 'emails.password-changed',
            'login_alert'       => 'emails.login-alert',
            default             => throw new \InvalidArgumentException('Unknown security notification type.'),
        };
    }


    private function getSubject(): string
    {
        return match ($this->data['event']) {
            'two_factor_enabled'       => 'هشدار امنیتی: فعال شدن تأیید دو مرحله‌ای',
            'two_factor_disabled'      => 'هشدار امنیتی: غیرفعال شدن تأیید دو مرحله‌ای',
            '2fa_recovery_codes_regenerated' => 'هشدار امنیتی: تولید مجدد کدهای بازیابی',
            '2fa_recovery_codes_empty' => 'هشدار امنیتی: اتمام کدهای بازیابی',
            'password_changed'  => 'هشدار امنیتی: تغییر رمز عبور',
            'login_alert'       => 'هشدار امنیتی: ورود جدید به حساب کاربری',
            default             => 'هشدار امنیتی حساب کاربری',
        };
    }
}
