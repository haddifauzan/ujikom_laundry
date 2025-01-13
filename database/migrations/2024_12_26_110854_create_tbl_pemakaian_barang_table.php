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
        Schema::create('tbl_pemakaian_barang', function (Blueprint $table) {
            $table->bigIncrements('id_pemakaian');  // Primary key pemakaian barang
            $table->bigInteger('id_barang')         // Relasi ke tabel barang
                  ->unsigned();
            $table->integer('jumlah');              // Jumlah barang yang dipakai
            $table->datetime('waktu_pemakaian');    // Waktu barang digunakan
            $table->foreign('id_barang')
                  ->references('id_barang')
                  ->on('tbl_barang')
                  ->onDelete('cascade');
            $table->timestamps();                   // Waktu pembuatan dan update data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pemakaian_barang');
    }
};
