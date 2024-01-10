<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiklatController;
use App\Http\Controllers\PemeriksaKegiatanController;
use App\Http\Controllers\SAWController;
use App\Http\Controllers\SertifikasiController;
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

Route::get('/sertifikasi/getSertifikasiBasedOnName', [SertifikasiController::class, 'getSertifikasiData']);
Route::get('/sertifikasi/getSertifikasiByJenis', [SertifikasiController::class, 'getSertifikasiByJenis']);
Route::post('/sertifikasi/getlist/get-datatable', [SertifikasiController::class, 'getTableList'])->name('sertifikasi.list');
Route::post('/sertifikasi/getlist/get-datatable2', [SertifikasiController::class, 'getTableMilikList'])->name('sertifikasiMilik.list');

Route::get('/kediklatan/getPieJabatan', [DiklatController::class, 'getDiklatJabatan']);
Route::post('/kediklatan/getlist/get-datatable', [DiklatController::class, 'getTableList'])->name('kediklatan.list');

Route::get('/perhitunganSAW', [SAWController::class, 'index']);
Route::post('/perhitunganSAW/calculate', [SAWController::class, 'calculateSAW']);
Route::post('/perhitunganKmeans/calculate', [SAWController::class, 'Kmeans']);
Route::post('/perhitunganSAWS/get-datatable', [SAWController::class, 'getTableList'])->name('saw.list');
Route::post('/perhitunganSAWS/get-datatablePerwakilan', [SAWController::class, 'getTableListPerwakilan'])->name('sawPerwakilan.list');



Route::post('/rekomendasidiklat/get-datatable', [SAWController::class, 'getTableListDiklat'])->name('rekomendasiDiklat.list');
Route::post('/rekomendasidiklat/getPegawai', [SAWController::class, 'getPegawaiData']);



Route::get('/pemeriksaSAW', [PemeriksaKegiatanController::class, 'index']);
Route::post('/pemeriksaSAW/calculate', [PemeriksaKegiatanController::class, 'calculateSAWPemeriksa']);
Route::post('/pemeriksaSAW/tableresult', [PemeriksaKegiatanController::class, 'SAWPemeriksaTable']);



Route::post('/pemeriksaKegiatan/get-datatableHistori', [PemeriksaKegiatanController::class, 'getTableHistori']);
Route::post('/bentuktim/create/', [PemeriksaKegiatanController::class, 'bentukTim']);

