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
        Schema::create('tbl_rincian_transaksi', function (Blueprint $table) {
            $table->id('id_rincian_transaksi');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->bigInteger('id_transaksi')->unsigned();
            $table->foreign('id_transaksi')
                  ->references('id_transaksi')
                  ->on('tbl_transaksi')
                  ->onDelete('cascade');
            $table->bigInteger('id_jenis')->unsigned();
            $table->foreign('id_jenis')
                  ->references('id_jenis')
                  ->on('tbl_jenis_laundry')
                  ->onDelete('cascade');
            $table->bigInteger('id_layanan')->unsigned();
            $table->foreign('id_layanan')
                  ->references('id_layanan')
                  ->on('tbl_layanan_tambahan')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_rincian_transaksi');
    }
};
