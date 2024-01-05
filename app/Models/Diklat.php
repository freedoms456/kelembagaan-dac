<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diklat extends Model
{
    use HasFactory;

    public function MengikutiSertifikasi()
    {
        return $this->hasMany(MengikutiSertifikasi::class,'id_sertifikasi');
    }

    public function DiklatKategori()
    {
        return $this->hasMany(SertifikasiKategori::class,'id_sertifikasi');
    }
}
