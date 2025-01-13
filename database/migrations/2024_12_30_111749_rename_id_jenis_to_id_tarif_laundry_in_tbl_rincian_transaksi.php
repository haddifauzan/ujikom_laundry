<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tbl_rincian_transaksi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tarif')->nullable()->after('id_transaksi');
            $table->foreign('id_tarif')
                ->references('id_tarif')
                ->on('tbl_tarif_laundry')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_rincian_transaksi', function (Blueprint $table) {
            $table->dropColumn('id_tarif');
        });
    }
};
