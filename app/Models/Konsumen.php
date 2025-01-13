<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Konsumen extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_konsumen';

    // Tentukan primary key dari tabel
    protected $primaryKey = 'id_konsumen';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'kode_konsumen',
        'nama_konsumen',
        'alamat_konsumen',
        'noHp_konsumen',
        'member' //boolean
    ];

    // Jika Anda ingin menambahkan relasi, misalnya dengan model Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_konsumen', 'id_konsumen');
    }
}