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
        Schema::create('tbl_layanan_tambahan', function (Blueprint $table) {
            $table->bigIncrements('id_layanan'); // Primary key
            $table->string('nama_layanan', 100); // Nama layanan tambahan
            $table->text('deskripsi')->nullable(); // Deskripsi layanan tambahan
            $table->string('satuan', 50)->nullable(); // Satuan layanan tambahan (per item, per kg, dll)
            $table->decimal('harga', 10, 2); // Harga layanan tambahan
            $table->enum('status', ['Aktif', 'Non-Aktif'])->default('Aktif'); // Status layanan tambahan
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_layanan_tambahan');
    }
};
