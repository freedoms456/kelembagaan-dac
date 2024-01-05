<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikasiKategori extends Model
{
    use HasFactory;

    public function Sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class , 'id_sertifikasi');
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class , 'id_kategori');
    }
}
