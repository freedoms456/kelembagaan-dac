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
        // return 1;
        // dd($request->input('kategori'));
        $kategori =  $request->input('kategori');
        // list($kategori, $unsur) = explode('_', $kategoris);
        // $data = Kategori::all();
        // return $unsur;
        // Call Data
        // return $kategori;
        // $kategori = "Akuntansi";
<<<<<<< HEAD
        $kategoriBidang = KategoriPemeriksaan::where('bicdang', $kategori)->pluck('id_kategori');


=======
        $kategoriBidang = KategoriPemeriksaan::where('bidang', $kategori)->pluck('id_kategori');
        // return $kategoriBidang;
>>>>>>> 57642dd444711cd8422cd091f8a0864e18e97af1
        $dataSAW = SAW::join('pegawais', 'saws.id_pegawai', '=', 'pegawais.id')
                ->select('pegawais.id', DB::raw('avg(total) as poin_saw'))
                ->orWhereIn('saws.id_kategori', $kategoriBidang)
                ->groupBy('pegawais.id')
                ->get()->toArray();
                // dd($dataSAW);

                // return $dataSAW;
        $dataJurusan = Pegawai::
            select('id','name', DB::raw('COUNT(id) as poin_jurusan'))
            ->where('jurusan_kategori', $kategori) // Assuming 'id' is an integer value, no quotes around the value
            ->groupBy('pegawais.id','name')
            ->get()->toArray();
        // dd($dataJurusan);
            $mergedData = [];

            $mergedData = collect($dataSAW)
            ->merge($dataJurusan)
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
        // dd($normalizedData);
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

        // dd($weightedScores);
        // SAWPemeriksa::where('id_kategori', $kategori)->delete();

        // Insert new records

        SAWPemeriksa::insert($weightedScores);

        return $weightedScores;

    }


    public static function SAWPemeriksaTable(Request $request){
        $kategori =  $request->input('kategori');
        // $kategori = "Akuntansi";
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


    public static function bentukTim(Request $request){
        $kategori = "LK";
        if($kategori == "LK"){
            $akuntansi = SAWPemeriksa::with('pegawai')->where("id_kategori", "Akuntansi")
            ->whereHas('pegawai', function ($query) {
                $query->where('satuan_kerja', 'Kaltara');
            })
            ->whereHas('pegawai', function ($query) {
                $query->where('jabatan', 'LIKE','%meriksa%');
            })
            ->orderBy('poin_kompentensiPemeriksa', 'DESC')->get()->toArray();

            // return $akuntansi;
            $hukum = SAWPemeriksa::with('pegawai')->where("id_kategori","Hukum")
            ->whereHas('pegawai', function ($query) {
                $query->where('satuan_kerja', 'Kaltara');
            })
            ->whereHas('pegawai', function ($query) {
                $query->where('jabatan', 'LIKE','%meriksa%');
            })
            ->orderBy('poin_kompentensiPemeriksa', 'DESC')->get()->toArray();

            $teknikSipil = SAWPemeriksa::with('pegawai')->where("id_kategori","Teknik Sipil")
            ->whereHas('pegawai', function ($query) {
                $query->where('satuan_kerja', 'Kaltara');
            })
            ->whereHas('pegawai', function ($query) {
                $query->where('jabatan', 'LIKE','%meriksa%');
            })
            ->orderBy('poin_kompentensiPemeriksa', 'DESC')->get()->toArray();

            $it = SAWPemeriksa::with('pegawai')->where("id_kategori","IT")
            ->whereHas('pegawai', function ($query) {
                $query->where('satuan_kerja', 'Kaltara');
            })
            ->whereHas('pegawai', function ($query) {
                $query->where('jabatan', 'LIKE','%meriksa%');
            })
            ->orderBy('poin_kompentensiPemeriksa', 'DESC')->get()->toArray();

            $pt = SAWPemeriksa::with('pegawai')->where("id_kategori","PT")
            ->whereHas('pegawai', function ($query) {
                $query->where('satuan_kerja', 'Kaltara');
            })
            ->whereHas('pegawai', function ($query) {
                $query->where('jabatan', 'LIKE','%meriksa%');
            })
            ->orderBy('poin_kompentensiPemeriksa', 'DESC')->get()->toArray();

            $kt = SAWPemeriksa::with('pegawai')
            ->where("id_kategori", "Ketua Tim")
            ->whereHas('pegawai', function ($query) {
                $query->where('jabatan', 'Pemeriksa Ahli Muda');
            })
            ->whereHas('pegawai', function ($query) {
                $query->where('satuan_kerja', 'Kaltara');
            })
            ->orderBy('poin_kompentensiPemeriksa', 'DESC')
            ->get();

          $ktAll = $kt->map(function ($item) {
            $item->poin_akuntansi = null;
            $item->poin_hukum = null;
            $item->poin_it = null;

            return $item;
        });

        $ktAll = $ktAll->all();



        $ktAll = mapDataToKt($ktAll, $akuntansi, 'poin_akuntansi');
        $ktAll = mapDataToKt($ktAll, $hukum, 'poin_hukum');
        $ktAll = mapDataToKt($ktAll, $it, 'poin_it');

        $allPlayers = array_merge($hukum, $it, $akuntansi, $teknikSipil,$pt);
        arsort($allPlayers);
        // Number of teams
        $assignedPlayers = [];

       // Assuming $allPlayers is an associative array of players with their scores
// Assuming $kt is an array of players from the 'kt' category

// Assuming $allPlayers is an associative array of players with their scores
// Assuming $ktAll is an array of players from the 'kt' category

$numTeams = 4; // Change this value as needed
$maxPlayersPerTeam = 7; // Maximum players per team

// Initialize teams as arrays to hold players and their scores
$teams = array_fill(0, $numTeams, ['players' => [], 'totalScore' => 0]);

// Sort players by their total scores
arsort($allPlayers);

// Get the number of players in $ktAll
$numKtPlayers = count($ktAll);

// Initialize an array to keep track of used players from $kt category
$usedKtPlayers = [];

// Distribute players to teams while balancing count and total scores (with a max of 7 players per team)
foreach ($allPlayers as $player => $totalScore) {
    // Find the team with the lowest total score
    $minTeamIndex = array_search(min(array_column($teams, 'totalScore')), array_column($teams, 'totalScore'));

    // If the team hasn't reached the maximum player count, add the player
    if (count($teams[$minTeamIndex]['players']) < $maxPlayersPerTeam) {
        // If the team is empty and $ktAll has players left, assign the first player from the $kt category
        if (empty($teams[$minTeamIndex]['players']) && count($usedKtPlayers) < $numKtPlayers) {
            $ktPlayer = $ktAll[count($usedKtPlayers)];
            $teams[$minTeamIndex]['players'][$ktPlayer['id']] = $ktPlayer; // Assuming 'id' is the unique identifier for players
            $usedKtPlayers[] = $ktPlayer;
            $teams[$minTeamIndex]['totalScore'] += array_sum($ktPlayer['scores']); // Assuming 'scores' contains player scores
        } else {
            // Otherwise, assign players from the sorted list
            $teams[$minTeamIndex]['players'][$player] = $totalScore;
            $teams[$minTeamIndex]['totalScore'] += array_sum($totalScore);
        }
    }
}
        dd("test");
        }
    }

}
