<?php

namespace App\Repositories;

use App\Models\RekapDatum;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class RekapDataRepository
{

  public function __construct()
  {
  }

  public function createRekapData(object $data): RekapDatum
  {
    try {
      $rekapData = new RekapDatum();
      $rekapData->id_kandang = $data->id_kandang;
      $rekapData->hari_ke = $data->hari_ke;
      $rekapData->date = $data->date;
      $rekapData->rata_rata_amoniak = $data->rata_rata_amoniak;
      $rekapData->rata_rata_suhu = $data->rata_rata_suhu;
      $rekapData->kelembapan = $data->kelembapan;
      $rekapData->pakan = $data->pakan;
      $rekapData->minum = $data->minum;
      $rekapData->bobot = $data->bobot;
      // $rekapData->jumlah_kematian = $data->jumlah_kematian;
      $rekapData->jumlah_kematian_harian = $data->jumlah_kematian_harian;
      $rekapData->created_by = $data->created_by;
      $rekapData->save();

      return $rekapData;
    } catch (Exception $th) {
      Log::error('Error create rekap data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editDataKandang($id, object $data): RekapDatum
  {
    try {
      $rekapData = RekapDatum::findOrFail($id);
      $rekapData->id_kandang = $data->id_kandang;
      $rekapData->hari_ke = $data->hari_ke;
      $rekapData->date = $data->date;
      $rekapData->rata_rata_amoniak = $data->rata_rata_amoniak;
      $rekapData->rata_rata_suhu = $data->rata_rata_suhu;
      $rekapData->kelembapan = $data->kelembapan;
      $rekapData->pakan = $data->pakan;
      $rekapData->minum = $data->minum;
      $rekapData->bobot = $data->bobot;
      // $rekapData->jumlah_kematian = $data->jumlah_kematian;
      $rekapData->jumlah_kematian_harian = $data->jumlah_kematian_harian;
      $rekapData->updated_by = $data->updated_by;
      $rekapData->save();

      return $rekapData;
    } catch (Exception $th) {
      Log::error('Error update rekap data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteDataKandang($id): RekapDatum
  {
    try {
      $rekapData = RekapDatum::findOrFail($id);
      $rekapData->delete();

      return $rekapData;
    } catch (Exception $th) {
      Log::error('Error delete rekap data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}
