<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AmoniakSensor;
use App\Models\Sensors;
use App\Models\SuhuKelembapanSensor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\AmoniakRepository;
use App\Repositories\SensorRepository;
use App\Repositories\SuhuKelembapanRepository;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class SensorController extends Controller
{

	protected $sensorRepository;
	protected $modelSensor, $modelAmoniak;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(
		Sensors $sensors,
		SensorRepository $sensorRepository
	) {

		$this->modelSensor = $sensors;
		$this->sensorRepository = $sensorRepository;
	}

	public function storeSensorFromOutside($idKandang, $suhu = null, $kelembapan = null, $amonia = null)
	{

		// Suhu dan Kelembapan
		if ($suhu != null || $kelembapan != null || $amonia != null) {
			$this->sensorRepository->createSensor((object)[
				"id_kandang" => $idKandang,
				"datetime" => Carbon::now()->timezone('Asia/Jakarta'),
				"suhu" => $suhu,
				"kelembapan" => $kelembapan,
				"amonia" => $amonia,
			]);
		}


		return response(['suhu' => $suhu, 'kelembapan' => $kelembapan, 'amonia' => $amonia]);
	}

	public function getSensor($idKandang)
	{
		$sensor = $this->modelSensor
			->where('id_kandang', '=', $idKandang)
			->orderBy('datetime', 'DESC')
			->first();
		$items = [
			'sensor' => $sensor
		];
		return response(['data' => $items, 'status' => 200]);
	}
	public function getSensorByKandangId($idKandang)
	{
		$sensor = $this->modelSensor
			->where('id_kandang', '=', $idKandang)
			->join('kandang', 'kandang.id', '=', 'sensors.id_kandang')
			->orderBy('datetime', 'DESC')
			->get();
		$items = [
			'sensor' => $sensor
		];
		return response(['data' => $items, 'status' => 200]);
	}
}
