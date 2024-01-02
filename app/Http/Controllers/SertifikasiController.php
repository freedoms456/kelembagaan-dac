<?php

namespace App\Http\Controllers;

use App\Models\Sertifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\MengikutiSertifikasi;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreSertifikasiRequest;
use App\Http\Requests\UpdateSertifikasiRequest;

class SertifikasiController extends Controller
{
   public static function getSertifikasiData(Request $request){
    $perwakilan =  $request->input('perwakilan');
    $bidang =  $request->input('bidang');
        if($perwakilan == "all"){
            if($bidang == "all"){
            $data = MengikutiSertifikasi::join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
            ->join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
            ->select('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama', DB::raw('count(*) as total'))
            ->groupBy('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama')
            ->orderBy('total', 'desc') // Sort by total in descending order
            ->limit(20) // Limit the results to the top 20
            ->get();
            }
            else {
                $data = MengikutiSertifikasi::join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
                ->join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
                ->select('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama', DB::raw('count(*) as total'))
                ->where('sertifikasis.bidang', '=', $bidang) // Filter based on perwakilan in Pegawai table
                ->groupBy('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama')
                ->orderBy('total', 'desc') // Sort by total in descending order
                ->limit(20) // Limit the results to the top 20
                ->get();
            }
        } else {
            if($bidang == "all"){
                $data = MengikutiSertifikasi::join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
                ->join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
                ->select('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama', DB::raw('count(*) as total'))
                ->where('pegawais.satuan_kerja', '=', $perwakilan) // Filter based on perwakilan in Pegawai table
                ->groupBy('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama')
                ->orderBy('total', 'desc') // Sort by total in descending order
                ->limit(20) // Limit the results to the top 20
                ->get();
            } else {
                $data = MengikutiSertifikasi::join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
                ->join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
                ->select('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama', DB::raw('count(*) as total'))
                ->where('pegawais.satuan_kerja', '=', $perwakilan) // Filter based on perwakilan in Pegawai table
                ->where('sertifikasis.bidang', '=', $bidang) // Filter based on perwakilan in Pegawai table
                ->groupBy('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama')
                ->orderBy('total', 'desc') // Sort by total in descending order
                ->limit(20) // Limit the results to the top 20
                ->get();
            }
        }

        return response()->json($data);
   }

