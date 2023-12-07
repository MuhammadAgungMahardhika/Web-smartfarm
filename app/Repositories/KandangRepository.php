<?php

namespace App\Repositories;

use App\Models\Kandang;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class KandangRepository
{

  public function __construct()
  {

  }

  public function createKandang(object $data): Kandang{
    try {
      $kandang = new Kandang();
      $kandang->id_user = $data->id_user;
      $kandang->nama_kandang = $data->nama_kandang;
      $kandang->populasi_awal = $data->populasi_awal;
      $kandang->alamat_kandang = $data->alamat_kandang;
      $kandang->created_by= $data->created_by;
      $kandang->save();

      return $kandang;
    } catch (Exception $th) {
      Log::error('Error create kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editKandang($id,object $data): Kandang{
    try {
      $kandang = Kandang::findOrFail($id);
      $kandang->id_user = $data->id_user;
      $kandang->nama_kandang = $data->nama_kandang;
      $kandang->populasi_awal = $data->populasi_awal;
      $kandang->alamat_kandang = $data->alamat_kandang;
      $kandang->updated_by= $data->updated_by;
      $kandang->save();

      return $kandang;
    } catch (Exception $th) {
      Log::error('Error update kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteKandang($id): Kandang{
    try {
      $kandang = Kandang::findOrFail($id);
      $kandang->delete();

      return $kandang;
    } catch (Exception $th) {
      Log::error('Error delete kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}