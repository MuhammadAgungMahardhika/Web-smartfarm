<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DataKandang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\DataKandangRepository;
use App\Repositories\DataKematianRepository;
use App\Repositories\KandangRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DataKandangController extends Controller
{

	protected $kandangRepository;
	protected $dataKandangRepository;
	protected $dataKematianRepository;
	protected $model;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(
		DataKandang $dataKandang,
		KandangRepository $kandangRepository,
		DataKandangRepository $dataKandangRepository,
		DataKematianRepository $dataKematianRepository
	) {
		$this->model = $dataKandang;
		$this->kandangRepository = $kandangRepository;
		$this->dataKandangRepository = $dataKandangRepository;
		$this->dataKematianRepository = $dataKematianRepository;
	}

	public function index($id = null)
	{
		if ($id != null) {
			$items = $this->model::with('data_kematians')->find($id);
		} else {

			$items = $this->model->get();
		}
		return response(['data' => $items, 'status' => 200]);
	}

	public function getDataKandangByIdKandang($id)
	{
		$items = DB::table('data_kandang')->where('id_kandang', '=', $id)
			->join('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id', 'left')
			->select('data_kandang.*', DB::raw('COALESCE(sum(data_kematian.jumlah_kematian),0) as total_kematian'))
			->groupBy('data_kandang.id', 'data_kematian.id_data_kandang')
			->orderBy('data_kandang.id', 'ASC')
			->get();
		return response(['data' => $items, 'status' => 200]);
	}

	public function getDetailKandangByIdKandang($id)
	{
		$items = DB::table('data_kandang')->where('id_kandang', '=', $id)
			->join('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id', 'left')
			->join('kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
			->select('data_kandang.*', 'kandang.*', DB::raw('COALESCE(sum(data_kematian.jumlah_kematian),0) as total_kematian'))
			->groupBy('data_kandang.id', 'data_kematian.id_data_kandang')
			->orderBy('data_kandang.id', 'ASC')
			->get();
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
			'classification' => 'required',
			'date' => 'required'
		]);

		DB::beginTransaction();
		try {
			$idKandang = $request->id_kandang;
			$riwayatPopulasi = $request->riwayat_populasi;
			$dataKandang = $this->dataKandangRepository->createDataKandang(
				(object) [
					"id_kandang" => $idKandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"riwayat_populasi" => $riwayatPopulasi,
					"classification" => $request->classification,
					"date" => $request->date,
					"created_by" => Auth::user()->id,
				]
			);

			$dataKematian = $request->data_kematian;
			if (count($dataKematian) > 0) {
				for ($i = 0; $i < count($dataKematian); $i++) {
					$jamKematian = $dataKematian[$i]['jam'];
					$jumlahKematian = $dataKematian[$i]['jumlah_kematian'];

					$this->dataKematianRepository->createDataKematian(
						(object)[
							"id_data_kandang" => $dataKandang->id,
							"jumlah_kematian" => $jumlahKematian,
							"jam" => $jamKematian,
							"created_by" => Auth::user()->id
						]
					);
				}
			}

			$this->kandangRepository->changeKandangPopulation($idKandang, (object)[
				"populasi_saat_ini" => intval($riwayatPopulasi)
			]);

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
			'classification' => 'required',
			'date' => 'required'
		]);

		DB::beginTransaction();
		try {
			$idKandang = $request->id_kandang;
			$riwayatPopulasi = $request->riwayat_populasi;
			$dataKandang = $this->dataKandangRepository->editDataKandang(
				$id,
				(object) [
					"id_kandang" => $idKandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"riwayat_populasi" => $riwayatPopulasi,
					"classification" => $request->classification,
					"date" => $request->date,
					"updated_by" => Auth::user()->id,
				]
			);

			// delete data kematian
			$this->dataKematianRepository->deleteDataKematianByDataKandangId($id);
			// insert data kematian baru
			$dataKematian = $request->data_kematian;
			if (count($dataKematian) > 0) {
				for ($i = 0; $i < count($dataKematian); $i++) {
					$this->dataKematianRepository->createDataKematian(
						(object)[
							"id_data_kandang" => $dataKandang->id,
							"jumlah_kematian" => $dataKematian[$i]['jumlah_kematian'],
							"jam" => $dataKematian[$i]['jam'],
							"created_by" => Auth::user()->id
						]
					);
				}
			}

			// Ubah nilai populasi saat ini
			$this->kandangRepository->changeKandangPopulation($idKandang, (object)[
				"populasi_saat_ini" => intval($riwayatPopulasi)
			]);

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
