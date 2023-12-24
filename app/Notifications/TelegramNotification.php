<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{

    public $message;
    public function __construct($message)
    {
        $this->message = $message;
    }
    public function toTelegram()
    {
        Log::info("masuk ke telegram Notifikasi");
        return TelegramMessage::create()->content($this->message)->to('6612596001'); // Replace with your chat ID
    }
}
