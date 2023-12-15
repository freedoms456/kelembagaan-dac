<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('welcome');
// });


Route::get('/dashboard', [DashboardController::class, 'main']);
Route::get('/sertifikasi', [DashboardController::class, 'sertifikasi']);
Route::get('/kediklatan', [DashboardController::class, 'kediklatan']);
Route::get('/kompetensi-satker', [DashboardController::class, 'kompetensiSatker']);
Route::get('/kompetensi-pegawai', [DashboardController::class, 'kompetensiPegawai']);
Route::get('/kompetensi-pegawaiDetail/{id}', [DashboardController::class, 'kompetensiPegawaiDetail']);
Route::get('/rekomendasi-diklat', [DashboardController::class, 'rekomendasiDiklat']);
Route::get('/profiling-pemeriksa', [DashboardController::class, 'profilingPemeriksa']);
Route::get('/profiling-pemeriksaDetail/{id}', [DashboardController::class, 'profilingPemeriksaDetail']);
Route::get('/pembentukan-tim', [DashboardController::class, 'pembentukanTim']);
