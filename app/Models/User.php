<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Observers\LogAktivitasObserver;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_login'; // Nama tabel

    protected $primaryKey = 'id_login'; // Primary key
    protected $fillable = [
        'email',
        'password',
        'last_login',
        'status_akun', // (Aktif, Non-Aktif)
        'role', //(Admin, Karyawan, Konsumen)
        'id_karyawan',
        'id_konsumen',
        'remember_token', // Menambahkan remember_token ke dalam fillable
    ];

    // Menambahkan relasi jika perlu
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }


    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen');
    }

    // Menyembunyikan kolom sensitive ketika model di-convert menjadi array atau JSON
    protected $hidden = [
        'password',
        'remember_token', // Menyembunyikan remember_token
    ];
}
