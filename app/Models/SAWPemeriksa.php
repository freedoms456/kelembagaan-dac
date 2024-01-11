<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SAWPemeriksa extends Model
{
    use HasFactory;
    protected $table = "saw_pemeriksas";


    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class , 'id_kategori');
    }
    
}
