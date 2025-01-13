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
        Schema::table('tbl_rincian_transaksi', function (Blueprint $table) {
            // Tambahkan kolom id_jenis dengan foreign key ke tbl_jenis_laundry
            $table->unsignedBigInteger('id_jenis')->nullable()->after('id_transaksi');
            $table->foreign('id_jenis')
                ->references('id_jenis')
                ->on('tbl_jenis_laundry')
                ->onDelete('cascade');

            // Tambahkan kolom id_layanan dengan nullable dan foreign key ke tbl_layanan_tambahan
            $table->unsignedBigInteger('id_layanan')->nullable()->after('id_jenis');
            $table->foreign('id_layanan')
                ->references('id_layanan')
                ->on('tbl_layanan_tambahan')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_rincian_transaksi', function (Blueprint $table) {
            // Hapus foreign key dan kolom id_jenis
            $table->dropForeign(['id_jenis']);
            $table->dropColumn('id_jenis');

            // Hapus foreign key dan kolom id_layanan
            $table->dropForeign(['id_layanan']);
            $table->dropColumn('id_layanan');
        });
    }
};
