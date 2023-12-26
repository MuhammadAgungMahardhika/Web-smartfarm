<?php

namespace App\Http\Controllers;

use App\Events\NotificationSent;
use Illuminate\Support\Facades\Auth;
use App\Models\DataKandang;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\DataKandangRepository;
use App\Repositories\DataKematianRepository;
use App\Repositories\KandangRepository;
use App\Repositories\NotificationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DataKandangController extends Controller
{

	protected $kandangRepository;
	protected $dataKandangRepository;
	protected $dataKematianRepository;
	protected $notificationRepository;
	protected $model;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(
		DataKandang $dataKandang,
		KandangRepository $kandangRepository,
		DataKandangRepository $dataKandangRepository,
		DataKematianRepository $dataKematianRepository,
		NotificationRepository $notificationRepository
	) {
		$this->model = $dataKandang;
		$this->kandangRepository = $kandangRepository;
		$this->dataKandangRepository = $dataKandangRepository;
		$this->dataKematianRepository = $dataKematianRepository;
		$this->notificationRepository = $notificationRepository;
	}

	public function index($id = null)
	{
		if ($id != null) {
			$items = $this->model::with(['kandang', 'data_kematians'])->find($id);
		} else {

			$items = $this->model->get();
		}
		return response(['data' => $items, 'status' => 200]);
	}

	public function getDataKandangByIdKandang($id)
	{

		$items =  DB::table('data_kandang')
			->join('kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
			->leftJoin('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id')
			->select('data_kandang.*', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'), DB::raw('GROUP_CONCAT(data_kematian.jam SEPARATOR ",") AS jam_kematian'))
			->groupBy('data_kandang.id', 'data_kandang.id_kandang', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'data_kandang.riwayat_populasi', 'data_kandang.date', 'data_kandang.classification', 'data_kandang.created_at', 'data_kandang.created_by', 'data_kandang.updated_at', 'data_kandang.updated_by', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang')
			->where('data_kandang.id_kandang', '=', $id)
			->orderBy('data_kandang.created_at', 'ASC')
			->get();
		return response(['data' => $items, 'status' => 200]);
	}
	// Filter by Date
	public function getDataKandangByDate(Request $request)
	{
		$idKandang = $request->id_kandang;
		$from = $request->from;
		$to = $request->to;

		$items =  DB::table('data_kandang')
			->join('kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
			->leftJoin('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id')
			->select('data_kandang.*', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'))
			->groupBy('data_kandang.id', 'data_kandang.id_kandang', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'data_kandang.riwayat_populasi', 'data_kandang.date', 'data_kandang.classification', 'data_kandang.created_at', 'data_kandang.created_by', 'data_kandang.updated_at', 'data_kandang.updated_by', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang')
			->where('data_kandang.id_kandang', '=', $idKandang)
			->where(function ($query) use ($from, $to) {
				$query->whereRaw('data_kandang.date >= ? AND data_kandang.date <= ?', [$from, $to]);
			})
			->orderBy('data_kandang.created_at', 'ASC')
			->get();
		return response(['data' => $items, 'status' => 200]);
	}

	// Filter By Classification
	public function getDataKandangByClassification(Request $request)
	{
		$idKandang = $request->id_kandang;
		$classification = $request->classification;

		$items =  DB::table('data_kandang')
			->join('kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
			->leftJoin('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id')
			->select('data_kandang.*', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'))
			->groupBy('data_kandang.id', 'data_kandang.id_kandang', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'data_kandang.riwayat_populasi', 'data_kandang.date', 'data_kandang.classification', 'data_kandang.created_at', 'data_kandang.created_by', 'data_kandang.updated_at', 'data_kandang.updated_by', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang')
			->where('data_kandang.id_kandang', '=', $idKandang)
			->where('data_kandang.classification', '=', $classification)
			->orderBy('data_kandang.created_at', 'ASC')
			->get();
		return response(['data' => $items, 'status' => 200]);
	}

	// Filter By Day
	public function getDataKandangByDay(Request $request)
	{
		$idKandang = $request->id_kandang;
		$day = $request->day;

		$items =  DB::table('data_kandang')
			->join('kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
			->leftJoin('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id')
			->select('data_kandang.*', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'))
			->groupBy('data_kandang.id', 'data_kandang.id_kandang', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'data_kandang.riwayat_populasi', 'data_kandang.date', 'data_kandang.classification', 'data_kandang.created_at', 'data_kandang.created_by', 'data_kandang.updated_at', 'data_kandang.updated_by', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.populasi_awal', 'kandang.luas_kandang')
			->where('data_kandang.id_kandang', '=', $idKandang)
			->where('data_kandang.hari_ke', '=', $day)
			->orderBy('data_kandang.created_at', 'ASC')
			->get();
		return response(['data' => $items, 'status' => 200]);
	}

	public function getDetailKandangByIdKandang($id)
	{
		$items = Kandang::with('data_kandangs')->where('id', $id)->get();

		return response(['data' => $items, 'status' => 200]);
	}
	public function getJumlahKematianByDataKandangId($id)
	{
		$items = DB::table('data_kematian')->where('data_kematian.id_data_kandang', '=', $id)->select(DB::raw('COALESCE(sum(data_kematian.jumlah_kematian),0) as total_kematian'))->first();
		return response(['data' => $items, 'status' => 200]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'id_kandang' => 'required',
			'hari_ke' => 'required',
			'pakan' => 'required',
			'bobot' => 'required',
			'minum' => 'required',
			'riwayat_populasi' => 'required',
			'date' => 'required'
		]);

		DB::beginTransaction();
		try {
			$idKandang = $request->id_kandang;
			$riwayatPopulasi = $request->riwayat_populasi;
			$dataKematian = $request->data_kematian;
			$klasifikasi = count($dataKematian) > 0 ? "abnormal" : "normal";
			$dataKandang = $this->dataKandangRepository->createDataKandang(
				(object) [
					"id_kandang" => $idKandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"riwayat_populasi" => $riwayatPopulasi,
					"classification" => $klasifikasi,
					"date" => $request->date,
					"created_at" => Carbon::now()->timezone('Asia/Jakarta'),
					"created_by" => Auth::user()->id,
				]
			);

			if (count($dataKematian) > 0) {
				for ($i = 0; $i < count($dataKematian); $i++) {
					$jamKematian = $dataKematian[$i]['jam'];
					$jumlahKematian = $dataKematian[$i]['jumlah_kematian'];

					$this->dataKematianRepository->createDataKematian(
						(object)[
							"id_data_kandang" => $dataKandang->id,
							"jumlah_kematian" => $jumlahKematian,
							"jam" => $jamKematian,
							"created_at" => Carbon::now()->timezone('Asia/Jakarta'),
							"created_by" => Auth::user()->id
						]
					);
				}
			}

			$this->kandangRepository->changeKandangPopulation($idKandang, (object)[
				"populasi_saat_ini" => intval($riwayatPopulasi)
			]);

			// give notification
			if ($klasifikasi == "abnormal") {
				// triggered event
				$this->notificationRepository->createNotification((object)[
					"id_kandang" => $idKandang,
					"pesan" => "Ditemukan status tidak normal pada kandang",
					"status" => 1,
					"waktu" =>  Carbon::now()->timezone('Asia/Jakarta')
				]);
			}

			DB::commit();
			return response()->json([
				'message' => 'success created data kandang',
				'dataKandang' => $dataKandang,
			], Response::HTTP_CREATED);
		} catch (ValidationException $e) {
			DB::rollBack();
			return response()->json([
				'message' => 'Validation Error',
				'errors' => $e->errors()
			], 422);
		} catch (QueryException $th) {
			DB::rollBack();
			return $th->getMessage();
		}
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'id_kandang' => 'required',
			'hari_ke' => 'required',
			'pakan' => 'required',
			'bobot' => 'required',
			'minum' => 'required',
			'riwayat_populasi' => 'required',
			'date' => 'required'
		]);

		DB::beginTransaction();
		try {
			$idKandang = $request->id_kandang;
			$riwayatPopulasi = $request->riwayat_populasi;
			$dataKematian = $request->data_kematian;
			$klasifikasi = count($dataKematian) > 0 ? "abnormal" : "normal";
			$dataKandang = $this->dataKandangRepository->editDataKandang(
				$id,
				(object) [
					"id_kandang" => $idKandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"riwayat_populasi" => $riwayatPopulasi,
					"classification" => $klasifikasi,
					"date" => $request->date,
					"updated_at" => Carbon::now()->timezone('Asia/Jakarta'),
					"updated_by" => Auth::user()->id,
				]
			);

			// delete data kematian
			$this->dataKematianRepository->deleteDataKematianByDataKandangId($id);
			// insert data kematian baru
			if (count($dataKematian) > 0) {
				for ($i = 0; $i < count($dataKematian); $i++) {
					$this->dataKematianRepository->createDataKematian(
						(object)[
							"id_data_kandang" => $dataKandang->id,
							"jumlah_kematian" => $dataKematian[$i]['jumlah_kematian'],
							"jam" => $dataKematian[$i]['jam'],
							"created_at" => Carbon::now()->timezone('Asia/Jakarta'),
							"created_by" => Auth::user()->id
						]
					);
				}
			}

			// Ubah nilai populasi saat ini
			$this->kandangRepository->changeKandangPopulation($idKandang, (object)[
				"populasi_saat_ini" => intval($riwayatPopulasi)
			]);

			// Kirim notifikasi
			if ($klasifikasi == "abnormal") {
				Event(new NotificationSent($idKandang, "Ditemukan keadaan Abnormal pada kandang"));
			}

			DB::commit();
			return response()->json([
				'message' => 'success updated data kandang',
				'dataKandang' => $dataKandang
			], Response::HTTP_OK);
		} catch (ValidationException $e) {
			DB::rollBack();
			return response()->json([
				'message' => 'Validation Error',
				'errors' => $e->errors()
			], 422);
		} catch (QueryException $th) {
			DB::rollBack();
			return $th->getMessage();
		}
	}

	public function delete($id)
	{
		DB::beginTransaction();
		try {
			$dataKematian = DB::table('data_kematian')->where('data_kematian.id_data_kandang', '=', $id)
				->select(DB::raw('Sum(jumlah_kematian) as total_kematian'))
				->first();

			$jumlahKematian =  $dataKematian->total_kematian;

			$dataKandang = $this->dataKandangRepository->deleteDataKandang($id);
			$idKandang = $dataKandang->id_kandang;
			$populasiSaatIni = DB::table('kandang')->where('kandang.id', '=', $idKandang)->select('kandang.populasi_saat_ini')->first()->populasi_saat_ini;
			$populasiAkhir = intval($populasiSaatIni)  + intval($jumlahKematian);

			$this->kandangRepository->changeKandangPopulation($idKandang, (object)[
				"populasi_saat_ini" => $populasiAkhir
			]);
			DB::commit();
			return response()->json([
				'message' => 'success delete data kandang',
				'dataKandang' => $dataKandang
			], Response::HTTP_OK);
		} catch (QueryException $th) {
			DB::rollBack();
			return $th->getMessage();
		}
	}
}
