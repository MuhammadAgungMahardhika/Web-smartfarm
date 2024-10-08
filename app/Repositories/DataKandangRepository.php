<?php

namespace App\Repositories;

use App\Models\DataKandang;
use Illuminate\Support\Facades\Log;
use Exception;

class DataKandangRepository
{

  public function __construct()
  {
  }

  public function createDataKandang(object $data): DataKandang
  {
    try {
      $dataKandang = new DataKandang();
      $dataKandang->id_kandang = $data->id_kandang;
      $dataKandang->hari_ke = $data->hari_ke;
      $dataKandang->pakan = $data->pakan;
      $dataKandang->minum = $data->minum;
      $dataKandang->riwayat_populasi = $data->riwayat_populasi;
      $dataKandang->classification = $data->classification;
      $dataKandang->date = $data->date;
      $dataKandang->created_at = $data->created_at;
      $dataKandang->created_by = $data->created_by;
      $dataKandang->save();

      return $dataKandang;
    } catch (Exception $th) {
      Log::error('Error create data kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editDataKandang($id, object $data): DataKandang
  {
    try {
      $dataKandang = DataKandang::findOrFail($id);
      $dataKandang->id_kandang = $data->id_kandang;
      $dataKandang->hari_ke = $data->hari_ke;
      $dataKandang->pakan = $data->pakan;
      $dataKandang->minum = $data->minum;
      $dataKandang->riwayat_populasi = $data->riwayat_populasi;
      $dataKandang->classification = $data->classification;
      $dataKandang->date = $data->date;
      $dataKandang->updated_at = $data->updated_at;
      $dataKandang->updated_by = $data->updated_by;
      $dataKandang->save();

      return $dataKandang;
    } catch (Exception $th) {
      Log::error('Error update data kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteDataKandang($id): DataKandang
  {
    try {
      $dataKandang = DataKandang::findOrFail($id);
      $dataKandang->delete();

      return $dataKandang;
    } catch (Exception $th) {
      Log::error('Error delete data kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}
