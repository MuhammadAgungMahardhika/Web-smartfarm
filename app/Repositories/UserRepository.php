<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class UserRepository
{

    public function __construct()
    {
    }

    public function createAccount(object $data): User
    {
        try {
            $user = new User();
            $user->id_role = $data->id_role;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->id_telegram = $data->id_telegram;
            $user->phone_number = $data->phone_number;
            $user->password = bcrypt($data->password);
            $user->email_verified_at = $data->email_verified_at;
            $user->remember_token = $data->remember_token;
            $user->created_by = $data->created_by;
            $user->save();

            return $user;
        } catch (Exception $th) {
            Log::error('Error generating token.');
            Log::error($th->getMessage());
            throw $th;
        }
    }
    public function updateAccount($id, object $data): User
    {
        try {
            $user = User::findOrFail($id);
            $user->id_role = $data->id_role;
            $user->name = $data->name;
            $user->email = $data->email;
            $user->id_telegram = $data->id_telegram;
            $user->phone_number = $data->phone_number;
            $user->updated_by = $data->updated_by;
            $user->save();

            return $user;
        } catch (Exception $th) {
            Log::error('Error generating token.');
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function deleteAccount($id): User
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return $user;
        } catch (Exception $th) {
            Log::error('Error delete data kandang.');
            Log::error($th->getMessage());
            throw $th;
        }
    }
}
