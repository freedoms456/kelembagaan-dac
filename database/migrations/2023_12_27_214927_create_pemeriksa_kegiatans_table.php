<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemeriksa_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai')->default(0);
            $table->string('role_tim')->default(0);
            $table->string('lokasi_pemeriksaan')->default(0);
            $table->string('tahun')->default(0);
            $table->string('akun')->default(0);
            $table->string('jenis_pemeriksaan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksa_kegiatans');
    }
};
