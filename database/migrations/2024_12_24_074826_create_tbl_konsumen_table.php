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
        Schema::create('tbl_konsumen', function (Blueprint $table) {
            $table->bigIncrements('id_konsumen');
            $table->string('kode_konsumen');
            $table->string('nama_konsumen');
            $table->string('alamat_konsumen');
            $table->string('noHp_konsumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_konsumen');
    }
};
