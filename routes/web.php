<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DataKandangController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing-page');
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    // user
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);

    // role
    Route::get('/roles', [RolesController::class, 'index']);



    // kandang
    Route::get('/kandang', [KandangController::class, 'index']);
    Route::get('/kandang/{id}', [KandangController::class, 'index']);
    Route::get('/detailKandang/{id}', [KandangController::class, 'getDetailKandangById']);
    Route::get('/kandang/user/{id}', [KandangController::class, 'getKandangByUserId']);
    Route::get('/kandang/peternak/{id}', [KandangController::class, 'getKandangByPeternakId']);
    Route::post('/kandang', [KandangController::class, 'store']);
    Route::put('/kandang/{id}', [KandangController::class, 'update']);
    Route::delete('/kandang/{id}', [KandangController::class, 'delete']);

    // panen
    Route::get('/panen', [PanenController::class, 'index']);
    Route::get('/panen/{id}', [PanenController::class, 'index']);
    Route::get('/panen/kandang/{kandangId}', [PanenController::class, 'getPanenByKandangId']);
    Route::post('/panen', [PanenController::class, 'store']);
    Route::put('/panen/{id}', [PanenController::class, 'update']);
    Route::delete('/panen/{id}', [PanenController::class, 'delete']);

    // sensor amoniak dan suhu
    Route::get('/sensor-amoniak', [SensorController::class, 'indexAmonia']);
    Route::get('/sensor-amoniak/{id}', [SensorController::class, 'indexAmonia']);
    Route::get('/sensor-suhu', [SensorController::class, 'indexSuhuKelembapan']);
    Route::post('/sensor-amoniak', [SensorController::class, 'storeAmoniak']);
    Route::post('/sensor-suhu', [SensorController::class, 'storeSuhuKelembapan']);

    // menerima sensor dari luar
    Route::get('/sensor/suhu/{suhu}/kelembapan/{kelembapan}/amonia/{amonia}', [SensorController::class, 'sensorLuar']);

    // data kandang

    Route::get('/data-kandang', [DataKandangController::class, 'index']);
    Route::get('/data-kandang/{id}', [DataKandangController::class, 'index']);
    Route::get('/jumlah-kematian/data-kandang/{id}', [DataKandangController::class, 'getJumlahKematianByDataKandangId']);
    Route::get('/data-kandang/kandang/{idKandang}', [DataKandangController::class, 'getDataKandangByIdKandang']);
    Route::post('/data-kandang', [DataKandangController::class, 'store']);
    Route::put('/data-kandang/{id}', [DataKandangController::class, 'update']);
    Route::delete('/data-kandang/{id}', [DataKandangController::class, 'delete']);


    // rekap data
    Route::get('/rekap-data', [RekapDataController::class, 'index']);
    Route::get('/rekap-data/{id}', [RekapDataController::class, 'index']);
    Route::get('/rekap-data/kandang/{kandangId}', [RekapDataController::class, 'getRekapDataByKandangId']);
    Route::post('/rekap-data', [RekapDataController::class, 'store']);
    Route::put('/rekap-data/{id}', [RekapDataController::class, 'update']);
    Route::delete('/rekap-data/{id}', [RekapDataController::class, 'delete']);

    // notifikasi
    Route::get('/notification', [NotificationController::class, 'index']);
    Route::get('/notification/{id}', [NotificationController::class, 'index']);
    Route::get('/notification/kandang/{kandangId}', [NotificationController::class, 'getNotificationByKandangId']);
    Route::post('/notification', [NotificationController::class, 'store']);
    Route::patch('/notification/{id}', [NotificationController::class, 'update']);
    Route::delete('/notification/{id}', [NotificationController::class, 'delete']);



    // Semua
    Route::get('/daftarMenu', function () {
        return view('pages/daftarMenu');
    })->middleware('role:1,2,3')->name('daftarMenu');
    // Admin
    Route::get('/userList', function () {
        return view('pages/users');
    })->middleware('role:1')->name('userList');

    // Pemilik
    Route::get('/dashboard', function () {
        return view('pages/dashboard');
    })->middleware('role:2')->name('dashboard');

    Route::get('/dataKandang', function () {
        return view('pages/dataKandang');
    })->middleware('role:2')->name('dataKandang');
    Route::get('/forecast', function () {
        return view('pages/forecast');
    })->middleware('role:2')->name('forecast');

    Route::get('/hasilPanen', function () {
        return view('pages/hasilPanen');
    })->middleware('role:2')->name('hasilPanen');

    // Peternak
    Route::get('/inputHarian', function () {
        return view('pages/inputHarian');
    })->middleware('role:2,3')->name('inputHarian');

    // Pemilik & Peternak
    Route::get('/notifikasi', function () {
        return view('pages/notifikasi');
    })->middleware(['role:2,3'])->name('notifikasi');
    Route::get('/klasifikasiMonitoring', function () {
        return view('pages/klasifikasi');
    })->middleware('role:2,3')->name('klasifikasiMonitoring');

    // error 
    Route::get('/error-403', function () {
        return view('error/error-403');
    });

    Route::group(['prefix' => 'components', 'as' => 'components.'], function () {
        Route::get('/alert', function () {
            return view('admin.component.alert');
        })->name('alert');
        Route::get('/accordion', function () {
            return view('admin.component.accordion');
        })->name('accordion');
    });
});
