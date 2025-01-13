<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class PemakaianBarang extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }


    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_pemakaian_barang';

    // Primary key dari tabel
    protected $primaryKey = 'id_pemakaian';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'id_barang',
        'jumlah',
        'waktu_pemakaian',
        'keterangan',
        'id_karyawan',
    ];

    /**
     * Relasi ke Barang (Many to One)
     * Setiap pemakaian barang terkait dengan satu barang.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi ke Karyawan (Many to One)
     * Setiap pemakaian barang terkait dengan satu karyawan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }
}
