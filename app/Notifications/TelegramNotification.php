<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{

    public $chatId, $message;
    public function __construct($chatId, $message)
    {
        $this->chatId = $chatId;
        $this->message = $message;
    }
    public function toTelegram($notifiable)
    {
        // Mengakses properti model User (contoh: 'name' dan 'email')
        // $userName = $notifiable->name;
        // $userEmail = $notifiable->email;

        // informasi tambahan pada pesan notifikasi
        return TelegramMessage::create()
            ->content("Attention!: " . $this->message)
            ->to($this->chatId); // ID Obrolan Telegram
    }
    // Metode Via
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }
}