   public static function getSertifikasiByJenis(Request $request){
    $perwakilan =  $request->input('perwakilan');

    if($perwakilan == "all"){
        $data = MengikutiSertifikasi::join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
        ->join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
        ->select('sertifikasis.bidang', DB::raw('count(*) as total'))
        ->groupBy('sertifikasis.bidang')
        ->orderBy('total', 'desc') // Sort by total in descending order
        ->get();
    } else {
        $data = MengikutiSertifikasi::join('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
        ->join('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
        ->select('sertifikasis.bidang', DB::raw('count(*) as total'))
        ->where('pegawais.satuan_kerja', '=', $perwakilan) // Filter based on perwakilan in Pegawai table
        ->groupBy('sertifikasis.bidang')
        ->orderBy('total', 'desc') // Sort by total in descending order
        ->get();
    }

    return response()->json($data);
   }

   public static function getTableMilikList(Request $request){
    $perwakilan = $request->input('perwakilan');
    $bidang = $request->input('bidang');

    if ($request->ajax())
    {
        if($perwakilan == "all"){
            if($bidang == "all"){
                $data = MengikutiSertifikasi::rightJoin('sertifikasis', 'mengikuti_sertifikasis.id_sertifikasi', '=', 'sertifikasis.id')
                ->leftJoin('pegawais', 'mengikuti_sertifikasis.id_pegawai', '=', 'pegawais.id')
                ->select('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama', 'sertifikasis.bidang', DB::raw('COUNT(mengikuti_sertifikasis.id_sertifikasi) as total'))
                ->groupBy('mengikuti_sertifikasis.id_sertifikasi', 'sertifikasis.nama', 'sertifikasis.bidang')
                ->orderBy('total', 'desc')
                ->get();
            } else {
                $sql = "
                SELECT sertifikasis.id, sertifikasis.nama, sertifikasis.bidang, COUNT(pegawais.id) as total
                FROM sertifikasis
                LEFT JOIN mengikuti_sertifikasis ON sertifikasis.id = mengikuti_sertifikasis.id_sertifikasi AND sertifikasis.bidang = :bidang
                LEFT JOIN pegawais ON mengikuti_sertifikas is.id_pegawai = pegawais.id
                GROUP BY sertifikasis.id, sertifikasis.nama, sertifikasis.bidang
                ORDER BY total DESC
                 ";

                 $data = DB::select($sql, ['bidang' => $bidang]);
            }
        } else {
            if($bidang == "all"){
                $sql = "
                SELECT sertifikasis.id, sertifikasis.nama, sertifikasis.bidang, COUNT(pegawais.id) as total
                FROM sertifikasis
                LEFT JOIN mengikuti_sertifikasis ON sertifikasis.id = mengikuti_sertifikasis.id_sertifikasi
                LEFT JOIN pegawais ON mengikuti_sertifikasis.id_pegawai = pegawais.id AND pegawais.satuan_kerja = :perwakilan
                GROUP BY sertifikasis.id, sertifikasis.nama, sertifikasis.bidang
                ORDER BY total DESC
                ";

                $data = DB::select($sql, ['perwakilan' => $perwakilan]);
            } else {
                $sql = "
                        SELECT sertifikasis.id, sertifikasis.nama, sertifikasis.bidang, COUNT(pegawais.id) as total
                        FROM sertifikasis
                        LEFT JOIN mengikuti_sertifikasis ON sertifikasis.id = mengikuti_sertifikasis.id_sertifikasi
                        LEFT JOIN pegawais ON mengikuti_sertifikasis.id_pegawai = pegawais.id
                            AND pegawais.satuan_kerja = :perwakilan
                        WHERE sertifikasis.bidang = :bidang
                        GROUP BY sertifikasis.id, sertifikasis.nama, sertifikasis.bidang
                        ORDER BY total DESC
                    ";

                $data = DB::select($sql, ['perwakilan' => $perwakilan, 'bidang' => $bidang]);
            }
        }
        return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
        {
            $actionBtn = "" ;
            return $actionBtn;

        })->rawColumns(['action'])->make(true);
    }


   }
   public static function getTableList(Request $request){
    $perwakilan = $request->input('perwakilan');
    $bidang = $request->input('bidang');


    if ($request->ajax())
    {
        if($perwakilan == "all"){
            if($bidang == "all"){
                $data = MengikutiSertifikasi::with(['Pegawai','Sertifikasi'])->latest()->get();
            } else {
                $data = MengikutiSertifikasi::with(['Pegawai', 'Sertifikasi'])
                ->whereHas('Sertifikasi', function ($query) use ($bidang) {
                    $query->where('bidang', $bidang);
                })
                ->latest()
                ->get();
            }

        } else {
            if($bidang == "all"){
            $data = MengikutiSertifikasi::with(['Pegawai', 'Sertifikasi'])
            ->whereHas('Pegawai', function ($query) use ($perwakilan) {
                $query->where('satuan_kerja', $perwakilan);
            })
            ->latest()
            ->get();
            } else {
                $data = MengikutiSertifikasi::with(['Pegawai', 'Sertifikasi'])
                ->whereHas('Pegawai', function ($query) use ($perwakilan) {
                    $query->where('satuan_kerja', $perwakilan);
                })
                ->whereHas('Sertifikasi', function ($query) use ($bidang) {
                    $query->where('bidang', $bidang);
                })
                ->latest()
                ->get();
            }
        }
        return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
        {
            $actionBtn = "" ;
            return $actionBtn;

        })->rawColumns(['action'])->make(true);
    }


   }
}
