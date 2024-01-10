<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaKegiatan extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'pemeriksakegiatans';

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }
}
