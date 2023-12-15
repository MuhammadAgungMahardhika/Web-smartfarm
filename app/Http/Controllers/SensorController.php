<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AmoniakSensor;
use App\Models\SuhuKelembapanSensor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\AmoniakRepository;
use App\Repositories\SuhuKelembapanRepository;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class SensorController extends Controller
{

	protected $amoniakRepository;
	protected $suhuKelembapanRepository;
	protected $modelSuhuKelembapanSensor, $modelAmoniak;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(
		AmoniakSensor $amoniakSensor,
		SuhuKelembapanSensor $suhuKelembapanSensor,
		AmoniakRepository $amoniakRepository,
		SuhuKelembapanRepository $suhuKelembapanRepository
	) {
		$this->modelAmoniak = $amoniakSensor;
		$this->modelSuhuKelembapanSensor = $suhuKelembapanSensor;
		$this->amoniakRepository = $amoniakRepository;
		$this->suhuKelembapanRepository = $suhuKelembapanRepository;
	}

	public function sensorLuar($idKandang, $suhu = null, $kelembapan = null, $amonia = null)
	{

		// Suhu dan Kelembapan
		if ($suhu != null || $kelembapan != null) {
			$this->suhuKelembapanRepository->createSuhuKelembapanSensor((object)[
				"id_kandang" => $idKandang,
				"date" => Carbon::now()->timezone('Asia/Jakarta'),
				"suhu" => $suhu,
				"kelembapan" => $kelembapan
			]);
		}

		// Amonia
		if ($amonia != null) {
			$this->amoniakRepository->createAmoniak((object)[
				"id_kandang" => $idKandang,
				"date" => Carbon::now()->timezone('Asia/Jakarta'),
				"amoniak" => $amonia
			]);
		}


		return response(['suhu' => $suhu, 'kelembapan' => $kelembapan, 'amonia' => $amonia]);
	}

	public function indexAmonia($idKandang)
	{
		$items = $this->modelAmoniak
			->where('id_kandang', '=', $idKandang)
			->orderBy('date', 'DESC')
			->first();
		return response(['data' => $items, 'status' => 200]);
	}

	public function indexSuhuKelembapan($idKandang)
	{
		$items = $this->modelSuhuKelembapanSensor
			->where('id_kandang', '=', $idKandang)
			->orderBy('date', 'DESC')
			->first();
		return response(['data' => $items, 'status' => 200]);
	}

	public function storeAmoniak(Request $request)
	{
		try {
			$request->validate([
				'id_kandang' => 'required',
				'amoniak' => 'required',
			]);

			$amoniak = $this->amoniakRepository->createAmoniak(
				(object) [
					"id_kandang" => $request->id_kandang,
					"date" => Carbon::now()->timezone('Asia/Jakarta'),
					"amoniak" => $request->amoniak,
				]
			);
			return response()->json([
				'message' => 'success created sensor amoniak',
				'amoniak' => $amoniak
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

	public function storeSuhuKelembapan(Request $request)
	{
		try {
			$request->validate([
				'id_kandang' => 'required',
				'suhu' => 'required',
				'kelembapan' => 'required',
			]);

			$suhuKelembapan = $this->suhuKelembapanRepository->createSuhuKelembapanSensor(
				(object) [
					"id_kandang" => $request->id_kandang,
					"date" => Carbon::now()->timezone('Asia/Jakarta'),
					"suhu" => $request->suhu,
					"kelembapan" => $request->kelembapan,
				]
			);
			return response()->json([
				'message' => 'success created sensor suhu kelembapan',
				'suhuKelembapan' => $suhuKelembapan
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
}
