<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MengikutiKegiatan extends Model
{
    use HasFactory;

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }
    public function Kegiatan()
    {
        return $this->belongsTo(Diklat::class , 'id_kegiatan');
    }
}
