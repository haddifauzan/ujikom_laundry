<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Pembelian extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }


    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_pembelian';

    // Primary key dari tabel
    protected $primaryKey = 'id_pembelian';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'no_pembelian',
        'waktu_pembelian',
        'total_biaya',
        'id_karyawan',
    ];

    /**
     * Relasi ke tbl_rincian_pembelian (One to Many)
     * Setiap pembelian memiliki beberapa rincian pembelian.
     */
    public function rincianPembelian()
    {
        return $this->hasMany(RincianPembelian::class, 'id_pembelian', 'id_pembelian');
    }

    /**
     * Relasi ke Karyawan (Many to One)
     * Setiap pembelian dilakukan oleh satu karyawan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
