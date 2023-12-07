<?php

namespace App\Repositories;

use App\Models\DataKematian;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class DataKematianRepository
{

  public function __construct()
  {

  }

  public function createDataKematian(object $data): DataKematian{
    try {
      $dataKematian = new DataKematian();
      $dataKematian->id_data_kandang = $data->id_data_kandang;
      $dataKematian->kematian_terbaru = $data->kematian_terbaru;
      $dataKematian->jumlah_kematian = $data->jumlah_kematian;
      $dataKematian->jam = $data->jam;
      $dataKematian->hari = $data->hari;
      $dataKematian->created_by = $data->created_by;
      $dataKematian->save();

      return $dataKematian;
    } catch (Exception $th) {
      Log::error('Error create data kematian.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editDataKematian($id,object $data): DataKematian{
    try {
      $dataKematian = DataKematian::findOrFail($id);
      $dataKematian->id_data_kandang = $data->id_data_kandang;
      $dataKematian->kematian_terbaru = $data->kematian_terbaru;
      $dataKematian->jumlah_kematian = $data->jumlah_kematian;
      $dataKematian->jam = $data->jam;
      $dataKematian->hari = $data->hari;
      $dataKematian->updated_by = $data->updated_by;
      $dataKematian->save();

      return $dataKematian;
    } catch (Exception $th) {
      Log::error('Error update data kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteDataKematian($id): DataKematian{
    try {
      $dataKematian = DataKematian::findOrFail($id);
      $dataKematian->delete();

      return $dataKematian;
    } catch (Exception $th) {
      Log::error('Error delete data kandang.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}