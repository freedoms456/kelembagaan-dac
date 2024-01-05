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
        Schema::create('saws', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai')->default(0);
            $table->string('diklat')->default(0);
            $table->string('sertifikasi')->default(0);
            $table->string('kinerja')->default(0);
            $table->string('skp')->default(0);
            $table->string('total')->default(0);
            $table->string('id_kategori')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s_a_w_s');
    }
};
