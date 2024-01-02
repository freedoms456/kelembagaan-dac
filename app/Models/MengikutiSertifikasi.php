<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MengikutiSertifikasi extends Model
{
    use HasFactory;

    public function Sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class , 'id_sertifikasi');
    }
    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }
}
