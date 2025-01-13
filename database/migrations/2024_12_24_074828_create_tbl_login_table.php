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
        Schema::create('tbl_login', function (Blueprint $table) {
            $table->bigIncrements('id_login');
            $table->string('email');
            $table->string('password');
            $table->datetime('last_login');
            $table->bigInteger('id_user');
            $table->boolean('status_akun')->default(true);
            $table->enum('role', ['Admin', 'Konsumen', 'Karyawan']); 
            $table->bigInteger('id_karyawan')->unsigned()->nullable();
            $table->bigInteger('id_konsumen')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id_karyawan')->on('tbl_karyawan')->onDelete('cascade');
            $table->foreign('id_konsumen')->references('id_konsumen')->on('tbl_konsumen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_login');
    }
};
