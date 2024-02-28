<?php

namespace App\Notifications;

use App\Channels\smsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class applicationPayed extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail',SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('درخواست شما تایید شد')
            ->line('پرداخت شما انجام شد')
            ->line('با تشکر!');
    }

    public function toSms($notifiable)
    {
        return " درخواست شما برای پرداخت هرینه ها تایید شد.";
    }
}
