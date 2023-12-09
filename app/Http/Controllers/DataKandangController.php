<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DataKandang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\DataKandangRepository;
use App\Repositories\DataKematianRepository;
use Carbon\Carbon;
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

	public function index($id = null)
	{
		if ($id != null) {
			$items = $this->model::find($id);
		} else {

			$items = $this->model->get();
		}
		return response(['data' => $items, 'status' => 200]);
	}

	public function getDataKandangByIdKandang($id)
	{
		$items = DB::table('data_kandang')->where('id_kandang', '=', $id)->get();
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
			'date' => 'required'
		]);

		try {
			$dataKandang = $this->dataKandangRepository->createDataKandang(
				(object) [
					"id_kandang" => $request->id_kandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"date" => $request->date,
					"created_by" => Auth::user()->id,
				]
			);
			return response()->json([
				'message' => 'success created data kandang',
				'dataKandang' => $dataKandang
			], Response::HTTP_CREATED);
		} catch (ValidationException $e) {
			return response()->json([
				'message' => 'Validation Error',
				'errors' => $e->errors()
			], 422);
		} catch (QueryException $th) {
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
		]);

		try {
			$dataKandang = $this->dataKandangRepository->editDataKandang(
				$id,
				(object) [
					"id_kandang" => $request->id_kandang,
					"hari_ke" => $request->hari_ke,
					"pakan" => $request->pakan,
					"bobot" => $request->bobot,
					"minum" => $request->minum,
					"date" => Carbon::now()->timezone('Asia/Jakarta'),
					"updated_by" => Auth::user()->id,
				]
			);
			return response()->json([
				'message' => 'success updated data kandang',
				'dataKandang' => $dataKandang
			], Response::HTTP_OK);
		} catch (ValidationException $e) {
			return response()->json([
				'message' => 'Validation Error',
				'errors' => $e->errors()
			], 422);
		} catch (QueryException $th) {
			return $th->getMessage();
		}
	}

	public function delete($id)
	{
		try {
			$dataKandang = $this->dataKandangRepository->deleteDataKandang($id);
			return response()->json([
				'message' => 'success delete data kandang',
				'dataKandang' => $dataKandang
			], Response::HTTP_OK);
		} catch (QueryException $th) {
			return $th->getMessage();
		}
	}
}
