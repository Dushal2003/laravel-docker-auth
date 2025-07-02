<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginOtp extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly string $plainOtp) {}

    public function via($notifiable): array
    {
        return ['mail']; // or ['sms','mail'] if you integrate SMS
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Login OTP')
            ->line("Use the code **{$this->plainOtp}** to complete your login.")
            ->line('The code expires in 10 minutes.');
    }
}
