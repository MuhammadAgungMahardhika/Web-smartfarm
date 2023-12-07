<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class AuthRepository
{

  public function __construct()
  {

  }

  public function createAccount(object $data): User{
    try {
      $user = new User();
      $user->id_role = $data->id_role;
      $user->name = $data->name;
      $user->password = bcrypt($data->password);
      $user->username = $data->username;
      $user->status = $data->status;
      $user->phone_number = $data->phone_number;
      $user->created_by = $data->created_by;
      $user->save();

      return $user;
    } catch (Exception $th) {
      Log::error('Error generating token.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}