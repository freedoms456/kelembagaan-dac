<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\SAW;
use App\Models\Diklat;
use App\Models\DiklatKategori;
use GuzzleHttp\Client;
use App\Models\Pegawai;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Phpml\Clustering\KMeans;
use App\Models\MengikutiDiklat;
use App\Models\MengikutiKegiatan;
use Illuminate\Support\Facades\DB;
use App\Models\MengikutiSertifikasi;
use Phpml\Clustering\KMeansPlusPlus;
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
    $allDiklatData = Diklat::all();
    // dd($allDiklatData);
    $results = [];
    foreach ($allDiklatData as $diklat) {
        $similarity = cosineSimilarity($unsur, $diklat->detail);

        // Store the Diklat ID and its similarity
        if ($similarity != 0) {
            $results[] = [
                'id_diklat' => $diklat->id,
                'similarity' => $similarity,
            ];
        }
    }

    usort($results, function ($a, $b) {
        return $b['similarity'] <=> $a['similarity'];
    });

    $dataDiklat = MengikutiDiklat::join('pegawais', 'mengikuti_diklats.id_pegawai', '=', 'pegawais.id')
    ->join('diklats', 'mengikuti_diklats.id_diklat', '=', 'diklats.id')
    ->join('diklat_kategoris', 'diklats.id', '=', 'diklat_kategoris.id_diklat')
    ->select('pegawais.id', DB::raw('SUM(diklats.jp) as poin_diklat'))
    ->groupBy('pegawais.id');

    // Get the array of 'id_diklat' values from your previous similarity results
    $idDiklatValues = array_column($results, 'id_diklat');

    // Add a condition to the query to filter based on the 'id_diklat' values obtained from the previous similarity results
    if (!empty($idDiklatValues)) {
        $dataDiklat->whereIn('diklats.id', $idDiklatValues);
    } else {
        $dataDiklat->where('diklat_kategoris.id_kategori', $kategori);
    }

    // Fetch the results
    $result = $dataDiklat->get()->toArray();
    // dd($results);

    // $dataDiklat = MengikutiDiklat::join('pegawais', 'mengikuti_diklats.id_pegawai', '=', 'pegawais.id')
    //     ->join('diklats', 'mengikuti_diklats.id_diklat', '=', 'diklats.id')
    //     ->join('diklat_kategoris', 'diklats.id', '=', 'diklat_kategoris.id_diklat')
    //     ->select('pegawais.id', DB::raw('SUM(diklats.jp) as poin_diklat'))
    //     ->where('diklat_kategoris.id_kategori', $kategori) // Assuming 'id' is an integer value, no quotes around the value
    //     ->groupBy('pegawais.id')
    //     ->get()->toArray();

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
        ->where('kegiatans.unsur', $unsur) // Assuming 'id' is an integer value, no quotes around the value
        ->groupBy('pegawais.id')
        ->get()->toArray();

        $dataSKP = MengikutiKegiatan::join('pegawais', 'mengikuti_kegiatans.id_pegawai', '=', 'pegawais.id')
        ->join('kegiatans', 'mengikuti_kegiatans.id_kegiatan', '=', 'kegiatans.id')
        ->select('pegawais.id', DB::raw('AVG(mengikuti_kegiatans.nilai_skp) as poin_skp'))
        ->where('kegiatans.unsur', $unsur) // Assuming 'id' is an integer value, no quotes around the value
        ->groupBy('pegawais.id')
        ->get()->toArray();

        $mergedData = [];

        $mergedData = collect($result)
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

    // NON AHP
    // $criteria = [
    //     'poin_diklat' => 25,
    //     'poin_skp' => 25,
    //     'poin_kinerja' => 30,
    //     'poin_sertifikasi' => 20,
    // ];

    // AHP
    $comparisonMatrix = [
        [1, 1/2, 2, 2],    // Comparison of poin_diklat with other criteria
        [2, 1, 2, 2],      // Comparison of poin_sertifikasi with other criteria
        [1, 1/2, 1, 2], // Comparison of poin_kinerja with other criteria
        [1/2, 1/2, 1/2, 1] // Comparison of poin_skp with other criteria
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
        $perwakilan =  $request->input('perwakilan');
        $jabatan =  $request->input('jabatan');

        list($kategori, $unsur) = explode('_', $kategoris);

        if($perwakilan){
            // Untuk Filter Pencarian di Kompetensi
            if($perwakilan == "all"){
                if($jabatan == "all"){
                    $data = SAW::with('Pegawai')->where('id_kategori',$kategori)->get();
               } else {
                   $data = SAW::with('Pegawai')
                   ->where('id_kategori', $kategori)
                   ->whereHas('Pegawai', function ($query) use ($jabatan) {
                       $query->where('jabatan', $jabatan);
                   })
                   ->get();
               }
            }
            else {

                if($jabatan == "all"){
                    $data = SAW::with('Pegawai')
                    ->where('id_kategori', $kategori)
                    ->whereHas('Pegawai', function ($query) use ($perwakilan) {
                        $query->where('satuan_kerja', $perwakilan);
                    })
                    ->get();
                 } else {
                    $data = SAW::with('Pegawai')
                    ->where('id_kategori', $kategori)
                    ->whereHas('Pegawai', function ($query) use ($perwakilan,$jabatan) {
                        $query->where('satuan_kerja', $perwakilan)->where('jabatan',$jabatan);
                    });
                 }
            }
        } else {
            // Untuk Menu Perhitungan SAW
            $data = SAW::with('Pegawai')->where('id_kategori',$kategori)->get();
        }

            return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
            {
                $actionBtn = '<a href="/kompetensi-pegawaiDetail/'.$row->pegawai->id.'"><span class="label label-success">view</span></a>' ;
                return $actionBtn;

            })->rawColumns(['action'])->make(true);




    }

    public static function getTableListPerwakilan(Request $request){
        $kategoris =  $request->input('kategori');
        list($kategori, $unsur) = explode('_', $kategoris);
        $jabatan =  $request->input('jabatan');

        if($jabatan == "all"){
            $data = DB::table('pegawais')
            ->select('pegawais.satuan_kerja',
                    DB::raw('AVG(saws.diklat) AS avg_diklat'),
                    DB::raw('AVG(saws.sertifikasi) AS avg_sertifikasi'),
                    DB::raw('AVG(saws.kinerja) AS avg_kinerja'),
                    DB::raw('AVG(saws.skp) AS avg_skp'),
                    DB::raw('AVG(saws.total) AS avg_totals'))
            ->join('saws', 'pegawais.id', '=', 'saws.id_pegawai')
            ->where('saws.id_kategori', $kategori)
            ->groupBy('pegawais.satuan_kerja')
            ->get();
        } else {
            $data = DB::table('pegawais')
            ->select('pegawais.satuan_kerja',
                    DB::raw('AVG(saws.diklat) AS avg_diklat'),
                    DB::raw('AVG(saws.sertifikasi) AS avg_sertifikasi'),
                    DB::raw('AVG(saws.kinerja) AS avg_kinerja'),
                    DB::raw('AVG(saws.skp) AS avg_skp'),
                    DB::raw('AVG(saws.total) AS avg_totals'))
            ->join('saws', 'pegawais.id', '=', 'saws.id_pegawai')
            ->where('saws.id_kategori', $kategori)
            ->where('pegawais.jabatan', $jabatan)
            ->groupBy('pegawais.satuan_kerja')
            ->get();
        }


        return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
        {
            $actionBtn = "";
            return $actionBtn;

        })->rawColumns(['action'])->make(true);
    }

    public static function Kmeans(Request $request){
        $kategoris =  $request->input('kategori');
        list($kategori, $unsur) = explode('_', $kategoris);

        $jabatan =  $request->input('jabatan');

        $client = new Client();
        $pythonEndpoint = 'http://localhost:5000/process_data'; // Replace with your Python API endpoint
        // return $jabatan;
        // Assuming you have your dataset in the $data variable
        if($jabatan == "all"){
            $data = DB::table('pegawais')
            ->select('pegawais.satuan_kerja',
                    DB::raw('AVG(saws.diklat) AS avg_diklat'),
                    DB::raw('AVG(saws.sertifikasi) AS avg_sertifikasi'),
                    DB::raw('AVG(saws.kinerja) AS avg_kinerja'),
                    DB::raw('AVG(saws.skp) AS avg_skp'),
                    DB::raw('AVG(saws.total) AS avg_totals'))
            ->join('saws', 'pegawais.id', '=', 'saws.id_pegawai')
            ->where('saws.id_kategori', $kategori)
            ->groupBy('pegawais.satuan_kerja')
            ->get();
        } else {
            $data = DB::table('pegawais')
            ->select('pegawais.satuan_kerja',
                    DB::raw('AVG(saws.diklat) AS avg_diklat'),
                    DB::raw('AVG(saws.sertifikasi) AS avg_sertifikasi'),
                    DB::raw('AVG(saws.kinerja) AS avg_kinerja'),
                    DB::raw('AVG(saws.skp) AS avg_skp'),
                    DB::raw('AVG(saws.total) AS avg_totals'))
            ->join('saws', 'pegawais.id', '=', 'saws.id_pegawai')
            ->where('saws.id_kategori', $kategori)
            ->where('pegawais.jabatan', $jabatan)
            ->groupBy('pegawais.satuan_kerja')
            ->get();
        }
        // dd($data)
        $datas = [];
        foreach ($data as $row) {
            $satuan_kerja = $row->satuan_kerja;
            $avg_totals = $row->avg_totals;

            if (!isset($datas[$satuan_kerja])) {
                $datas[$satuan_kerja] = [];
            }

            $datas[$satuan_kerja][] = $avg_totals;
        }
        // dd($datas);

        try {
            $response = $client->post($pythonEndpoint, [
                'json' => $datas,
            ]);

            $pythonResult = json_decode($response->getBody()->getContents(), true);

            return $pythonResult;
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 500);
        }
        // $k = 2; // Number of clusters

        // $kmeans = new KMeans($k);
        // $clusters = $kmeans->cluster($datas);



    }

    public function getTableListDiklat(Request $request){
        $datas = $request->input('data');
        $idPegawai = $request->input('pegawai');


        $filteredData = array_filter($datas, function ($item) {
            return (floatval($item['total']) < floatval($item['avg_total']));
        });

        $kategoriNames = array_map(function ($item) {
            return $item['kategori']['name'];
        }, $filteredData);

        $results = [];

        foreach ($kategoriNames as $data) {
            $result = $this->rekomendasiDiklat($data);

            foreach (json_decode($result, true) as $res) {
                $results[] = [
                    'kategori' => $data,
                    'diklat_id' => $res['id_diklat'],
                    'diklat_name' => $res['diklat_name'],
                    'diklat_jp' => $res['jp'],
                    'diklat_detail' => $res['detail'],
                    'similarity' => $res['similarity'],
                ];
            }
        }

        $getDiklatTelahDiikuti = MengikutiDiklat::select('id_diklat')->where('id_pegawai', $idPegawai)->pluck('id_diklat')->toArray();
        $results = array_filter($results, function ($result) use ($getDiklatTelahDiikuti) {
            return !in_array($result['diklat_id'], $getDiklatTelahDiikuti);
        });
        // dd($results);
        return DataTables::of($results)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getPegawaiData(Request $request){
        $id = $request->input('pegawai');
        $pegawai = Pegawai::find($id);
        $excludeList = ['Ahli', 'Muda','Pertama','/','Terampil','Madya'];
        $string = $pegawai->jabatan;

        $namaJabatan = $this->excludeAndTrim($string, $excludeList);
        $kategoriTerkait =  Kategori::where('jabatan', 'like', '%' .  $namaJabatan . '%')->get();

        $aggregatedData = collect(); // Initialize the collection
        // return $kategoriTerkait;
        foreach ($kategoriTerkait as $kategori) {
            $idKategori = $kategori->id;


            // Fetch SAW data associated with the current Kategori using the relationship
            $dataFromSAW = SAW::with(['kategori','pegawai']) // Eager load the kategori relation
            ->where('id_pegawai', $id)
            ->where('id_kategori', $idKategori)
            ->get();

            // Append the fetched data to the aggregated collection
            $aggregatedData = $aggregatedData->concat($dataFromSAW);

            $averages = SAW::select('id_kategori', DB::raw('AVG(total) as avg_total'))
            ->groupBy('id_kategori')
            ->pluck('avg_total', 'id_kategori')
            ->toArray();

            foreach ($aggregatedData as $data) {
                $idKategori = $data->kategori->id;
                $data->avg_total = $averages[$idKategori] ?? 0;
            }


        }
        return $aggregatedData;






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


    public static function rekomendasiDiklat($search){
        // Your diklat data
        $diklatData = Diklat::all();
        // Given string
        $givenString = $search;

        // Function to calculate cosine similarity between two strings

        // Calculate similarity for each diklat
        foreach ($diklatData as $diklat) {

            $deskripsiDiklat = $diklat->detail." ".$diklat->kategori;

            $similarity = cosineSimilarity($givenString,$deskripsiDiklat ?? '');

            $recommendation = new stdClass();
            $recommendation->id_diklat = $diklat->id; // Replace with the correct attribute name
            $recommendation->diklat_name = $diklat->name; // Replace with the correct attribute name
            $recommendation->jp = $diklat->jp; // Replace with the correct attribute name
            $recommendation->detail = $diklat->detail; // Replace with the correct attribute name
            $recommendation->similarity = $similarity;
            $recommendation->givenString = $givenString;

            $recommendations[] = $recommendation;
        }


        usort($recommendations, function ($a, $b) {
            return $b->similarity <=> $a->similarity;
        });

        $topRecommendations = array_slice($recommendations, 0, 2);

        // Get top 2 recommendations
        return json_encode($topRecommendations, JSON_PRETTY_PRINT);
    }



}
