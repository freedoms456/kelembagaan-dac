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
        Schema::create('saw_pemeriksas', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai')->default(0);
            $table->string('id_kategori')->default(0);
            $table->string('poin_jurusan')->default(0);
            $table->string('poin_saw')->default(0);
            $table->string('poin_kompentensiPemeriksa')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_w_pemeriksas');
    }
};
