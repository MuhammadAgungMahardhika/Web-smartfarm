<?php

namespace App\Http\Controllers;

use App\Events\SensorDataUpdated;
use App\Models\Sensors;
use App\Repositories\SensorRepository;

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
		event(new SensorDataUpdated($idKandang, $suhu, $kelembapan, $amonia));
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
			->take(1000)
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}
}
