<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{

    public function user()
    {
        $data =  User::with('roles')->get();
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
    public function Kandang()
    {
        $data = DB::table('kandang')
            ->leftJoin('data_kandang', 'kandang.id', 'data_kandang.id_kandang')
            ->leftJoin('data_kematian', 'data_kandang.id', 'data_kematian.id_data_kandang')
            ->leftjoin('users as user', 'kandang.id_user', '=', 'user.id')
            ->leftjoin('users as peternak', 'kandang.id_peternak', '=', 'peternak.id')
            ->select('kandang.id', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.luas_kandang', 'kandang.populasi_awal', 'kandang.populasi_saat_ini', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'), 'user.id as id_pemilik', 'user.name as nama_pemilik', 'user.email as email_pemilik', 'peternak.id as id_peternak', 'peternak.name as nama_peternak', 'peternak.email as email_peternak')
            ->groupBy('kandang.id', 'kandang.nama_kandang', 'kandang.alamat_kandang', 'kandang.luas_kandang', 'kandang.populasi_awal', 'kandang.populasi_saat_ini', 'user.id', 'user.name', 'user.email', 'peternak.id', 'peternak.name', 'peternak.email')
            ->get();
        $send = [
            'data' => $data
        ];

        return view('pages/kandangList', $send);
    }
    public function monitoringKandang()
    {
        $kandang = Kandang::where('kandang.id_user', Auth::user()->id)->get();
        $data = DB::table('sensors')
            ->where('kandang.id_user', '=', Auth::user()->id)
            ->where('kandang.id', '=', $kandang[0]->id)
            ->where('sensors.is_outlier', '=', false)
            ->leftJoin('kandang', function ($join) {
                $join->on('kandang.id', '=', 'sensors.id_kandang');
            })
            ->leftJoin('data_kandang', function ($join) {
                $join->on('data_kandang.id_kandang', '=', 'kandang.id')
                    ->on(DB::raw('DATE(data_kandang.date)'), '=', DB::raw('DATE(sensors.datetime)'));
            })
            ->leftJoin('data_kematian', function ($join) {
                $join->on('data_kematian.id_data_kandang', '=', 'data_kandang.id');
            })
            ->select(
                'sensors.*',
                'kandang.nama_kandang',
                'kandang.alamat_kandang',
                'data_kandang.hari_ke',
                DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
                DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
                DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
                DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
            )
            ->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier', 'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
            ->orderBy('sensors.datetime', 'desc')
            ->get();


        $send = [
            'kandang' => $kandang,
            'data' => $data
        ];
        return view('pages/monitoringKandang', $send);
    }
    public function outlier()
    {
        $kandang = Kandang::where('kandang.id_user', Auth::user()->id)->get();
        $data = DB::table('sensors')
            ->where('kandang.id_user', '=', Auth::user()->id)
            ->where('kandang.id', '=', $kandang[0]->id)
            ->where('sensors.is_outlier', '=', true)
            ->leftJoin('kandang', function ($join) {
                $join->on('kandang.id', '=', 'sensors.id_kandang');
            })
            ->leftJoin('data_kandang', function ($join) {
                $join->on('data_kandang.id_kandang', '=', 'kandang.id')
                    ->on(DB::raw('DATE(data_kandang.date)'), '=', DB::raw('DATE(sensors.datetime)'));
            })
            ->leftJoin('data_kematian', function ($join) {
                $join->on('data_kematian.id_data_kandang', '=', 'data_kandang.id');
            })
            ->select(
                'sensors.*',
                'kandang.nama_kandang',
                'kandang.alamat_kandang',
                'data_kandang.hari_ke',
                DB::raw('COALESCE(data_kandang.pakan, 0) as pakan'),
                DB::raw('COALESCE(data_kandang.minum, 0) as minum'),
                DB::raw('COALESCE(data_kandang.bobot, 0) as bobot'),
                DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as jumlah_kematian')
            )
            ->groupBy('sensors.id', 'sensors.id_kandang', 'sensors.is_outlier', 'sensors.suhu', 'sensors.kelembapan', 'sensors.amonia', 'sensors.datetime', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'kandang.nama_kandang', 'kandang.alamat_kandang')
            ->orderBy('sensors.datetime', 'desc')
            ->get();


        $send = [
            'kandang' => $kandang,
            'data' => $data
        ];
        return view('pages/outlier', $send);
    }
    public function dataKandang()
    {
        $data =  Kandang::with('data_kandangs')->where('id_user', Auth::user()->id)->get();
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

        $data = DB::table('data_kandang')
            ->leftJoin('data_kematian', 'data_kematian.id_data_kandang', '=', 'data_kandang.id')
            ->select('data_kandang.*', DB::raw('COALESCE(SUM(data_kematian.jumlah_kematian), 0) as total_kematian'), DB::raw('GROUP_CONCAT(data_kematian.jam SEPARATOR ",") AS jam_kematian'))
            ->groupBy('data_kandang.id', 'data_kandang.id_kandang', 'data_kandang.hari_ke', 'data_kandang.pakan', 'data_kandang.minum', 'data_kandang.bobot', 'data_kandang.riwayat_populasi', 'data_kandang.date', 'data_kandang.classification', 'data_kandang.created_at', 'data_kandang.created_by', 'data_kandang.updated_at', 'data_kandang.updated_by')
            ->where('data_kandang.id_kandang', '=', $kandang[0]->id)
            ->orderBy('data_kandang.created_at', 'ASC')
            ->get();

        // dd($data);
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

        $data = Kandang::with(['notification' => function ($query) {
            $query->orderBy('waktu', 'desc');
        }])->where($checkUser, Auth::user()->id)->get();
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
