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

  public function getSuhuMean($idKandang, $suhu)
  {
    $query = Sensors::whereNotNull('sensors.suhu')
      ->where('sensors.id_kandang', '=', $idKandang)
      ->where('sensors.suhu_outlier', '=', null);

    $totalSuhu = $query->sum('sensors.suhu');
    $countSuhu = $query->count();

    if ($countSuhu > 0) {
      $mean = ($totalSuhu + $suhu) / ($countSuhu + 1);

      // Kembalikan nilai $suhu jika nilai rata-rata adalah 0
      return ($mean == 0) ? $suhu : $mean;
    } else {
      // Kembalikan nilai $suhu jika tidak ada data suhu yang ditemukan
      return $suhu;
    }
  }

  public function getKelembapanMean($idKandang, $kelembapan)
  {
    $query = Sensors::whereNotNull('sensors.suhu')
      ->where('sensors.id_kandang', '=', $idKandang)
      ->where('sensors.kelembapan_outlier', '=', null);

    $totalKelembapan = $query->sum('sensors.kelembapan');
    $countKelembapan = $query->count();

    if ($countKelembapan > 0) {
      $mean = ($totalKelembapan + $kelembapan) / ($countKelembapan + 1);

      // Kembalikan nilai $kelembapan jika nilai rata-rata adalah 0
      return ($mean == 0) ? $kelembapan : $mean;
    } else {
      // Kembalikan nilai $kelembapan jika tidak ada data kelembapan yang ditemukan
      return $kelembapan;
    }
  }


  public function getAmoniaMean($idKandang, $amonia)
  {
    $query = Sensors::whereNotNull('sensors.suhu')
      ->where('sensors.id_kandang', '=', $idKandang)
      ->where('sensors.amonia_outlier', '=', null);

    $totalAmonia = $query->sum('sensors.amonia');
    $countAmonia = $query->count();

    if ($countAmonia > 0) {
      $mean = ($totalAmonia + $amonia) / ($countAmonia + 1);

      // Kembalikan nilai $amonia jika nilai rata-rata adalah 0
      return ($mean == 0) ? $amonia : $mean;
    } else {
      // Kembalikan nilai $amonia jika tidak ada data amonia yang ditemukan
      return $amonia;
    }
  }

  public function getSuhuStdDev($idKandang, $suhu)
  {
    $data = DB::table('sensors')
      ->where('id_kandang', '=', $idKandang)
      ->where('suhu_outlier', '=', null)
      ->pluck('suhu')
      ->toArray();

    // Tambahkan nilai baru ke dalam data
    $data[] = $suhu;

    $count = count($data);

    if ($count == 0) {
      // Jika tidak ada data, kembalikan 3 sesuai dengan default outlier multiplier
      return 3;
    }

    $mean = array_sum($data) / $count;

    // Hitung deviasi setiap nilai dari rata-rata
    $differences = array_map(function ($x) use ($mean) {
      return $x - $mean;
    }, $data);

    // Hitung kuadrat dari deviasi setiap nilai
    $squaredDifferences = array_map(function ($x) {
      return $x * $x;
    }, $differences);

    // Hitung rata-rata dari kuadrat deviasi
    $meanSquaredDifferences = array_sum($squaredDifferences) / count($squaredDifferences);

    // Hitung deviasi standar (sigma)
    $standardDeviation = sqrt($meanSquaredDifferences);

    return $standardDeviation;
  }


  public function getKelembapanStdDev($idKandang, $kelembapan)
  {
    $data = DB::table('sensors')
      ->where('id_kandang', '=', $idKandang)
      ->where('kelembapan_outlier', '=', null)
      ->pluck('kelembapan')
      ->toArray();

    // Tambahkan nilai baru ke dalam data
    $data[] = $kelembapan;

    $count = count($data);

    if ($count == 0) {
      // Jika tidak ada data, kembalikan 3 sesuai dengan default outlier multiplier
      return 3;
    }

    $mean = array_sum($data) / $count;

    // Hitung deviasi setiap nilai dari rata-rata
    $differences = array_map(function ($x) use ($mean) {
      return $x - $mean;
    }, $data);

    // Hitung kuadrat dari deviasi setiap nilai
    $squaredDifferences = array_map(function ($x) {
      return $x * $x;
    }, $differences);

    // Hitung rata-rata dari kuadrat deviasi
    $meanSquaredDifferences = array_sum($squaredDifferences) / count($squaredDifferences);

    // Hitung deviasi standar (sigma)
    $standardDeviation = sqrt($meanSquaredDifferences);

    return $standardDeviation;
  }

  public function getAmoniaStdDev($idKandang, $amonia)
  {
    $data = DB::table('sensors')
      ->where('id_kandang', '=', $idKandang)
      ->where('amonia_outlier', '=', null)
      ->pluck('amonia')
      ->toArray();

    // Tambahkan nilai baru ke dalam data
    $data[] = $amonia;

    $count = count($data);

    if ($count == 0) {
      // Jika tidak ada data, kembalikan 3 sesuai dengan default outlier multiplier
      return 3;
    }

    $mean = array_sum($data) / $count;

    // Hitung deviasi setiap nilai dari rata-rata
    $differences = array_map(function ($x) use ($mean) {
      return $x - $mean;
    }, $data);

    // Hitung kuadrat dari deviasi setiap nilai
    $squaredDifferences = array_map(function ($x) {
      return $x * $x;
    }, $differences);

    // Hitung rata-rata dari kuadrat deviasi
    $meanSquaredDifferences = array_sum($squaredDifferences) / count($squaredDifferences);

    // Hitung deviasi standar (sigma)
    $standardDeviation = sqrt($meanSquaredDifferences);

    return $standardDeviation;
  }
}
