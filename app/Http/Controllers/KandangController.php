<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Kandang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\KandangRepository;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KandangController extends Controller
{

	protected $kandangRepository;
	/**
	 * Create a new controller instance.
	 */
	public function __construct(KandangRepository $kandangRepository)
	{
		$this->kandangRepository = $kandangRepository;
	}

	public function index($id = null)
	{
		if ($id != null) {
			$items = DB::table('kandang')
				->where('kandang.id', '=', $id)
				->leftJoin('data_kandang', 'kandang.id', 'data_kandang.id_kandang')
				->leftJoin('data_kematian', 'data_kandang.id', 'data_kematian.id_data_kandang')
				->leftjoin('users as user', 'kandang.id_user', '=', 'user.id')
				->leftjoin('users as peternak', 'kandang.id_peternak', '=', 'peternak.id')
				->select('kandang.id', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.luas_kandang', 'kandang.populasi_awal', 'kandang.populasi_saat_ini', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'), 'user.id as id_pemilik', 'user.name as nama_pemilik', 'user.email as email_pemilik', 'peternak.id as id_peternak', 'peternak.name as nama_peternak', 'peternak.email as email_peternak')
				->groupBy('kandang.id', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.luas_kandang', 'kandang.populasi_awal', 'kandang.populasi_saat_ini', 'user.id', 'user.name', 'user.email', 'peternak.id', 'peternak.name', 'peternak.email')
				->first();
		} else {
			$items = DB::table('kandang')
				->leftJoin('data_kandang', 'kandang.id', 'data_kandang.id_kandang')
				->leftJoin('data_kematian', 'data_kandang.id', 'data_kematian.id_data_kandang')
				->leftjoin('users as user', 'kandang.id_user', '=', 'user.id')
				->leftjoin('users as peternak', 'kandang.id_peternak', '=', 'peternak.id')
				->select('kandang.id', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.luas_kandang', 'kandang.populasi_awal', 'kandang.populasi_saat_ini', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'), 'user.id as id_pemilik', 'user.name as nama_pemilik', 'user.email as email_pemilik', 'peternak.id as id_peternak', 'peternak.name as nama_peternak', 'peternak.email as email_peternak')
				->groupBy('kandang.id', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.luas_kandang', 'kandang.populasi_awal', 'kandang.populasi_saat_ini', 'user.id', 'user.name', 'user.email', 'peternak.id', 'peternak.name', 'peternak.email')
				->get();
		}
		return response(['data' => $items, 'status' => 200]);
	}

	public function getKandangByUserId($id)
	{
		$items = DB::table('kandang')->where('id_user', '=', $id)->get();
		return response(['data' => $items, 'status' => 200]);
	}

	public function setKandangStatusToInactive($id)
	{
		try {
			$kandang = Kandang::findOrFail($id);
			$kandang->status = "nonaktif";
			$kandang->save();

			return response(['data' => true, 'status' => 200]);
		} catch (QueryException $th) {
			return $this->handleQueryException($th);
		}
	}
	public function getKandangByPeternakId($id)
	{
		$items = DB::table('kandang')->where('id_peternak', '=', $id)->get();
		return response(['data' => $items, 'status' => 200]);
	}

	public function store(Request $request)
	{
		try {
			$request->validate([
				'nama_kandang' => 'required',
				'alamat_kandang' => 'required|string',
				'luas_kandang' => 'required',
				'populasi_awal' => 'required',
				'id_user' => 'required',
				'id_peternak' => 'required'
			]);

			$kandang = $this->kandangRepository->createKandang(
				(object) [
					"nama_kandang" => $request->nama_kandang,
					"alamat_kandang" => $request->alamat_kandang,
					"luas_kandang" => $request->luas_kandang,
					"populasi_awal" => $request->populasi_awal,
					"populasi_saat_ini" => $request->populasi_awal,
					"id_user" => $request->id_user,
					"id_peternak" => $request->id_peternak,
					"created_by" => Auth::user()->id,
				]
			);
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
				'alamat_kandang' => 'required|string',
				'luas_kandang' => 'required',
				'populasi_awal' => 'required',
				'populasi_saat_ini' => 'required',
				'id_user' => 'required',
				'id_peternak' => 'required',
			]);

			$kandang = $this->kandangRepository->editKandang($id, (object) [
				"nama_kandang" => $request->nama_kandang,
				"alamat_kandang" => $request->alamat_kandang,
				"luas_kandang" => $request->luas_kandang,
				"populasi_awal" => $request->populasi_awal,
				"populasi_saat_ini" => $request->populasi_saat_ini,
				"id_user" => $request->id_user,
				"id_peternak" => $request->id_peternak,
				"updated_by" => Auth::user()->id,
				"updated_at" => Carbon::now()->timezone('Asia/Jakarta'),
			]);

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
