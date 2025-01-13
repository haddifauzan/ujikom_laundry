<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Barang extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_barang';

    // Primary key dari tabel
    protected $primaryKey = 'id_barang';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_barang', //(Detergen dan Bahan Kimia, Mesin dan Peralatan, Perlengkapan Laundry, Sparepart dan Aksesoris Mesin, Pakaian dan Seragam)
        'stok',
        'harga_satuan',
        'id_supplier',
    ];

    /**
     * Relasi ke tbl_supplier (Many to One)
     * Barang ini dimiliki oleh satu supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    /**
     * Relasi ke tbl_pemakaian_barang (One to Many)
     * Barang ini mungkin digunakan dalam banyak transaksi pemakaian barang.
     */
    public function pemakaianBarang()
    {
        return $this->hasMany(PemakaianBarang::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi ke tbl_rincian_pembelian (One to Many)
     * Barang ini mungkin terdaftar dalam beberapa rincian pembelian.
     */
    public function rincianPembelian()
    {
        return $this->hasMany(RincianPembelian::class, 'id_barang', 'id_barang');
    }
}
