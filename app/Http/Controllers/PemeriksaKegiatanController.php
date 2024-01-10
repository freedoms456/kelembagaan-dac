<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemeriksaan;
use App\Models\SAW;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Models\PemeriksaKegiatan;
use App\Models\SAWPemeriksa;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PemeriksaKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function getTableHistori(Request $request){
        $jabatan =  $request->input('jabatan');



        $data = PemeriksaKegiatan::with('pegawai')->select('id_pegawai')
        ->selectRaw('
            SUM(CASE WHEN jenis_pemeriksaan = "LK" THEN 1 ELSE 0 END) as count_LK,
            SUM(CASE WHEN jenis_pemeriksaan = "Kinerja" THEN 1 ELSE 0 END) as count_Kinerja,
            SUM(CASE WHEN jenis_pemeriksaan = "PDTT" THEN 1 ELSE 0 END) as count_PDTT,
            COUNT(*) as count_jenis_pemeriksaan
        ')
        ->groupBy('id_pegawai')
        ->orderBy('id_pegawai')
        ->get();


            return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
            {
                $actionBtn = '<a href="/profiling-pemeriksaDetail/'.$row->pegawai->id.'"><span class="label label-success">view</span></a>' ;
                return $actionBtn;

            })->rawColumns(['action'])->make(true);




    }
    function normalize($value, $min, $max)
    {
        return ($value/$max);
        // return ($value - $min) / ($max - $min);
    }

    public function calculateSAWPemeriksa(Request $request){
        // dd($request->input('kategori'));
        $kategori =  $request->input('kategori');
        // list($kategori, $unsur) = explode('_', $kategoris);
        // $data = Kategori::all();
        // return $unsur;
        // Call Data

        // $kategori = "Akuntansi";
        $kategoriBidang = KategoriPemeriksaan::where('bidang', $kategori)->pluck('id_kategori');


        $dataSAW = SAW::join('pegawais', 'saws.id_pegawai', '=', 'pegawais.id')
                ->select('pegawais.id', DB::raw('avg(total) as poin_saw'))
                ->whereIn('saws.id_kategori', $kategoriBidang)
                ->groupBy('pegawais.id')
                ->get()->toArray();
                // dd($dataSAW);
        $dataJurusan = Pegawai::
            select('id','name', DB::raw('COUNT(id) as poin_jurusan'))
            ->where('jurusan_kategori', $kategori) // Assuming 'id' is an integer value, no quotes around the value
            ->groupBy('pegawais.id','name')
            ->get()->toArray();
        // dd($dataJurusan);
            $mergedData = [];

            $mergedData = collect($dataJurusan)
            ->merge($dataSAW)
            ->groupBy('id')
            ->map(function ($items) {
                return $items->reduce(function ($result, $item) {
                    return array_merge($result, (array) $item);
                }, []);
            })
            ->values()
            ->all();
        // Iterate through the merged data and fill missing 'diklat' or 'sertifikasi'
            $filledData = [];
            foreach ($mergedData as $item) {
                $filledData[] = [
                    'id' => $item['id'] ?? '',
                    'poin_saw' => $item['poin_saw'] ?? 1,
                    'poin_jurusan' => $item['poin_jurusan'] ?? 0.1,

                ];
            }




        $features = ['poin_saw', 'poin_jurusan'];

        // Calculate min and max for each feature
        $minMaxValues = [];
        foreach ($features as $feature) {
            $minMaxValues[$feature]['min'] = min(array_column($filledData, $feature));
            $minMaxValues[$feature]['max'] = max(array_column($filledData, $feature));
        }
        // dd($minMaxValues);
        // return $minMaxValues;
        // Normalize each feature using min-max normalization
        $normalizedData = [];
        foreach ($filledData as $item) {
            $normalizedItem = ['id' => $item['id']]; // Keep the name

            foreach ($features as $feature) {
                $value = $item[$feature];
                $min = $minMaxValues[$feature]['min'];
                $max = $minMaxValues[$feature]['max'];

                // Perform min-max normalization
                $normalizedItem[$feature] = $this->normalize($value, $min, $max);
            }

            // return $normalizedItem;
            $normalizedData[] = $normalizedItem;
        }

        // NON AHP
        // $criteria = [
        //     'poin_saw' => 80,
        //     'poin_jurusan' => 20,
        // ];

        // // AHP
        $comparisonMatrix = [
            [1,7 ],    // Comparison of poin_diklat with other criteria
            [1/7, 1],      // Comparison of poin_sertifikasi with other criteria
        ];

        $numCriteria = count($comparisonMatrix);

        // Step 1: Normalize the matrix
        $normalizedMatrix = [];
        for ($j = 0; $j < $numCriteria; $j++) {
            $columnSum = array_sum(array_column($comparisonMatrix, $j));
            for ($i = 0; $i < $numCriteria; $i++) {
                $normalizedMatrix[$i][$j] = $comparisonMatrix[$i][$j] / $columnSum;
            }
        }

        // Step 2: Calculate the weight vector
        $weightVector = [];
        for ($i = 0; $i < $numCriteria; $i++) {
            $weightVector[$i] = array_sum($normalizedMatrix[$i]) / $numCriteria;
        }

        // Step 3: Normalize the weight vector to sum up to 1
        $totalWeights = array_sum($weightVector);
        $normalizedWeights = array_map(function ($weight) use ($totalWeights) {
            return $weight / $totalWeights;
        }, $weightVector);
        // Apply criteria weights to determine the final criteria
        $criteria = [
            'poin_saw' => $normalizedWeights[0]*100,
            'poin_jurusan' => $normalizedWeights[1]*100,
        ];

        // END AHP
        // SAW CALCULATE
        foreach ($normalizedData as $item) {
            $scoreDiklat = $item['poin_saw'] * $criteria['poin_saw'];
            $scoreSertifikasi = $item['poin_jurusan'] * $criteria['poin_jurusan'];

            $totalScore = $scoreDiklat + $scoreSertifikasi;

            $weightedScores[] = [
                'id_pegawai' => $item['id'],
                'poin_saw' => $scoreDiklat,
                'poin_jurusan' => $scoreSertifikasi,
                'poin_kompentensiPemeriksa' => $totalScore,
                'id_kategori' => $kategori
            ];
        }
        // Sort the scores in descending order based on the calculated scores
        usort($weightedScores, function ($a, $b) {
            return $b['poin_kompentensiPemeriksa'] <=> $a['poin_kompentensiPemeriksa'];
        });

        SAWPemeriksa::where('id_kategori', $kategori)->delete();

        // Insert new records
        SAWPemeriksa::insert($weightedScores);

        return $weightedScores;

    }


    public static function SAWPemeriksaTable(Request $request){
        $kategori =  $request->input('kategori');
        $kategori = "Akuntansi";
        // dd($kategori);
        $jabatanValue = "Kaltara";

        // $data = SAWPemeriksa::with('pegawai')->where('id_kategori',$kategori)
        // ->whereHas('pegawai', function ($query) use ($jabatanValue) {
        //     $query->where('jabatan', $jabatanValue); // Replace $jabatanValue with the desired jabatan value
        // })
        // ->get();

        $data = SAWPemeriksa::with('pegawai')->where('id_kategori',$kategori)->get();


            return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
            {
                $actionBtn = '<a href="/profiling-pemeriksaDetail/'.$row->pegawai->id.'"><span class="label label-success">view</span></a>' ;
                return $actionBtn;

            })->rawColumns(['action'])->make(true);




    }

}
