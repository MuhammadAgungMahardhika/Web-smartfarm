<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to('6612596001') // Replace with your chat ID
            ->content('Hello! This is a test notification from your Laravel application.');
    }
}
