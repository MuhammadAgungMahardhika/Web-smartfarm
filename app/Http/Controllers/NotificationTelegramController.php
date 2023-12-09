<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TelegramNotification;

class NotificationTelegramController extends Controller
{

    public function sendTelegramNotification()
    {
        $user = auth()->user(); // Replace with the user you want to notify
        $user->notify(new TelegramNotification());
    }
}
