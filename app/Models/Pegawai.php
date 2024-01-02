<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Sertifikasi()
    {
        return $this->hasMany(MengikutiSertifikasi::class,'id_sertifikasi');
    }
}
