<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KandangController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\DataKandangController;
use App\Http\Controllers\RekapDataController;
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
Route::get('/register', function () {
    return redirect()->route('login');
});

// menerima sensor dari luar dan menambahkan ke database
Route::get('kandang/{idKandang}/suhu/{suhu}/kelembapan/{kelembapan}/amonia/{amonia}', [SensorController::class, 'storeSensorFromOutside']);
// data kandang kirim notifikasi ke peternak
Route::post('/data-kandang/send-peternak-notification', [DataKandangController::class, 'sendNotificationAlertToFarmer']);
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    //---------------------API------------------------------
    // user
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'index']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);
    // ambil user / peternak yang tidak memiliki kandang
    Route::get('/users/free', [UserController::class, 'userFree']);

    // role
    Route::get('/roles', [RolesController::class, 'index']);
    // kandang
    Route::get('/kandang', [KandangController::class, 'index']);
    Route::get('/kandang/{id}', [KandangController::class, 'index']);
    Route::get('/kandang/reset/{id}', [KandangController::class, 'setKandangStatusToInactive']);
    Route::get('/detailKandang/{id}', [KandangController::class, 'getDetailKandangById']);
    Route::get('/kandang/user/{id}', [KandangController::class, 'getKandangByUserId']);
    Route::get('/kandang/peternak/{id}', [KandangController::class, 'getKandangByPeternakId']);
    Route::post('/kandang', [KandangController::class, 'store']);
    Route::put('/kandang/{id}', [KandangController::class, 'update']);
    Route::delete('/kandang/{id}', [KandangController::class, 'delete']);

    // panen
    Route::get('/panen', [PanenController::class, 'index']);
    Route::get('/panen/{id}', [PanenController::class, 'index']);
    Route::post('/panen/date', [PanenController::class, 'getPanenByDate']);
    Route::get('/panen/kandang/{kandangId}', [PanenController::class, 'getPanenByKandangId']);
    Route::post('/panen', [PanenController::class, 'store']);
    Route::put('/panen/{id}', [PanenController::class, 'update']);
    Route::delete('/panen/{id}', [PanenController::class, 'delete']);


    // mendapatkan sensor dari database
    Route::get('/sensor-suhu-kelembapan-amoniak/kandang/{idKandang}', [SensorController::class, 'getSensor']);
    Route::get('/sensors-suhu-kelembapan-amoniak/kandang/{idKandang}', [SensorController::class, 'getSensors']);
    Route::get('/sensors/kandang/{idKandang}', [SensorController::class, 'getSensorByKandangId']);
    Route::get('/sensors/{option}/{idKandang}/{date}', [SensorController::class, 'getSensorHistoryByDate']);
    // filter sensor
    Route::post('/sensors/date', [SensorController::class, 'getSensorByDate']);
    Route::post('/sensors/day', [SensorController::class, 'getSensorByDay']);
    Route::post('/sensors/classification', [SensorController::class, 'getSensorByClassification']);


    // data kandang
    Route::get('/data-kandang', [DataKandangController::class, 'index']);
    Route::get('/data-kandang/{id}', [DataKandangController::class, 'index']);
    Route::get('/data-kandang/check/{date}', [DataKandangController::class, 'checkDataKandangDate']);
    Route::get('/data-kandang/current/kandang/{idKandang}', [DataKandangController::class, 'getCurrentDataKandangByIdKandang']);
    Route::get('/jumlah-kematian/data-kandang/{id}', [DataKandangController::class, 'getJumlahKematianByDataKandangId']);
    Route::get('/data-kandang/kandang/{idKandang}', [DataKandangController::class, 'getDataKandangByIdKandang']);
    Route::get('/data-kandang/detail/kandang/{idKandang}', [DataKandangController::class, 'getDetailKandangByIdKandang']);
    Route::post('/data-kandang', [DataKandangController::class, 'store']);

    Route::put('/data-kandang/{id}', [DataKandangController::class, 'update']);
    Route::delete('/data-kandang/{id}', [DataKandangController::class, 'delete']);
    // filter data kandang
    Route::post('/data-kandang/date', [DataKandangController::class, 'getDataKandangByDate']);
    Route::post('/data-kandang/classification', [DataKandangController::class, 'getDataKandangByClassification']);
    Route::post('/data-kandang/day', [DataKandangController::class, 'getDataKandangByDay']);



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
        Route::get('/cageList', [PageController::class, "kandang"])->name('cageList');
    });

    // check apakah pemilik atau peternak memiliki kandang
    Route::middleware(['checkKandang'])->group(function () {

        //----------------------Pemilik--------------------------------------//
        // Check role = 2, apakah pemilik yang login
        Route::middleware(['role:2'])->group(function () {
            // Halaman dashboard
            Route::get('/dashboard', [PageController::class, "dashboard"])->name('dashboard');
            // Halaman outlier 
            Route::group(['prefix' => 'outlier', 'as' => 'outlier.'], function () {
                Route::get('/temperature', [PageController::class, "temperatureOutlier"])->name('temperature');
                Route::get('/humidity', [PageController::class, "humidityOutlier"])->name('humidity');
                Route::get('/amonia', [PageController::class, "amoniaOutlier"])->name('amonia');
            });
            // Halaman monitoring kandang
            Route::get('/cageMonitoring', [PageController::class, "monitoringKandang"])->name('cageMonitoring');
            // Halaman monitoring kandang visualisasi
            Route::get('/cageVisualization', [PageController::class, "cageVisualization"])->name('cageVisualization');
            // Halaman Outlier
            Route::get('/outlierData', [PageController::class, "outlier"])->name('outlierData');
            // Halaman data kandang
            Route::get('/cageData', [PageController::class, "dataKandang"])->name('cageData');
        });
        //---------------------Peternak--------------------------------------//
        // Check role = 3, apakah peternak yang login
        Route::middleware(['role:3'])->group(function () {
            // Halaman input harian
            Route::get('/dailyInput', [PageController::class, "inputHarian"])->name('dailyInput');
        });


        //-----------------------Pemilik & Peternak---------------------------//
        // Check role = 2 & 3, apakah pemilik & peternak yang login
        Route::middleware(['role:2,3'])->group(function () {
            // halaman notifikasi
            Route::get('/notification', [PageController::class, "notifikasi"])->name('notification');
            // Halaman klasifikasi
            Route::get('/klasifikasiMonitoring', [PageController::class, "klasifikasi"])->name('klasifikasiMonitoring');
            // Halaman Hasil Panen
            Route::get('/harvestData', [PageController::class, "hasilPanen"])->name('harvestData');
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
