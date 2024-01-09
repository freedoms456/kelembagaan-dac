<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diklat extends Model
{
    use HasFactory;

    public function MengikutiDiklat()
    {
        return $this->hasMany(MengikutiDiklat::class,'id_diklat');
    }

    public function DiklatKategori()
    {
        return $this->hasMany(DiklatKategori::class,'id_diklat');
    }
}
