<?php

namespace App\Http\Controllers;

use App\Events\SensorDataUpdated;
use App\Models\Sensors;
use App\Repositories\SensorRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
		$sensor = DB::table('sensors')
			->where('sensors.id_kandang', '=', $idKandang)
			->where('kandang.id_user', Auth::user()->id)
			->leftJoin('kandang', function ($join) {
				$join->on('kandang.id', '=', 'sensors.id_kandang');
			})
			->leftJoin('data_kandang', function ($join) {
				$join->on('data_kandang.id_kandang', '=', 'kandang.id')
					->on(DB::raw('DATE(data_kandang.date)'), '=', DB::raw('DATE(sensors.datetime)'));
			})
			->leftJoin('data_kematian', function ($join) {
				$join->on('data_kematian.id_data_kandang', '=', 'data_kandang.id');
			})
			->select(
				'sensors.*',
				'kandang.nama_kandang',
				'kandang.alamat_kandang',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}
}
