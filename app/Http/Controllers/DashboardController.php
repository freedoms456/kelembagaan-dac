<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MengikutiSertifikasi;

class DashboardController extends Controller
{
    //
    public function main(){
        return view('index');
    }
    public function sertifikasi(){

        return view('sertifikasi');
    }
    public function kediklatan(){
        $data = [
          'jumlahDiklat' => Diklat::distinct('id')->count('id'),
          'jumlahJenisDiklat' => Diklat::distinct('kategori')->count('kategori'),
          'totalJP' =>  Diklat::sum('jp')

        ];
        // dd($data);
        return view('kediklatan',$data);
    }
    public function kompetensiSatker(){
        return view('kompetensiSatker');
    }
    public function kompetensiPegawai(){
        return view('kompetensiPegawai');
    }
    public function kompetensiPegawaiDetail(){
        return view('kompetensiPegawaiDetail');
    }
    public function rekomendasiDiklat(){
        return view('rekomendasiDiklat');
    }
    public function profilingPemeriksa(){
        return view('profilingPemeriksa');
    }
    public function profilingPemeriksaDetail(){
        return view('profilingPemeriksaDetail');
    }
    public function pembentukanTim(){
        return view('pembentukanTim');
    }
}
