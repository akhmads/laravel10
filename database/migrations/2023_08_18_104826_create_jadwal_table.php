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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('tapel_code', 30)->index();
            $table->string('kelas_code', 30)->index();
            $table->string('matpel_code', 30)->index();
            $table->string('guru_code', 30)->index();
            $table->string('ruangan_code', 30)->index();
            $table->tinyinteger('hari')->index();
            $table->tinyinteger('jam_awal')->index();
            $table->tinyinteger('jam_akhir')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
