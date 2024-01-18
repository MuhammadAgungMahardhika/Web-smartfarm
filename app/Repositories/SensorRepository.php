<?php

namespace App\Repositories;

use App\Models\Sensors;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class SensorRepository
{

  public function __construct()
  {
  }

  public function createSensor(object $data): Sensors
  {
    try {
      $sensor = new Sensors();
      $sensor->id_kandang = $data->id_kandang;
      $sensor->datetime = $data->datetime;
      $sensor->suhu = $data->suhu;
      $sensor->kelembapan = $data->kelembapan;
      $sensor->amonia = $data->amonia;
      $sensor->suhu_outlier = $data->suhu_outlier;
      $sensor->kelembapan_outlier = $data->kelembapan_outlier;
      $sensor->amonia_outlier = $data->amonia_outlier;
      $sensor->save();

      return $sensor;
    } catch (Exception $th) {
      Log::error('Error create sensor data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editSensor($id, object $data): Sensors
  {
    try {
      $sensor = Sensors::findOrFail($id);
      $sensor->id_kandang = $data->id_kandang;
      $sensor->datetime = $data->datetime;
      $sensor->suhu = $data->suhu;
      $sensor->kelembapan = $data->kelembapan;
      $sensor->amonia = $data->amonia;
      $sensor->suhu_outlier = $data->suhu_outlier;
      $sensor->kelembapan_outlier = $data->kelembapan_outlier;
      $sensor->amonia_outlier = $data->amonia_outlier;
      $sensor->save();
      return $sensor;
    } catch (Exception $th) {
      Log::error('Error update sensor data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteSensor($id): Sensors
  {
    try {
      $sensor = Sensors::findOrFail($id);
      $sensor->delete();

      return $sensor;
    } catch (Exception $th) {
      Log::error('Error delete sensor data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function getSuhuMean($idKandang)
  {
    $default = 27;
    $mean = Sensors::whereNotNull('sensors.suhu')
      ->where('sensors.id_kandang', '=', $idKandang)
      ->where('sensors.suhu_outlier', '=', null)
      ->avg('sensors.suhu');
    if ($mean) {
      return $mean;
    } else {
      return $default;
    }
  }
  public function getKelembapanMean($idKandang)
  {
    $default = 50;
    $mean = Sensors::whereNotNull('sensors.suhu')
      ->where('sensors.id_kandang', '=', $idKandang)
      ->where('sensors.kelembapan_outlier', '=', null)
      ->avg('sensors.kelembapan');
    if ($mean) {
      return $mean;
    } else {
      return $default;
    }
  }
  public function getAmoniaMean($idKandang)
  {
    $default = 20;
    $mean = Sensors::whereNotNull('sensors.suhu')
      ->where('sensors.id_kandang', '=', $idKandang)
      ->where('sensors.amonia_outlier', '=', null)
      ->avg('sensors.amonia');
    if ($mean) {
      return $mean;
    } else {
      return $default;
    }
  }

  function getSuhuStdDev($idKandang)
  {
    $suhuStdDev = DB::table('sensors')
      ->select(DB::raw("IF(COALESCE(STD(suhu), 0) = 0, 3, COALESCE(STD(suhu), 0)) as std_dev"))
      ->where('id_kandang', '=', $idKandang)
      ->first();

    return $suhuStdDev->std_dev;
  }
  function getKelembapanStdDev($idKandang)
  {
    $kelembapanStdDev =  DB::table('sensors')
      ->select(DB::raw("IF(COALESCE(STD(kelembapan), 0) = 0, 3, COALESCE(STD(kelembapan), 0)) as std_dev"))
      ->where('id_kandang', '=', $idKandang)
      ->first();

    return $kelembapanStdDev->std_dev;
  }
  function getAmoniaStdDev($idKandang)
  {
    $amoniaStdDev =  DB::table('sensors')
      ->select(DB::raw("IF(COALESCE(STD(amonia), 0) = 0, 3, COALESCE(STD(amonia), 0)) as std_dev"))
      ->where('id_kandang', '=', $idKandang)
      ->first();

    return $amoniaStdDev->std_dev;
  }
}
