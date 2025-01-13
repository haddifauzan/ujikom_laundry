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
        Schema::create('tbl_supplier', function (Blueprint $table) {
            $table->bigIncrements('id_supplier'); // Primary key untuk supplier
            $table->string('nama_supplier');      // Nama supplier
            $table->string('alamat_supplier');    // Alamat lengkap supplier
            $table->string('nohp_supplier');      // Nomor HP supplier
            $table->timestamps();                 // Waktu pembuatan dan update data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_supplier');
    }
};
