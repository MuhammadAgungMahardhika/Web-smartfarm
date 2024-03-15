<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Panen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\PanenRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PanenController extends Controller
{

	protected $panenRepository;

	/**
	 * Create a new controller instance.
	 */
	public function __construct(PanenRepository $panenRepository)
	{
		$this->panenRepository = $panenRepository;
	}

	public function index($id = null)
	{
		if ($id != null) {
			$items = Panen::with('kandang')->find($id);
		} else {
			$items = Panen::get();
		}
		return response(['data' => $items, 'status' => 200]);
	}
	public function getPanenByKandangId($id)
	{
		$items = DB::table('panen')->where('id_kandang', '=', $id)->get();
		return response(['data' => $items, 'status' => 200]);
	}
	public function getPanenByDate(Request $request)
	{
		$idKandang = $request->id_kandang;
		$from = date('Y-m-d', strtotime($request->from));
		$to = date('Y-m-d', strtotime($request->to));
		$items = DB::table('panen')
			->where('id_kandang', $idKandang)
			->where(function ($query) use ($from, $to) {
				$query->whereRaw('tanggal_panen >= ? AND tanggal_panen <= ?', [$from, $to]);
			})
			->get();

		return response(['data' => $items, 'status' => 200]);
	}

	public function store(Request $request)
	{
		try {
			$request->validate([
				'id_kandang' => 'required',
				'tanggal_mulai' => 'required',
				'tanggal_panen' => 'required',
				'jumlah_panen' => 'required|integer',
				'bobot_total' => 'required|integer',
			]);

			$panen = $this->panenRepository->createPanen(
				(object) [
					"id" => 1,
					"id_kandang" => $request->id_kandang,
					"tanggal_mulai" => $request->tanggal_mulai,
					"tanggal_panen" => $request->tanggal_panen,
					"jumlah_panen" => $request->jumlah_panen,
					"bobot_total" => $request->bobot_total,
					"created_by" => Auth::user()->id,
				]
			);
			// event(new AddKandangEvent( $this->model->get() ));
			return response()->json([
				'message' => 'success created panen',
				'panen' => $panen
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
				'tanggal_mulai' => 'required',
				'tanggal_panen' => 'required',
				'jumlah_panen' => 'required|integer',
				'bobot_total' => 'required|integer',
			]);

			$panen = $this->panenRepository->editPanen($id, (object) [
				"id_kandang" => $request->id_kandang,
				"tanggal_mulai" => $request->tanggal_mulai,
				"tanggal_panen" => $request->tanggal_panen,
				"jumlah_panen" => $request->jumlah_panen,
				"bobot_total" => $request->bobot_total,
				"updated_by" => Auth::user()->id,
			]);
			// event(new AddKandangEvent( $this->model->get() ));
			return response()->json([
				'message' => 'success update panen',
				'panen' => $panen
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
			$panen = $this->panenRepository->deletePanen($id);
			return response()->json([
				'message' => 'success delete panen',
				'panen' => $panen
			], Response::HTTP_OK);
		} catch (QueryException $th) {
			return $th->getMessage();
		}
	}
}
