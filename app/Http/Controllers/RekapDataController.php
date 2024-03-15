<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RekapDatum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


use App\Repositories\RekapDataRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RekapDataController extends Controller
{

	protected $rekapDataRepository;
	protected $model;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(RekapDatum $rekapData, RekapDataRepository $rekapDataRepository)
	{

		$this->model = $rekapData;
		$this->rekapDataRepository = $rekapDataRepository;
	}

	public function index($id = null)
	{
		if ($id != null) {
			$items = $this->model::findOrFail($id);
		} else {
			$items = $this->model->get();
		}
		return response(['data' => $items, 'status' => 200]);
	}

	public function getRekapDataByKandangId($id)
	{
		$items = DB::table('rekap_data')->where('id_kandang', '=', $id)->get();
		return response(['data' => $items, 'status' => 200]);
	}

	public function store(Request $request)
	{
		try {
			$request->validate([
				'id_kandang' => 'required',
				'hari_ke' => 'required',
				'date' => 'required',
				'rata_rata_amoniak' => 'required',
				'rata_rata_suhu' => 'required',
				'kelembapan' => 'required',
				'pakan' => 'required',
				'minum' => 'required',
				'jumlah_kematian_harian' => 'required',
			]);

			$rekapData = $this->rekapDataRepository->createRekapData(
				(object) [
					"id_kandang" => $request->id_kandang,
					"hari_ke" => $request->hari_ke,
					"date" => $request->date,
					"rata_rata_amoniak" => $request->rata_rata_amoniak,
					"rata_rata_suhu" => $request->rata_rata_suhu,
					"kelembapan" => $request->kelembapan,
					"pakan" => $request->pakan,
					"minum" => $request->minum,
					// "jumlah_kematian" => $request->jumlah_kematian,
					"jumlah_kematian_harian" => $request->jumlah_kematian_harian,
					"created_by" => Auth::user()->id,
				]
			);
			return response()->json([
				'message' => 'success created rekap data',
				'kandang' => $rekapData
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
		try {
			$request->validate([
				'id_kandang' => 'required',
				'hari_ke' => 'required',
				'date' => 'required',
				'rata_rata_amoniak' => 'required',
				'rata_rata_suhu' => 'required',
				'kelembapan' => 'required',
				'pakan' => 'required',
				'minum' => 'required',
				'jumlah_kematian_harian' => 'required',
			]);

			$rekapData = $this->rekapDataRepository->editDataKandang($id, (object) [
				"id_kandang" => $request->id_kandang,
				"hari_ke" => $request->hari_ke,
				"date" => $request->date,
				"rata_rata_amoniak" => $request->rata_rata_amoniak,
				"rata_rata_suhu" => $request->rata_rata_suhu,
				"kelembapan" => $request->kelembapan,
				"pakan" => $request->pakan,
				"minum" => $request->minum,
				// "jumlah_kematian" => $request->jumlah_kematian,
				"jumlah_kematian_harian" => $request->jumlah_kematian_harian,
				"updated_by" => Auth::user()->id,
			]);

			return response()->json([
				'message' => 'success update rekap data',
				'kandang' => $rekapData
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
			$rekapData = $this->rekapDataRepository->deleteDataKandang($id);
			return response()->json([
				'message' => 'success delete rekap data',
				'kandang' => $rekapData
			], Response::HTTP_OK);
		} catch (QueryException $th) {
			return $th->getMessage();
		}
	}
}
