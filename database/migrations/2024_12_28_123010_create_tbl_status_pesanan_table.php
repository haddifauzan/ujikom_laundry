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
        Schema::create('tbl_status_pesanan', function (Blueprint $table) {
            $table->id('id_status_pesanan');
            $table->enum('status', ['pending', 'proses', 'selesai', 'batal']);
            $table->text('keterangan')->nullable();
            $table->dateTime('waktu_perubahan');
            $table->bigInteger('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')
                  ->references('id_karyawan')
                  ->on('tbl_karyawan')
                  ->onDelete('cascade');
            $table->bigInteger('id_transaksi')->unsigned();
            $table->foreign('id_transaksi')
                  ->references('id_transaksi')
                  ->on('tbl_transaksi')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_status_pesanan');
    }
};
