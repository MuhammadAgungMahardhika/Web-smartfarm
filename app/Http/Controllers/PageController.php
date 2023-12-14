<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function user()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();
        return view('pages/users', $data);
    }
    public function Dashboard()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();
        return view('pages/dashboard', $data);
    }
    public function dataKandang()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();

        return view('pages/dataKandang', $data);
    }
    public function forecast()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();

        return view('pages/forecast', $data);
    }
    public function hasilPanen()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();

        return view('pages/hasilPanen', $data);
    }
    public function inputHarian()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();

        return view('pages/inputHarian', $data);
    }
    public function notifikasi()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();

        return view('pages/notifikasi', $data);
    }
    public function klasifikasi()
    {
        $data =  DB::table('kandang')->where('id_user', Auth::user()->id)->get()->toArray();

        return view('pages/klasifikasi', $data);
    }
}
