<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokSertifikasi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function Sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class , 'id_sertifikasi');
    }
}
