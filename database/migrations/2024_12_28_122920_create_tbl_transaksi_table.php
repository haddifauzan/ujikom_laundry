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
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('no_transaksi');
            $table->dateTime('waktu_transaksi');
            $table->dateTime('waktu_pengambilan')->nullable();
            $table->text('pesan_konsumen')->nullable();
            $table->text('pesan_karyawan')->nullable();
            $table->enum('status_transaksi', ['pending', 'proses', 'selesai', 'batal']);
            $table->bigInteger('id_karyawan')->unsigned();
            $table->foreign('id_karyawan')
                  ->references('id_karyawan')
                  ->on('tbl_karyawan')
                  ->onDelete('cascade');
            $table->bigInteger('id_konsumen')->unsigned();
            $table->foreign('id_konsumen')
                  ->references('id_konsumen')
                  ->on('tbl_konsumen')
                  ->onDelete('cascade');
            $table->bigInteger('id_voucher')->unsigned()->nullable();
            $table->foreign('id_voucher')
                  ->references('id_voucher')
                  ->on('tbl_voucher')
                  ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi');
    }
};
