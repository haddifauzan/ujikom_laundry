<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_login')->insert([
            'email' => 'admin@example.com', // Ganti dengan email admin yang diinginkan
            'password' => Hash::make('admin123'), // Ganti dengan password yang aman
            'last_login' => now(),
            'status_akun' => true,
            'role' => 'Admin',
            'id_konsumen' => null,
            'id_karyawan' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
