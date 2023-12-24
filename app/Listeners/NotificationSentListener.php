<?php

namespace App\Listeners;

use App\Events\NotificationSent;
use App\Notifications\TelegramNotification;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;


class NotificationSentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        Log::info("Masuk ke notifikasi sen listener");
        $idKandang = $event->idKandang;
        $message = $event->message;

        // give notification

        // Simpan kedalam database notification 
        $notificationRepository = new NotificationRepository();
        $notificationRepository->createNotification((object)[
            "id_kandang" => $idKandang,
            "pesan" => $message,
            "status" => 1,
            "waktu" =>  Carbon::now()->timezone('Asia/Jakarta')
        ]);

        // kirim notifikasi ke telegram
        // new TelegramNotification($message);
        // Notification::route('telegram', "6612596001")
        //     ->notify(new TelegramNotification($message));
    }
}
