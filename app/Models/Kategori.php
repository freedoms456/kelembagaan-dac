<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    public function SAW()
{
    return $this->hasMany(SAW::class, 'id_kategori', 'id');
    return $this->hasMany(DiklatKategori::class, 'id_kategori', 'id');
}
}
