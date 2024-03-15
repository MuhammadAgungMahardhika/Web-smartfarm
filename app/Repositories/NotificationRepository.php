<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Exception;

class NotificationRepository
{

    public function __construct()
    {
    }

    public function createNotification(object $data): Notification
    {
        try {
            $notification = new Notification();
            $notification->id_kandang = $data->id_kandang;
            $notification->id_user = $data->id_user;
            $notification->pesan = $data->pesan;
            $notification->status = $data->status;
            $notification->waktu = $data->waktu;
            $notification->save();

            return $notification;
        } catch (Exception $th) {
            Log::error('Error create notification.');
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function editNotification($id, object $data): Notification
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->status = $data->status;
            $notification->save();

            return $notification;
        } catch (Exception $th) {
            Log::error('Error update notification.');
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function deleteNotification($id): Notification
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return $notification;
        } catch (Exception $th) {
            Log::error('Error delete notification.');
            Log::error($th->getMessage());
            throw $th;
        }
    }
}
