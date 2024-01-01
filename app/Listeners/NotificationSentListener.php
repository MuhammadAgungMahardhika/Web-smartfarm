<?php

namespace App\Listeners;

use App\Events\NotificationSent;
use App\Models\Kandang;
use App\Models\User;
use App\Notifications\TelegramNotification;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $idKandang = $event->idKandang;
        $userId = $event->userId;
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


        // Ambil instance model Customer
        $user = User::find($userId);
        $chatId = $user->id_telegram;
        // Kirim notifikasi ke pelanggan
        if ($chatId != null) {
            try {
                $user->notify(new TelegramNotification($chatId, $message));
            } catch (\Throwable $th) {
                Log::error('Gagal mengirimkan notifikasi telegram: ' . $th);
            }
        }
    }
}
