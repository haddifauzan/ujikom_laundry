<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRememberTokenToTblLogin extends Migration
{
    public function up()
    {
        Schema::table('tbl_login', function (Blueprint $table) {
            $table->string('remember_token', 100)->nullable()->after('password');
        });
    }

    public function down()
    {
        Schema::table('tbl_login', function (Blueprint $table) {
            $table->dropColumn('remember_token');
        });
    }
}
