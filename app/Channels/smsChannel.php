<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class smsChannel{

    public function send($notifiable, Notification $notification)
    {
        dd($notifiable, $notification->toSms($notifiable));
//        $message = $notification->toSms($notifiable);
    }
}
