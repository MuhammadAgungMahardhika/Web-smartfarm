<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function user()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();
        $send = [
            'data' => $data
        ];
        return view('pages/users', $send);
    }
    public function Dashboard()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();
        $send = [
            'data' => $data
        ];
        return view('pages/dashboard', $send);
    }
    public function dataKandang()
    {
        $data =  Kandang::with('data_kandangs')->where('id_user', Auth::user()->id)->get();
        // dd($data->toArray());
        $send = [
            'data' => $data
        ];
        return view('pages/dataKandang', $send);
    }
    public function forecast()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();
        $send = [
            'data' => $data
        ];
        return view('pages/forecast', $send);
    }
    public function hasilPanen()
    {
        $data = Kandang::with('panens')->where('kandang.id_user', Auth::user()->id)->get();
        $send = [
            'data' => $data
        ];
        return view('pages/hasilPanen', $send);
    }
    public function inputHarian()
    {
        $kandang = Kandang::where('kandang.id_peternak', Auth::user()->id)->get();
        $data = Kandang::join('data_kandang', 'kandang.id', '=', 'data_kandang.id_kandang')
            ->leftJoin('data_kematian', 'data_kandang.id', '=', 'data_kematian.id_data_kandang')
            ->select('kandang.*', 'data_kandang.*', DB::raw('COALESCE(sum(data_kematian.jumlah_kematian),0) as total_kematian'))
            ->groupBy('data_kandang.id')
            ->where('kandang.id_peternak', Auth::user()->id)
            ->orderBy('data_kandang.created_at', 'ASC')
            ->get();

        $send = [
            'kandang' => $kandang,
            'data' => $data
        ];

        return view('pages/inputHarian', $send);
    }
    public function notifikasi()
    {

        // check role, peternak or pemilik
        if (Auth::user()->id_role == 3) {
            $checkUser = 'id_peternak';
        } else if (Auth::user()->id_role == 2) {
            $checkUser = "id_user";
        }

        $data =  Kandang::with('notification')->where($checkUser, Auth::user()->id)->get();
        $send = [
            'data' => $data
        ];
        return view('pages/notifikasi', $send);
    }
    public function klasifikasi()
    {
        // check role, peternak or pemilik
        if (Auth::user()->id_role == 3) {
            $checkUser = 'id_peternak';
        } else if (Auth::user()->id_role == 2) {
            $checkUser = "id_user";
        }

        $data = Kandang::with('data_kandangs')->where($checkUser, Auth::user()->id)->get();
        $send = [
            'data' => $data
        ];
        return view('pages/klasifikasi', $send);
    }
}
