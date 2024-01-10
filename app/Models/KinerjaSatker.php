<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaSatker extends Model
{
    use HasFactory;

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }
    public function Satker()
    {
        return $this->belongsTo(Satker::class , 'id_pegawai', 'id');
    }

}
