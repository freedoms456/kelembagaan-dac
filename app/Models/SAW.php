<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SAW extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'saws';

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class , 'id_kategori');
    }
    public function Pegawai()
    {
        return $this->belongsTo(Pegawai::class , 'id_pegawai');
    }

}
