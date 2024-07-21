<?php

namespace App\Http\Controllers;

use App\Events\AmoniaOutlierUpdated;
use App\Events\KelembapanOutlierUpdated;
use App\Events\SensorDataUpdated;
use App\Events\SuhuOutlierUpdated;
use App\Models\Sensors;
use App\Repositories\SensorRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{

	protected $sensorRepository;
	protected $modelSensor;
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

	public function getSensorHistoryByDate($option, $idKandang, $date,)
	{


		$data = DB::table('sensors')
			->select(['suhu', 'kelembapan', 'amonia', 'suhu_outlier', 'kelembapan_outlier', 'amonia_outlier'])
			->where('id_kandang', $idKandang)
			->whereDate('sensors.datetime', $date)
			->orderBy('sensors.datetime', 'ASC')
			->get();

		// ---------------Suhu---------------------------------------------
		if ($option == "suhu") {
			$meanSuhu = $data->isEmpty() ? null : $data->avg('suhu');
			$stdDevSuhu = $this->sensorRepository->getSuhuStdDev($idKandang);
			$lowerLimit = $meanSuhu - (3 * $stdDevSuhu);
			$upperLimit = $meanSuhu + (3 * $stdDevSuhu);



			return response()->json([
				'data' => $data,
				'mean' => $meanSuhu,
				'stddev' => $stdDevSuhu,
				'lower_limit' => $lowerLimit,
				'upper_limit' => $upperLimit
			], 200);
		}

		// ---------------Kelembapan-------------------------------------------
		if ($option == "kelembapan") {
			$meanKelembapan = $data->isEmpty() ? null : $data->avg('kelembapan');
			$stdDevKelembapan = $this->sensorRepository->getKelembapanStdDev($idKandang);
			$lowerLimit = $meanKelembapan - (3 * $stdDevKelembapan);
			$upperLimit = $meanKelembapan + (3 * $stdDevKelembapan);



			return response()->json([
				'data' => $data,
				'mean' => $meanKelembapan,
				'stddev' => $stdDevKelembapan,
				'lower_limit' => $lowerLimit,
				'upper_limit' => $upperLimit
			], 200);
		}

		// ----------------Amonia-------------------------------------------------
		if ($option == "amonia") {
			$meanAmonia = $data->isEmpty() ? null : $data->avg('amonia');
			$stdDevAmonia = $this->sensorRepository->getAmoniaStdDev($idKandang);
			$lowerLimit = $meanAmonia - (3 * $stdDevAmonia);
			$upperLimit = $meanAmonia + (3 * $stdDevAmonia);



			return response()->json([
				'data' => $data,
				'mean' => $meanAmonia,
				'stddev' => $stdDevAmonia,
				'lower_limit' => $lowerLimit,
				'upper_limit' => $upperLimit
			], 200);
		}
	}


	public function storeSensorFromOutside($idKandang, $suhu = null, $kelembapan = null, $amonia = null)
	{
		$suhuOutlier  = null;
		$kelembapanOutlier = null;
		$amoniaOutlier = null;

		// ---------------Suhu---------------------------------------------
		if ($suhu != null) {
			$meanSuhu = $this->sensorRepository->getSuhuMean($idKandang, $suhu);
			$stdDevSuhu = $this->sensorRepository->getSuhuStdDev($idKandang, $suhu);
			$isSuhuOutlier = $this->detectOutlier($suhu, $meanSuhu, $stdDevSuhu);
			// deteksi suhu outlier
			if ($isSuhuOutlier) {
				$suhuOutlier = $suhu;
				$suhu = $this->winsorize($suhu, $meanSuhu, $stdDevSuhu);
			}
			$lowerLimit = $meanSuhu - (3 * $stdDevSuhu);
			$upperLimit = $meanSuhu + (3 * $stdDevSuhu);

			event(new SuhuOutlierUpdated($idKandang, $meanSuhu, $stdDevSuhu, $lowerLimit, $upperLimit, $suhuOutlier, $suhu));

			dump([
				"mean suhu => " . $meanSuhu,
				"std dev suhu => " . $stdDevSuhu,
				"suhu lowerLimit => " . $lowerLimit,
				"suhu upperLimit => " . $upperLimit
			]);
		}

		// ---------------Kelembapan-------------------------------------------
		if ($kelembapan != null) {
			$meanKelembapan = $this->sensorRepository->getKelembapanMean($idKandang, $kelembapan);
			$stdDevKelembapan = $this->sensorRepository->getKelembapanStdDev($idKandang, $kelembapan);
			$isKelembapanOutlier = $this->detectOutlier($kelembapan, $meanKelembapan, $stdDevKelembapan);
			// deteksi kelembapan outlier
			if ($isKelembapanOutlier) {
				$kelembapanOutlier = $kelembapan;
				$kelembapan = $this->winsorize($kelembapan, $meanKelembapan, $stdDevKelembapan);
			}
			$lowerKelembapan = $meanKelembapan - 3 * $stdDevKelembapan;
			$upperKelembapan = $meanKelembapan + 3 * $stdDevKelembapan;
			event(new KelembapanOutlierUpdated($idKandang, $meanKelembapan, $stdDevKelembapan, $lowerKelembapan, $upperKelembapan, $kelembapanOutlier, $kelembapan));

			dump([
				"mean kelembapan => " . $meanKelembapan,
				"std dev kelembapan => " . $stdDevKelembapan,
				"kelembapan lowerLimit => " . $lowerKelembapan,
				"kelembapan upperLimit => " . $upperKelembapan
			]);
		}

		// ----------------Amonia-------------------------------------------------
		if ($amonia != null) {
			$meanAmonia = $this->sensorRepository->getAmoniaMean($idKandang, $amonia);
			$stdDevAmonia = $this->sensorRepository->getAmoniaStdDev($idKandang, $amonia);
			$isAmoniaOutlier = $this->detectOutlier($amonia, $meanAmonia, $stdDevAmonia);
			// Deteksi amonia outlier
			if ($isAmoniaOutlier) {
				$amoniaOutlier = $amonia;
				$amonia = $this->winsorize($amonia, $meanAmonia, $stdDevAmonia);
			}
			$lowerAmonia = $meanAmonia - 3 * $stdDevAmonia;
			$upperAmonia = $meanAmonia + 3 * $stdDevAmonia;
			event(new AmoniaOutlierUpdated($idKandang, $meanAmonia, $stdDevAmonia, $lowerAmonia, $upperAmonia, $amoniaOutlier, $amonia));

			dump([
				"mean amonia => " . $meanAmonia,
				"std dev amonia => " . $stdDevAmonia,
				"amonia lowerLimit => " . $lowerAmonia,
				"amonia upperLimit => " . $upperAmonia
			]);
		}

		// save data
		if ($suhu != null || $kelembapan != null || $amonia  != null) {
			$query = $this->sensorRepository->createSensor((object)[
				"id_kandang" =>  $idKandang,
				"datetime" => Carbon::now()->timezone('Asia/Jakarta'),
				"suhu" => $suhu,
				"kelembapan" => $kelembapan,
				"amonia" => $amonia,
				"suhu_outlier" => $suhuOutlier,
				"kelembapan_outlier" => $kelembapanOutlier,
				"amonia_outlier" => $amoniaOutlier,
			]);
		}

		// broadcast 
		event(new SensorDataUpdated($idKandang, $suhu, $kelembapan, $amonia, $suhuOutlier, $kelembapanOutlier, $amoniaOutlier));
		return response(['suhu' => $suhu, 'kelembapan' => $kelembapan, 'amonia' => $amonia, "suhu_outlier" => $suhuOutlier, "kelembapan_outlier" => $kelembapanOutlier, "amonia_outier" => $amoniaOutlier]);
	}

	protected function detectOutlier($value, $mean, $stdDev)
	{
		// Menentukan batas bawah dan batas atas ( 3 sigma)
		$lowerLimit = $mean - 3 * $stdDev;
		$upperLimit = $mean + 3 * $stdDev;

		// Deteksi outlier dan terapkan winsorizing
		if ($value < $lowerLimit) {
			return true;
		} elseif ($value > $upperLimit) {
			return true;
		}
		return false;
	}
	protected function winsorize($value, $mean, $stdDev)
	{
		// Menentukan batas bawah dan batas atas ( 3 sigma)
		$lowerLimit = $mean - 3 * $stdDev;
		$upperLimit = $mean + 3 * $stdDev;

		// Deteksi outlier dan terapkan winsorizing
		if ($value < $lowerLimit) {
			return $lowerLimit;
		} elseif ($value > $upperLimit) {
			return $upperLimit;
		}
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.suhu_outlier', 'sensors.kelembapan_outlier', 'sensors.amonia_outlier', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'kandang.nama_kandang', 'kandang.alamat_kandang')
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

		$sensor = DB::table('sensors')
			->whereRaw('DATE(sensors.datetime)  >= ? AND DATE(sensors.datetime) <= ?', [$from, $to])
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
				'sensors.id',
				'sensors.id_kandang',
				'sensors.suhu',
				'sensors.kelembapan',
				'sensors.amonia',
				'sensors.datetime',
				'kandang.nama_kandang',
				'kandang.alamat_kandang',
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.suhu_outlier', 'sensors.kelembapan_outlier', 'sensors.amonia_outlier', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}

	// filter by day
	public function getSensorByDay(Request $request)
	{
		$idKandang = $request->id_kandang;
		$day = $request->day;
		$sensor = DB::table('sensors')
			->where('data_kandang.hari_ke', '=', $day)
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.suhu_outlier', 'sensors.kelembapan_outlier', 'sensors.amonia_outlier', 'sensors.datetime', 'data_kandang.hari_ke',  'data_kandang.pakan', 'data_kandang.minum', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}
	// filter by classification
	public function getSensorByClassification(Request $request)
	{
		$idKandang = $request->id_kandang;
		$classification = $request->classification;

		if ($classification == "normal") {
			$operator = '=';
		} else {
			$operator = '>';
		}

		$sensor = DB::table('sensors')
			->having('jumlah_kematian', $operator, '0')
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
				'data_kandang.hari_ke',
				DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
				DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
				DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
			)
			->groupBy('sensors.id', 'sensors.id_kandang',  'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.suhu_outlier', 'sensors.kelembapan_outlier', 'sensors.amonia_outlier', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'kandang.nama_kandang', 'kandang.alamat_kandang')
			->orderBy('sensors.datetime', 'desc')
			->get();

		return response(['data' => $sensor, 'status' => 200]);
	}
}
