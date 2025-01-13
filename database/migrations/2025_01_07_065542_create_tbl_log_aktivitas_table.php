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
        Schema::create('tbl_log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->unsignedBigInteger('id_model');
            $table->string('aksi'); // create, update, delete
            $table->text('data')->nullable(); // menyimpan perubahan dalam JSON
            $table->unsignedBigInteger('id_user');
            $table->string('user_role');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->timestamps();

            $table->foreign('id_user')->references('id_login')->on('tbl_login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_log_aktivitas');
    }
};
