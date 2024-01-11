<?php

namespace App\Http\Controllers;

use App\Models\SAW;
use App\Models\Diklat;
use App\Models\Pegawai;
use App\Models\Kategori;
use App\Models\Sertifikasi;
use App\Models\KinerjaSatker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MengikutiSertifikasi;
use Illuminate\Support\Facades\Redis;
use App\Models\SAWPemeriksa;
use App\Models\PemeriksaKegiatan;


class DashboardController extends Controller
{
    //
    public function main(){
        return view('index');
    }
    public function sertifikasi(){

        $data = [
            'kategori' => Kategori::all(),
            // 'jabatan' => $jabatan

          ];
        return view('sertifikasi',$data);
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

        $jabatan = Pegawai::select('jabatan')->groupBy('jabatan')->get();
        $data = [
            'kategori' => Kategori::all(),
            'jabatan' => $jabatan

          ];
          // dd($data);
        return view('kompetensiSatker',$data);
    }
    public function kompetensiPegawai(){
        $jabatan = Pegawai::select('jabatan')->groupBy('jabatan')->get();
        // dd($jabatan);
        $data = [
            'kategori' => Kategori::all(),
            'jabatan' => $jabatan

          ];
          // dd($data);
        return view('kompetensiPegawai',$data);
    }
    public function kompetensiPegawaiDetail(Request $request){
        $id = request()->segment(2);
        $pegawai = Pegawai::find($id);

        $excludeList = ['Ahli', 'Muda','Pertama','/','Terampil','Madya'];
        $string = $pegawai->jabatan;

        $trimmedString = $this->excludeAndTrim($string, $excludeList);
        // echo $trimmedString; // Output: Pemeriksa
            // dd($trimmedString);

        $kategoriTerkait =  Kategori::where('jabatan', 'like', '%' .  $trimmedString . '%')->get();
        // dd($kategoriTerkait);
        $aggregatedData = collect(); // Initialize the collection
        foreach ($kategoriTerkait as $kategori) {
            $idKategori = $kategori->id;


            // Fetch SAW data associated with the current Kategori using the relationship
            $dataFromSAW = SAW::with('kategori') // Eager load the kategori relation
            ->where('id_pegawai', $id)
            ->where('id_kategori', $idKategori)
            ->get();

            // Append the fetched data to the aggregated collection
            $aggregatedData = $aggregatedData->concat($dataFromSAW);

            $averages = SAW::select('id_kategori', DB::raw('AVG(total) as avg_total'))
            ->groupBy('id_kategori')
            ->pluck('avg_total', 'id_kategori')
            ->toArray();
            // dd($idKategori);
            // dd($averages);
        // // Merge averages into $aggregatedData
            foreach ($aggregatedData as $data) {
                $idKategori = $data->kategori->id;
                $data->avg_total = $averages[$idKategori] ?? 0;
            }
            // dd($aggregatedData);
        }

        $data = [
            'kategori' => Kategori::all(),
            'pegawai' => $pegawai,
            'jabatanKeahlian' => $aggregatedData

        ];
        // dd($aggregatedData);
        // dd($data);

        return view('kompetensiPegawaiDetail',$data);
    }
    public function rekomendasiDiklat(){
        // dd($jabatan);
        $data = [
            // 'kategori' => Kategori::all(),
            'pegawai' => Pegawai::all()

          ];
          // dd($data);
        return view('rekomendasiDiklat',$data);
    }
    public function profilingPemeriksa(){
        return view('profilingPemeriksa');
    }

    public function profilingPemeriksaDetail(Request $request){
        $id = request()->segment(2);
        $pegawai = Pegawai::find($id);

        $excludeList = ['Ahli', 'Muda','Pertama','/','Terampil','Madya'];
        $string = $pegawai->jabatan;

        $trimmedString = $this->excludeAndTrim($string, $excludeList);
        // echo $trimmedString; // Output: Pemeriksa
            // dd($trimmedString);

        $kategoriTerkait =  Kategori::where('jabatan', 'like', '%' .  $trimmedString . '%')->get();
        // dd($kategoriTerkait);
        $aggregatedData = collect(); // Initialize the collection
        
        foreach ($kategoriTerkait as $kategori) {
            $idKategori = $kategori->id;

            // Fetch SAW data associated with the current Kategori using the relationship
            $dataFromSAW = SAWPemeriksa::with('kategori') // Eager load the kategori relation
            ->where('id_pegawai', $id)
            ->get();

            // Append the fetched data to the aggregated collection
            $aggregatedData = $aggregatedData->concat($dataFromSAW);
            // dd($aggregatedData,'agg');
            $averages = SAW::select('id_kategori', DB::raw('AVG(total) as avg_total'))
            ->groupBy('id_kategori')
            ->pluck('avg_total', 'id_kategori')
            ->toArray();
            // dd($idKategori);
            // dd($averages);
        // Merge averages into $aggregatedData
            foreach ($aggregatedData as $data) {
                $idKategori = $data->id_kategori;
                $data->avg_total = $averages[$idKategori] ?? 0;
            }
            // dd($data);

            // dd($dataFromSAW,'dataFromSAW');   

            $arr_ketegori_pegawai = array();
            $arr_poin_pegawai = array();
            
            foreach ($dataFromSAW as $d) {
                if (!in_array($d->id_kategori, $arr_ketegori_pegawai)) {
                    array_push($arr_ketegori_pegawai, $d->id_kategori );
                    array_push($arr_poin_pegawai, $d->poin_kompentensiPemeriksa );
                }
            }
        }

        $riwayat_pemeriksaan = PemeriksaKegiatan::select('lokasi_pemeriksaan', DB::raw('count(*) as total'))
                 ->groupBy('lokasi_pemeriksaan')
                 ->where('id_pegawai', $id)
                 ->get();

        $arr_riwayat_pemeriksaan = array();
        $arr_riwayat_pemeriksaan_jumlah = array();
        
        foreach ($riwayat_pemeriksaan as $d) {
            array_push($arr_riwayat_pemeriksaan, $d->lokasi_pemeriksaan );
            array_push($arr_riwayat_pemeriksaan_jumlah, $d->total );
         }

        $data = [
            'kategori' => Kategori::all(),
            'pegawai' => $pegawai,
            'jabatanKeahlian' => $aggregatedData,
            'ketegori_pegawai' => $arr_ketegori_pegawai,
            'poin_pegawai_ps' => $arr_poin_pegawai,
            'riwayat_pemeriksaan' => $arr_riwayat_pemeriksaan,
            'riwayat_pemeriksaan_jumlah' => $arr_riwayat_pemeriksaan_jumlah,

        ];
        // dd($aggregatedData);
        // dd($data);  

        return view('profilingPemeriksaDetail',$data);
    }


    public function pembentukanTim(){
        return view('pembentukanTim');
    }


    function excludeAndTrim($string, $excludeList) {
        $words = explode(' ', $string);
        $result = '';

        foreach ($words as $word) {
            if (!in_array($word, $excludeList)) {
                $result .= $word . ' ';
            }
        }

        // Remove trailing space
        $result = rtrim($result);

        return $result;
    }

    public function kinerjaSatker(Request $request){

        $satker = Satker::select('id')->groupBy('satuan_kerja')->get();
        $data = [
            'kategori' => Kategori::all(),
            'satker' => $satker

          ];
          // dd($data);
        return view('index',$data);


    }



}
