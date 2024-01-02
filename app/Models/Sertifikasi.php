<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function KelompokSertifikasi()
    {
        return $this->hasMany(KelompokSertifikasi::class,'id_sertifikasi');
    }
    public function MengikutiSertifikasi()
    {
        return $this->hasMany(MengikutiSertifikasi::class,'id_sertifikasi');
    }
}
