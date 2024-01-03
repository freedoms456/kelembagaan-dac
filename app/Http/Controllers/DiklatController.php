<?php

namespace App\Http\Controllers;

use App\Models\Diklat;
use Illuminate\Http\Request;
use App\Models\MengikutiDiklat;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreDiklatRequest;
use App\Http\Requests\UpdateDiklatRequest;

class DiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public static function getDiklatJabatan(Request $request){
        $kategori =  $request->input('kategori');

        if($kategori == "all"){
            $data = MengikutiDiklat::join('diklats', 'mengikuti_diklats.id_diklat', '=', 'diklats.id')
            ->join('pegawais', 'mengikuti_diklats.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
            ->select('pegawais.jabatan', DB::raw('count(*) as total'))
            ->groupBy('pegawais.jabatan')
            ->orderBy('total', 'desc') // Sort by total in descending order
            ->get();
        } else {
            $data = MengikutiDiklat::join('diklats', 'mengikuti_diklats.id_diklat', '=', 'diklats.id')
            ->join('pegawais', 'mengikuti_diklats.id_pegawai', '=', 'pegawais.id') // Join with Pegawai table
            ->select('pegawais.jabatan', DB::raw('count(*) as total'))
            ->where('diklats.kategori', '=', $kategori)
            ->groupBy('pegawais.jabatan')
            ->orderBy('total', 'desc') // Sort by total in descending order
            ->get();
        }

        return response()->json($data);
     }

    public static function getTableList(Request $request){
        $kategori =  $request->input('kategori');
        if ($request->ajax())
        {
            if($kategori == "all"){
                $data = MengikutiDiklat::rightJoin('diklats', 'mengikuti_diklats.id_diklat', '=', 'diklats.id')
                ->leftJoin('pegawais', 'mengikuti_diklats.id_pegawai', '=', 'pegawais.kategoriserid')
                ->select('mengikuti_diklats.id_diklat', 'diklats.name', 'diklats.jp', DB::raw('COUNT(mengikuti_diklats.id_diklat) as total'))
                ->groupBy('mengikuti_diklats.id_diklat', 'diklats.name', 'diklats.jp')
                ->orderBy('total', 'desc')
                ->get();
            } else {
                $sql = "
                SELECT diklats.id, diklats.name, diklats.jp, COUNT(pegawais.id) as total
                FROM diklats
                LEFT JOIN mengikuti_diklats ON diklats.id = mengikuti_diklats.id_diklat AND diklats.kategori = :kategori
                LEFT JOIN pegawais ON mengikuti_diklats.id_pegawai = pegawais.id
                GROUP BY diklats.id, diklats.name, diklats.jp
                ORDER BY total DESC
                 ";

                 $data = DB::select($sql, ['kategori' => $kategori]);

            }
            return DataTables::of($data)->addIndexColumn()->addColumn('action', function ($row)
            {
                $actionBtn = "" ;
                return $actionBtn;

            })->rawColumns(['action'])->make(true);
        }



    }

}
