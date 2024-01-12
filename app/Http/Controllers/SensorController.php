<?php

namespace App\Http\Controllers;

use App\Events\SensorDataUpdated;
use App\Models\Sensors;
use App\Repositories\SensorRepository;
use Illuminate\Http\Request;
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
	public function getSensors($idKandang)
	{
		$sensor = $this->modelSensor
			->where('id_kandang', '=', $idKandang)
			->orderBy('datetime', 'DESC')
			->take(10)
			->get();
		$items = [
			'sensor' => $sensor
		];
		return response(['data' => $items, 'status' => 200]);
	}
	public function getSensorByKandangId($idKandang, $isOutlier)
	{
		$isOutlier = $isOutlier == "true" ? true : false;
		$sensor = DB::table('sensors')
			->where('sensors.id_kandang', '=', $idKandang)
			->where('sensors.is_outlier', '=', $isOutlier)
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}

	// filter by date
	public function getSensorByDate(Request $request)
	{
		$idKandang = $request->id_kandang;
		$from = $request->from;
		$to = $request->to;
		$isOutlier = $request->is_outlier;

		$sensor = DB::table('sensors')
			->whereRaw('DATE(sensors.datetime)  >= ? AND DATE(sensors.datetime) <= ?', [$from, $to])
			->where('sensors.id_kandang', '=', $idKandang)
			->where('sensors.is_outlier', '=', $isOutlier)
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}

	// filter by day
	public function getSensorByDay(Request $request)
	{
		$idKandang = $request->id_kandang;
		$day = $request->day;
		$isOutlier = $request->is_outlier;
		$sensor = DB::table('sensors')
			->where('data_kandang.hari_ke', '=', $day)
			->where('sensors.id_kandang', '=', $idKandang)
			->where('sensors.is_outlier', '=', $isOutlier)
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.hari_ke',  'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}
	// filter by classification
	public function getSensorByClassification(Request $request)
	{
		$idKandang = $request->id_kandang;
		$classification = $request->classification;
		$isOutlier = $request->is_outlier;

		if ($classification == "normal") {
			$operator = '=';
		} else {
			$operator = '>';
		}

		$sensor = DB::table('sensors')
			->having('jumlah_kematian', $operator, '0')
			->where('sensors.id_kandang', '=', $idKandang)
			->where('sensors.is_outlier', '=', $isOutlier)
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}
}
