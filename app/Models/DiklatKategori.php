<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiklatKategori extends Model
{
    use HasFactory;

    public function Diklat()
    {
        return $this->belongsTo(Diklat::class , 'id_diklat');
    }

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class , 'id_kategori');
    }

}
