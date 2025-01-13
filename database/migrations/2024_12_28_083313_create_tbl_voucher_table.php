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
        Schema::create('tbl_voucher', function (Blueprint $table) {
            $table->bigIncrements('id_voucher');
            $table->string('kode_voucher')->unique();
            $table->text('deskripsi')->nullable();
            $table->bigInteger('jumlah_voucher')->default(0); // Default untuk menghindari null
            $table->decimal('diskon_persen', 5, 2)->nullable(); // Format 99.99
            $table->decimal('diskon_nominal', 10, 2)->nullable();
            $table->decimal('min_subtotal_transaksi', 15, 2)->default(0); // Minimal subtotal
            $table->decimal('max_diskon', 10, 2)->nullable(); // Maksimal diskon
            $table->dateTime('masa_berlaku_mulai')->nullable();
            $table->dateTime('masa_berlaku_selesai')->nullable();
            $table->integer('min_jumlah_transaksi')->default(1);
            $table->text('syarat_ketentuan')->nullable();
            $table->string('gambar')->nullable(); // URL atau path gambar
            $table->enum('status', ['Aktif', 'Non-Aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_voucher');
    }
};
