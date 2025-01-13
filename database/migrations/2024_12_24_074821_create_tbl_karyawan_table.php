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
        Schema::create('tbl_karyawan', function (Blueprint $table) {
            $table->bigIncrements('id_karyawan');
            $table->string('nik');
            $table->string('kode_karyawan');
            $table->string('nama_karyawan');
            $table->string('noHp_karyawan');
            $table->enum('gender_karyawan', ['L', 'P']);
            $table->string('foto_karyawan');
            $table->enum('status_karyawan', ['kasir', 'pengelola barang']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_karyawan');
    }
};
