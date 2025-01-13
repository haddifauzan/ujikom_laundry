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
        Schema::create('tbl_rincian_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_rincian_pembelian'); // Primary key rincian pembelian
            $table->integer('jumlah');                    // Jumlah barang yang dibeli
            $table->integer('subtotal');                  // Subtotal biaya untuk item tertentu
            $table->bigInteger('id_pembelian')            // Relasi ke tabel pembelian
                  ->unsigned();
            $table->foreign('id_pembelian')
                  ->references('id_pembelian')
                  ->on('tbl_pembelian')
                  ->onDelete('cascade');
            $table->bigInteger('id_barang')               // Relasi ke tabel barang
                  ->unsigned();
            $table->foreign('id_barang')
                  ->references('id_barang')
                  ->on('tbl_barang')
                  ->onDelete('cascade');
            $table->timestamps();                         // Waktu pembuatan dan update data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rincian_pembelian');
    }
};
