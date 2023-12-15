<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('kediklatan');
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
