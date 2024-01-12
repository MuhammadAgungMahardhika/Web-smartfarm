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
      $sensor->is_outlier = $data->is_outlier;
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

  public function getMean($column)
  {
    // Dapatkan rata-rata dari kolom pada tabel sensor
    return Sensors::whereNotNull($column)->where('sensors.is_outlier', '=', false)->avg($column);
  }

  function getStdDev($column)
  {
    // Hitung standar deviasi dari kolom pada tabel sensors
    return DB::table('sensors')->select(DB::raw("STDDEV($column) as std_dev_$column"))->where('sensors.is_outlier', '=', false)->first()->{"std_dev_$column"};
  }
}
