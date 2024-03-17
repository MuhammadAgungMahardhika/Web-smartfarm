<?php

namespace App\Listeners;

use App\Events\NotificationSent;
use App\Models\User;
use App\Notifications\TelegramNotification;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class NotificationSentListener
{
    protected $notificationRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
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

        // Simpan kedalam database notification 

        $this->notificationRepository->createNotification((object)[
            "id_kandang" => $idKandang,
            "id_user" => $userId,
            "pesan" => $message,
            "status" => 1,
            "waktu" =>  Carbon::now()->timezone('Asia/Jakarta')
        ]);


        // Ambil instance model 
        $user = User::find($userId);
        $chatId = optional($user)->id_telegram;

        // Kirim notifikasi ke 
        if ($chatId !== null) {
            try {
                // Log::info('Mengirim notifikasi Telegram ke chat IDS: ' . $chatId);
                $user->notify(new TelegramNotification(strval($chatId), $message));
                // Log::info('Notifikasi Telegram berhasil dikirim.');
            } catch (\Throwable $th) {
                Log::error('Gagal mengirimkan notifikasi telegram: ' . $th);
            }
        } else {
            // Log::warning('Chat ID Telegram tidak tersedia. Tidak dapat mengirim notifikasi.');
        }
    }
}
