<?php

namespace App\Repositories;

use App\Models\SuhuKelembapanSensor;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class SuhuKelembapanRepository
{

  public function __construct()
  {
  }

  public function createSuhuKelembapanSensor(object $data): SuhuKelembapanSensor
  {
    try {
      $suhuKelembapan = new SuhuKelembapanSensor();
      $suhuKelembapan->id_kandang = $data->id_kandang;
      $suhuKelembapan->date = $data->date;
      $suhuKelembapan->suhu = $data->suhu;
      $suhuKelembapan->kelembapan = $data->kelembapan;
      $suhuKelembapan->save();

      return $suhuKelembapan;
    } catch (Exception $th) {
      Log::error('Error create suhu kelembapan data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editSuhuKelembapanSensor($id, object $data): SuhuKelembapanSensor
  {
    try {
      $suhuKelembapan = SuhuKelembapanSensor::findOrFail($id);
      $suhuKelembapan->id_kandang = $data->id_kandang;
      $suhuKelembapan->date = $data->date;
      $suhuKelembapan->suhu = $data->suhu;
      $suhuKelembapan->kelembapan = $data->kelembapan;
      $suhuKelembapan->save();

      return $suhuKelembapan;
    } catch (Exception $th) {
      Log::error('Error update suhu kelembapan.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteAmoniak($id): SuhuKelembapanSensor
  {
    try {
      $suhuKelembapan = SuhuKelembapanSensor::findOrFail($id);
      $suhuKelembapan->delete();

      return $suhuKelembapan;
    } catch (Exception $th) {
      Log::error('Error delete suhu kelembapan.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}
