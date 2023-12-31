<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MengikutiDiklat extends Model
{
    use HasFactory;

    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }
    public function Diklat()
    {
        return $this->belongsTo(Diklat::class , 'id_diklat');
    }
}
