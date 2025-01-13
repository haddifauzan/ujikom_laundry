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
        Schema::create('tbl_pembelian', function (Blueprint $table) {
            $table->bigIncrements('id_pembelian'); // Primary key pembelian
            $table->string('no_pembelian');        // Nomor unik pembelian
            $table->datetime('waktu_pembelian');   // Waktu pembelian
            $table->integer('total_biaya');        // Total biaya dari pembelian
            $table->bigInteger('id_karyawan')      // ID karyawan yang melakukan pembelian
                  ->unsigned();
            $table->timestamps();                  // Waktu pembuatan dan update data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pembelian');
    }
};
