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
        Schema::table('mengikuti_kegiatans', function (Blueprint $table) {
            //
            $table->string('nilai_skp')->defaut(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mengikuti_kegiatans', function (Blueprint $table) {
            //
        });
    }
};
