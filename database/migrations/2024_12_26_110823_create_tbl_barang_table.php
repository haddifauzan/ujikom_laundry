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
        Schema::create('tbl_barang', function (Blueprint $table) {
            $table->bigIncrements('id_barang');    // Primary key barang
            $table->string('kode_barang');         // Kode unik barang
            $table->string('nama_barang');         // Nama barang
            $table->string('kategori_barang');     // Kategori barang
            $table->integer('stok');               // Jumlah stok barang
            $table->integer('harga_satuan');       // Harga satuan barang
            $table->bigInteger('id_supplier')      // Relasi ke tabel supplier
                  ->unsigned();
            $table->foreign('id_supplier')
                  ->references('id_supplier')
                  ->on('tbl_supplier')
                  ->onDelete('cascade');
            $table->timestamps();                  // Waktu pembuatan dan update data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_barang');
    }
};
