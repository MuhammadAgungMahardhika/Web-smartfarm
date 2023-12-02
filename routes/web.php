<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('pages/dashboard');
    })->name('dashboard');

    Route::get('/laporan', function () {
        return view('pages/laporan');
    })->name('laporan');

    Route::get('/forecast', function () {
        return view('pages/forecast');
    })->name('forecast');

    Route::get('/inputHarian', function () {
        return view('pages/inputHarian');
    })->name('inputHarian');

    Route::get('/klasifikasiMonitoring', function () {
        return view('pages/klasifikasi');
    })->name('klasifikasiMonitoring');

    Route::get('/monitoringKandang', function () {
        return view('pages/monitoringKandang');
    })->name('monitoringKandang');

    Route::get('/notifikasi', function () {
        return view('pages/notifikasi');
    })->name('notifikasi');

    Route::get('/hasilPanen', function () {
        return view('pages/hasilPanen');
    })->name('hasilPanen');


    Route::group(['prefix' => 'components', 'as' => 'components.'], function () {
        Route::get('/alert', function () {
            return view('admin.component.alert');
        })->name('alert');
        Route::get('/accordion', function () {
            return view('admin.component.accordion');
        })->name('accordion');
    });
});
