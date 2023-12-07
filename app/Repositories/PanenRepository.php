<?php

namespace App\Repositories;

use App\Models\Panen;
use Illuminate\Support\Facades\Log;
use Exception;

class PanenRepository
{

  public function __construct()
  {
  }

  public function createPanen(object $data): Panen
  {
    try {
      $panen = new Panen();
      $panen->id_kandang = $data->id_kandang;
      $panen->tanggal_mulai = $data->tanggal_mulai;
      $panen->tanggal_panen = $data->tanggal_panen;
      $panen->jumlah_panen = $data->jumlah_panen;
      $panen->bobot_total = $data->bobot_total;
      $panen->created_by = $data->created_by;
      $panen->save();

      return $panen;
    } catch (Exception $th) {
      Log::error('Error create panen.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editPanen($id, object $data): Panen
  {
    try {
      $panen = Panen::findOrFail($id);
      $panen->id_kandang = $data->id_kandang;
      $panen->tanggal_mulai = $data->tanggal_mulai;
      $panen->tanggal_panen = $data->tanggal_panen;
      $panen->jumlah_panen = $data->jumlah_panen;
      $panen->bobot_total = $data->bobot_total;
      $panen->updated_by = $data->updated_by;
      $panen->save();

      return $panen;
    } catch (Exception $th) {
      Log::error('Error update panen.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deletePanen($id): Panen
  {
    try {
      $panen = Panen::findOrFail($id);
      $panen->delete();

      return $panen;
    } catch (Exception $th) {
      Log::error('Error delete panen.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}
