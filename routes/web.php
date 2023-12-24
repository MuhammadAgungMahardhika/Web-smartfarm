<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DataKandangController;
use App\Http\Controllers\RekapDataController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
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

// menerima sensor dari luar dan menambahkan ke database
Route::get('kandang/{idKandang}/suhu/{suhu}/kelembapan/{kelembapan}/amonia/{amonia}', [SensorController::class, 'storeSensorFromOutside']);
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    //---------------------API------------------------------
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


    // mendapatkan sensor dari database
    Route::get('/sensor-suhu-kelembapan-amoniak/kandang/{idKandang}', [SensorController::class, 'getSensor']);
    Route::get('/sensors/kandang/{idKandang}', [SensorController::class, 'getSensorByKandangId']);



    // data kandang
    Route::get('/data-kandang', [DataKandangController::class, 'index']);
    Route::get('/data-kandang/{id}', [DataKandangController::class, 'index']);
    Route::get('/jumlah-kematian/data-kandang/{id}', [DataKandangController::class, 'getJumlahKematianByDataKandangId']);
    Route::get('/data-kandang/kandang/{idKandang}', [DataKandangController::class, 'getDataKandangByIdKandang']);
    Route::get('/data-kandang/detail/kandang/{idKandang}', [DataKandangController::class, 'getDetailKandangByIdKandang']);
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

    //----------------------All Role -----------------------------------//
    Route::get('/menuList', function () {
        return view('pages/daftarMenu');
    })->middleware('role:1,2,3')->name('menuList');
    //----------------------Admin---------------------------------------//
    // Check role = 1, apakah admin yang login
    Route::middleware(['role:1'])->group(function () {
        Route::get('/userList', [PageController::class, "user"])->name('userList');
    });

    // check apakah pemilik atau peternak memiliki kandang
    Route::middleware(['checkKandang'])->group(function () {

        //----------------------Pemilik--------------------------------------//
        // Check role = 2, apakah pemilik yang login
        Route::middleware(['role:2'])->group(function () {
            // Halaman dashboard
            Route::get('/dashboard', [PageController::class, "dashboard"])->name('dashboard');
            // Halaman monitoring kandang
            Route::get('/monitoringKandang', [PageController::class, "monitoringKandang"])->name('monitoringKandang');
            // Halaman data kandang
            Route::get('/dataKandang', [PageController::class, "dataKandang"])->name('dataKandang');
            // Halaman forecast
            Route::get('/forecast', [PageController::class, "forecast"])->name('forecast');
            // Halaman Hasil Panen
            Route::get('/broilerHarvest', [PageController::class, "hasilPanen"])->name('broilerHarvest');
        });
        //---------------------Peternak--------------------------------------//
        // Check role = 3, apakah peternak yang login
        Route::middleware(['role:3'])->group(function () {
            Route::get('/dailyInput', [PageController::class, "inputHarian"])->name('dailyInput');
        });


        //-----------------------Pemilik & Peternak---------------------------//
        // Check role = 2 & 3, apakah pemilik & peternak yang login
        Route::middleware(['role:2,3'])->group(function () {
            // halaman notifikasi
            Route::get('/notification', [PageController::class, "notifikasi"])->name('notification');
            // Halaman klasifikasi
            Route::get('/klasifikasiMonitoring', [PageController::class, "klasifikasi"])->name('klasifikasiMonitoring');
        });
    });

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
