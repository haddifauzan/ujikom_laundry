<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class RincianPembelian extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_rincian_pembelian';

    // Primary key dari tabel
    protected $primaryKey = 'id_rincian_pembelian';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'jumlah',
        'subtotal',
        'id_pembelian',
        'id_barang',
    ];

    /**
     * Relasi ke Pembelian (Many to One)
     * Setiap rincian pembelian terkait dengan satu pembelian.
     */
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id_pembelian');
    }

    /**
     * Relasi ke Barang (Many to One)
     * Setiap rincian pembelian terkait dengan satu barang.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
