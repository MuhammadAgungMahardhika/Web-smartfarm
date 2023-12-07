<?php

namespace App\Repositories;

use App\Models\AmoniakSensor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use stdClass;
use Exception;

class AmoniakRepository
{

  public function __construct()
  {
  }

  public function createAmoniak(object $data): AmoniakSensor
  {
    try {
      $amoniakData = new AmoniakSensor();
      $amoniakData->id_kandang = $data->id_kandang;
      $amoniakData->date = $data->date;
      $amoniakData->amoniak = $data->amoniak;
      $amoniakData->save();

      return $amoniakData;
    } catch (Exception $th) {
      Log::error('Error create amoniak data.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function editAmoniak($id, object $data): AmoniakSensor
  {
    try {
      $amoniakData = AmoniakSensor::findOrFail($id);
      $amoniakData->id_kandang = $data->id_kandang;
      $amoniakData->date = $data->date;
      $amoniakData->amoniak = $data->amoniak;
      $amoniakData->save();

      return $amoniakData;
    } catch (Exception $th) {
      Log::error('Error update amoniak.');
      Log::error($th->getMessage());
      throw $th;
    }
  }

  public function deleteAmoniak($id): AmoniakSensor
  {
    try {
      $amoniak = AmoniakSensor::findOrFail($id);
      $amoniak->delete();

      return $amoniak;
    } catch (Exception $th) {
      Log::error('Error delete amoniak.');
      Log::error($th->getMessage());
      throw $th;
    }
  }
}
