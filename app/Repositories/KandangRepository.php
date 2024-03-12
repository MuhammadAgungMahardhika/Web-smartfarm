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

  public function createKandang(object $data): Kandang
  {
    try {
      $kandang = new Kandang();
      $kandang->nama_kandang = $data->nama_kandang;
      $kandang->alamat_kandang = $data->alamat_kandang;
      $kandang->luas_kandang = $data->luas_kandang;
      $kandang->populasi_awal = $data->populasi_awal;
      $kandang->populasi_saat_ini = $data->populasi_saat_ini;
      $kandang->id_user = $data->id_user;
      $kandang->id_peternak = $data->id_peternak;
      $kandang->created_by = $data->created_by;
      $kandang->save();

      return $kandang;
    } catch (Exception $th) {
      Log::error('Error create kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editKandang($id, object $data): Kandang
  {
    try {
      $kandang = Kandang::findOrFail($id);
      $kandang->nama_kandang = $data->nama_kandang;
      $kandang->alamat_kandang = $data->alamat_kandang;
      $kandang->luas_kandang = $data->luas_kandang;
      $kandang->populasi_awal = $data->populasi_awal;
      $kandang->populasi_saat_ini = $data->populasi_saat_ini;
      $kandang->id_user = $data->id_user;
      $kandang->id_peternak = $data->id_peternak;
      $kandang->updated_by = $data->updated_by;
      $kandang->updated_at = $data->updated_at;
      $kandang->save();

      return $kandang;
    } catch (Exception $th) {
      Log::error('Error update kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function changeKandangPopulationAndSetActiveStatus($id, object $data): Kandang
  {
    try {
      $kandang = Kandang::findOrFail($id);
      $kandang->populasi_saat_ini = $data->populasi_saat_ini;
      $kandang->status = 'aktif';
      $kandang->save();
      return $kandang;
    } catch (Exception $th) {
      Log::error('Error update kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteKandang($id): Kandang
  {
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
