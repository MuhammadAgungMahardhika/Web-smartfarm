<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DataKandangController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\AuthController;

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
    Route::get('/kandang', [KandangController::class, 'index']);
    Route::get('/kandang/{id}', [KandangController::class, 'index']);
    Route::get('/kandang/user/{id}', [KandangController::class, 'getKandangByUserId']);
    Route::post('/kandang', [KandangController::class, 'store']);
    Route::put('/kandang/{id}', [KandangController::class, 'update']);
    Route::delete('/kandang/{id}', [KandangController::class, 'delete']);

    Route::get('/panen', [PanenController::class, 'index']);
    Route::get('/panen/{id}', [PanenController::class, 'index']);
    Route::get('/panen/kandang/{kandangId}', [PanenController::class, 'getPanenByKandangId']);
    Route::post('/panen', [PanenController::class, 'store']);
    Route::put('/panen/{id}', [PanenController::class, 'update']);
    Route::delete('/panen/{id}', [PanenController::class, 'delete']);

    Route::get('/sensor-amoniak', [SensorController::class, 'indexAmonia']);
    Route::get('/sensor-amoniak/{id}', [SensorController::class, 'indexAmonia']);
    Route::get('/sensor-suhu', [SensorController::class, 'indexSuhuKelembapan']);
    Route::post('/sensor-amoniak', [SensorController::class, 'storeAmoniak']);
    Route::post('/sensor-suhu', [SensorController::class, 'storeSuhuKelembapan']);

    Route::post('/data-kandang', [DataKandangController::class, 'store']);
    Route::post('/data-kandang/{id}', [DataKandangController::class, 'store']);
    Route::get('/data-kandang', [DataKandangController::class, 'index']);
    Route::put('/data-kandang/{idKandang}/{idKematian}', [DataKandangController::class, 'update']);
    Route::delete('/data-kandang/{idKematian}/{idKandang}', [DataKandangController::class, 'delete']);

    Route::get('/rekap-data', [RekapDataController::class, 'index']);
    Route::get('/rekap-data/{id}', [RekapDataController::class, 'index']);
    Route::get('/rekap-data/kandang/{kandangId}', [RekapDataController::class, 'getRekapDataByKandangId']);
    Route::post('/rekap-data', [RekapDataController::class, 'store']);
    Route::post('/rekap-data/{id}', [RekapDataController::class, 'store']);
    Route::put('/rekap-data/{id}', [RekapDataController::class, 'update']);
    Route::delete('/rekap-data/{id}', [RekapDataController::class, 'delete']);

    // Admin
    Route::get('/users', function () {
        return view('pages/users');
    })->middleware('role:1')->name('users');

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
