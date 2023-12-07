<?php

namespace App\Repositories;

use App\Models\RekapDataHarian;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class RekapDataRepository
{

  public function __construct()
  {

  }

  public function createRekapHarianData(object $data): RekapDataHarian{
    try {
      $rekapDataHarian = new RekapDataHarian();
      $rekapDataHarian->id_kandang = $data->id_kandang;
      $rekapDataHarian->date = $data->date;
      $rekapDataHarian->amoniak = $data->amoniak;
      $rekapDataHarian->suhu = $data->suhu;
      $rekapDataHarian->kelembapan = $data->kelembapan;
      $rekapDataHarian->created_by = $data->created_by;
      $rekapDataHarian->save();

      return $rekapDataHarian;
    } catch (Exception $th) {
      Log::error('Error create rekap data harian.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editDataKandang($id,object $data): RekapDataHarian{
    try {
      $rekapDataHarian = RekapDataHarian::findOrFail($id);
      $rekapDataHarian->id_kandang = $data->id_kandang;
      $rekapDataHarian->date = $data->date;
      $rekapDataHarian->amoniak = $data->amoniak;
      $rekapDataHarian->suhu = $data->suhu;
      $rekapDataHarian->kelembapan = $data->kelembapan;
      $rekapDataHarian->updated_by = $data->updated_by;
      $rekapDataHarian->save();

      return $rekapDataHarian;
    } catch (Exception $th) {
      Log::error('Error update rekap data harian.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteDataKandang($id): RekapDataHarian{
    try {
      $rekapDataHarian = RekapDataHarian::findOrFail($id);
      $rekapDataHarian->delete();

      return $rekapDataHarian;
    } catch (Exception $th) {
      Log::error('Error delete rekap data harian.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}