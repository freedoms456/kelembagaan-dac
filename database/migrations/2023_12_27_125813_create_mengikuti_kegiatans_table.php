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
        Schema::create('mengikuti_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai')->default(0);
            $table->string('kegiatan')->default(0);
            $table->string('tahun')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mengikuti_kegiatans');
    }
};
