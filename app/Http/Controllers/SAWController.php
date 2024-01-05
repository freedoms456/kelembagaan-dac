<?php

namespace App\Http\Controllers;

use App\Models\SAW;
use App\Models\Diklat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\MengikutiDiklat;
use App\Models\MengikutiKegiatan;
use Illuminate\Support\Facades\DB;
use App\Models\MengikutiSertifikasi;
use Yajra\DataTables\Facades\DataTables;


class SAWController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'kategori' => Kategori::all(),

          ];
          // dd($data);
        return view('calculateSAW',$data);
    }

   public function calculateSAW(Request $request){

    $kategoris =  $request->input('kategori');
    list($kategori, $unsur) = explode('_', $kategoris);
    // $data = Kategori::all();
    // return $unsur;
    // Call Data
    $dataDiklat = MengikutiDiklat::join('pegawais', 'mengikuti_diklats.id_pegawai', '=', 'pegawais.id')
        ->join('diklats', 'mengikuti_diklats.id_diklat', '=', 'diklats.id')
        ->join('diklat_kategoris', 'diklats.id', '=', 'diklat_kategoris.id_diklat')
        ->select('pegawais.id', DB::raw('SUM(diklats.jp) as poin_diklat'))
        ->where('diklat_kategoris.id_kategori', $kategori) // Assuming 'id' is an integer value, no quotes around the value
        ->groupBy('pegawais.id')
        ->get()->toArray();

    $dataSertifikasi = MengikutiSertifikasi::join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id')
        ->join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
        ->join('sertifikasi_kategoris', 'sertifikasis.id', '=', 'sertifikasi_kategoris.id_sertifikasi')
        ->select('pegawais.id', DB::raw('COUNT(sertifikasis.id) as poin_sertifikasi'))
        ->where('sertifikasi_kategoris.id_kategori', $kategori) // Assuming 'id' is an integer value, no quotes around the value
        ->groupBy('pegawais.id')
        ->get()->toArray();


        $dataKegiatan = MengikutiKegiatan::join('pegawais', 'mengikuti_kegiatans.id_pegawai', '=', 'pegawais.id')
        ->join('kegiatans', 'mengikuti_kegiatans.id_kegiatan', '=', 'kegiatans.id')
        ->select('pegawais.id', DB::raw('SUM(kegiatans.bobot)  / COUNT(DISTINCT mengikuti_kegiatans.tahun) as poin_kinerja'))
        ->where('kegiatans.unsur', "Komunikasi") // Assuming 'id' is an integer value, no quotes around the value
        ->groupBy('pegawais.id')
        ->get()->toArray();

        $dataSKP = MengikutiKegiatan::join('pegawais', 'mengikuti_kegiatans.id_pegawai', '=', 'pegawais.id')
        ->join('kegiatans', 'mengikuti_kegiatans.id_kegiatan', '=', 'kegiatans.id')
        ->select('pegawais.id', DB::raw('AVG(mengikuti_kegiatans.nilai_skp) as poin_skp'))
        ->where('kegiatans.unsur', "Komunikasi") // Assuming 'id' is an integer value, no quotes around the value
        ->groupBy('pegawais.id')
        ->get()->toArray();

        $mergedData = [];

        $mergedData = collect($dataDiklat)
        ->merge($dataSertifikasi)
        ->merge($dataKegiatan)
        ->merge($dataSKP)
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
                'poin_diklat' => $item['poin_diklat'] ?? 1,
                'poin_sertifikasi' => $item['poin_sertifikasi'] ?? 0.0001,
                'poin_kinerja' => $item['poin_kinerja'] ?? 0.01,
                'poin_skp' => $item['poin_skp'] ?? 1,
            ];
        }



    $features = ['poin_diklat', 'poin_sertifikasi', 'poin_kinerja', 'poin_skp'];

    // Calculate min and max for each feature
    $minMaxValues = [];
    foreach ($features as $feature) {
        $minMaxValues[$feature]['min'] = min(array_column($filledData, $feature));
        $minMaxValues[$feature]['max'] = max(array_column($filledData, $feature));
    }

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

    //// NON AHP
    // $criteria = [
    //     'poin_diklat' => 25,
    //     'poin_skp' => 25,
    //     'poin_kinerja' => 30,
    //     'poin_sertifikasi' => 20,
    // ];

    // AHP
    $comparisonMatrix = [
        [1, 1/5, 3, 5],   // Comparison of poin_diklat with other criteria
        [5, 1, 3, 7],     // Comparison of poin_sertifikasi with other criteria
        [1/3, 1/3, 1, 2], // Comparison of poin_kinerja with other criteria
        [1/5, 1/7, 1/2, 1], // Comparison of poin_skp with other criteria
    ];

    // Get the number of criteria
    $numCriteria = count($comparisonMatrix);

    // Step 1: Normalize the matrix
    $normalizedMatrix = [];
    for ($i = 0; $i < $numCriteria; $i++) {
        for ($j = 0; $j < $numCriteria; $j++) {
            $normalizedMatrix[$i][$j] = $comparisonMatrix[$i][$j] / array_sum($comparisonMatrix[$j]);
        }
    }

    // Step 2: Calculate the weight vector
    $weightVector = [];
    for ($i = 0; $i < $numCriteria; $i++) {
        $sum = 0;
        for ($j = 0; $j < $numCriteria; $j++) {
            $sum += $normalizedMatrix[$i][$j];
        }
        $weightVector[$i] = $sum / $numCriteria;
    }

    // Step 3: Normalize the weight vector to sum up to 1
    $totalWeights = array_sum($weightVector);
    $normalizedWeights = array_map(function ($weight) use ($totalWeights) {
        return $weight / $totalWeights;
    }, $weightVector);
    // Apply criteria weights to determine the final criteria
    $criteria = [
        'poin_diklat' => $normalizedWeights[0]*100,
        'poin_sertifikasi' => $normalizedWeights[1]*100,
        'poin_kinerja' => $normalizedWeights[2]*100,
        'poin_skp' => $normalizedWeights[3]*100,
    ];
    // END AHP
    // SAW CALCULATE
    foreach ($normalizedData as $item) {
        $scoreDiklat = $item['poin_diklat'] * $criteria['poin_diklat'];
        $scoreSertifikasi = $item['poin_sertifikasi'] * $criteria['poin_sertifikasi'];
        $scoreKinerja = $item['poin_kinerja'] * $criteria['poin_kinerja'];
        $scoreSKP = $item['poin_skp'] * $criteria['poin_skp'];

        $totalScore = $scoreDiklat + $scoreSertifikasi + $scoreKinerja + $scoreSKP;

        $weightedScores[] = [
            'id_pegawai' => $item['id'],
            'diklat' => $scoreDiklat,
            'sertifikasi' => $scoreSertifikasi,
            'kinerja' => $scoreKinerja,
            'skp' => $scoreSKP,
            'total' => $totalScore,
            'id_kategori' => $kategori
        ];
    }

    // Sort the scores in descending order based on the calculated scores
    usort($weightedScores, function ($a, $b) {
        return $b['total'] <=> $a['total'];
    });

    SAW::where('id_kategori', $kategori)->delete();

    // Insert new records
    SAW::insert($weightedScores);

    return $weightedScores;

   }


   function normalize($value, $min, $max)
    {
        return ($value/$max);
        // return ($value - $min) / ($max - $min);
    }

    public static function getTableList(Request $request){
        $kategoris =  $request->input('kategori');
        list($kategori, $unsur) = explode('_', $kategoris);


               $data = SAW::with('Pegawai')->where('id_kategori',$kategori)->get();


            return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
            {
                $actionBtn = "" ;
                return $actionBtn;

            })->rawColumns(['action'])->make(true);




    }
}
