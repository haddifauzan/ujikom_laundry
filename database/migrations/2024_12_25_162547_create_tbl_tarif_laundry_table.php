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
        Schema::create('tbl_tarif_laundry', function (Blueprint $table) {
            $table->id('id_tarif');
            $table->enum('jenis_tarif', ['satuan', 'nama pakaian']); // Contoh enum
            $table->string('satuan')->nullable();
            $table->string('nama_pakaian')->nullable();// Sesuaikan dengan kebutuhan
            $table->integer('tarif'); // Dalam satuan rupiah
            $table->unsignedBigInteger('id_jenis');
            $table->timestamps();

            // Foreign key
            $table->foreign('id_jenis')->references('id_jenis')->on('tbl_jenis_laundry')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_tarif_laundry');
    }
};
