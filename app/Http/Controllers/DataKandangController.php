<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DataKandang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\DataKandangRepository;
use App\Repositories\DataKematianRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class DataKandangController extends Controller
{

	protected $dataKandangRepository;
	protected $dataKematianRepository;
	protected $model;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(
		DataKandang $dataKandang,
		DataKandangRepository $dataKandangRepository,
		DataKematianRepository $dataKematianRepository
	) {
		$this->model = $dataKandang;
		$this->dataKandangRepository = $dataKandangRepository;
		$this->dataKematianRepository = $dataKematianRepository;
	}

	public function index()
	{
		$items = $this->model::with('data_kematians')->get();
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
			'date' => 'required',
			'classification' => 'required',
			'kematian_terbaru' => 'required',
			'jumlah_kematian' => 'required',
			'jam' => 'required',
			'hari' => 'required',
		]);

		DB::beginTransaction();
		try {
			$dataKandang = $this->dataKandangRepository->createDataKandang(
				(object) [
					"id_kandang" => $request->id_kandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"date" => $request->date,
					"classification" => $request->classification,
					"created_by" => Auth::user()->id,
				]
			);

			if (!$dataKandang) {
				throw new Exception("Failed create data kandang");
			}

			$dataKematian = $this->dataKematianRepository->createDataKematian(
				(object) [
					"id_data_kandang" => $dataKandang->id_data_kandang,
					"kematian_terbaru" => $request->kematian_terbaru,
					"jumlah_kematian" => $request->jumlah_kematian,
					"jam" => $request->jam,
					"hari" => $request->hari,
					"created_by" => Auth::user()->id,
				]
			);

			DB::commit();

			return response()->json([
				'message' => 'success created data kandang',
				'dataKandang' => $dataKandang,
				'dataKematian' => $dataKematian,
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

	public function update(Request $request, $idKandang, $idKematian)
	{
		$request->validate([
			'id_kandang' => 'required',
			'hari_ke' => 'required',
			'pakan' => 'required',
			'bobot' => 'required',
			'minum' => 'required',
			'date' => 'required',
			'classification' => 'required',
			'kematian_terbaru' => 'required',
			'jumlah_kematian' => 'required',
			'jam' => 'required',
			'hari' => 'required',
		]);

		DB::beginTransaction();
		try {
			$dataKandang = $this->dataKandangRepository->editDataKandang(
				$idKandang,
				(object) [
					"id_kandang" => $request->id_kandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"date" => $request->date,
					"classification" => $request->classification,
					"updated_by" => Auth::user()->id,
				]
			);

			if (!$dataKandang) {
				throw new Exception("Failed create data kandang");
			}

			$dataKematian = $this->dataKematianRepository->editDataKematian(
				$idKematian,
				(object) [
					"id_data_kandang" => $dataKandang->id_data_kandang,
					"kematian_terbaru" => $request->kematian_terbaru,
					"jumlah_kematian" => $request->jumlah_kematian,
					"jam" => $request->jam,
					"hari" => $request->hari,
					"updated_by" => Auth::user()->id,
				]
			);

			DB::commit();

			return response()->json([
				'message' => 'success updated data kandang',
				'dataKandang' => $dataKandang,
				'dataKematian' => $dataKematian,
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

	public function delete($idKematian, $idKandang)
	{
		DB::beginTransaction();
		try {
			$dataKematian = $this->dataKematianRepository->deleteDataKematian($idKematian);

			$dataKandang = $this->dataKandangRepository->deleteDataKandang($idKandang);

			return response()->json([
				'message' => 'success delete data kandang',
				'dataKematian' => $dataKematian,
				'dataKandang' => $dataKandang
			], Response::HTTP_OK);
		} catch (QueryException $th) {
			return $th->getMessage();
		}
	}
}
