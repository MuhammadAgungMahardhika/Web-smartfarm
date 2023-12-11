<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Events\AddKandangEvent;
use App\Repositories\KandangRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KandangController extends Controller
{

	protected $kandangRepository;
	protected $model;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(Kandang $kandang, KandangRepository $kandangRepository)
	{
		$this->model = $kandang;
		$this->kandangRepository = $kandangRepository;
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

	public function getKandangByUserId($id)
	{
		$items = DB::table('kandang')->where('id_user', '=', $id)->get();
		return response(['data' => $items, 'status' => 200]);
	}
	public function getKandangByPeternakId($id)
	{
		$items = DB::table('kandang')->where('id_peternak', '=', $id)->get();
		return response(['data' => $items, 'status' => 200]);
	}
	public function getDetailKandangById($id)
	{
		$items =
			DB::table('kandang')
			->where('kandang.id', '=', $id)
			->join('data_kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
			->join('populations', 'kandang.id', '=', 'populations.id_kandang')
			->select('kandang.*', DB::raw('Sum(data_kandang.pakan) as total_pakan,Sum(data_kandang.minum) as total_minum,Sum(data_kandang.bobot) as total_bobot'), DB::raw('Min(populations.population) as sisa_population'))
			->groupBy('kandang.id')
			->get();


		// $items = $this->model->where('id', '=', $id)->with(['data_kandangs', 'populations'])->get();
		return response(['data' => $items, 'status' => 200]);
	}

	public function store(Request $request)
	{
		try {
			$request->validate([
				'nama_kandang' => 'required',
				'populasi_awal' => 'required',
				'alamat_kandang' => 'required|string',
			]);

			$kandang = $this->kandangRepository->createKandang(
				(object) [
					"id_user" => Auth::user()->id,
					"nama_kandang" => $request->nama_kandang,
					"populasi_awal" => $request->populasi_awal,
					"alamat_kandang" => $request->alamat_kandang,
					"created_by" => Auth::user()->id,
				]
			);
			// event(new AddKandangEvent( $this->model->get() ));
			return response()->json([
				'message' => 'success created kandang',
				'kandang' => $kandang
			], Response::HTTP_CREATED);
		} catch (ValidationException $e) {
			return response()->json([
				'message' => 'Validation Error',
				'errors' => $e->errors()
			], 422);
		} catch (QueryException $th) {
			return $this->handleQueryException($th);
		}
	}

	public function update(Request $request, $id)
	{
		try {
			$request->validate([
				'nama_kandang' => 'required',
				'populasi_awal' => 'required',
				'alamat_kandang' => 'required|string',
			]);

			$kandang = $this->kandangRepository->editKandang($id, (object) [
				"id_user" => Auth::user()->id,
				"nama_kandang" => $request->nama_kandang,
				"populasi_awal" => $request->populasi_awal,
				"alamat_kandang" => $request->alamat_kandang,
				"updated_by" => Auth::user()->id,
			]);
			// event(new AddKandangEvent( $this->model->get() ));
			return response()->json([
				'message' => 'success update kandang',
				'kandang' => $kandang
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
			$kandang = $this->kandangRepository->deleteKandang($id);
			return response()->json([
				'message' => 'success delete kandang',
				'kandang' => $kandang
			], Response::HTTP_OK);
		} catch (QueryException $th) {
			return $th->getMessage();
		}
	}
}
