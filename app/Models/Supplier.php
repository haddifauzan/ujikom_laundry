<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Supplier extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_supplier';

    // Primary key dari tabel
    protected $primaryKey = 'id_supplier';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'nama_supplier',
        'alamat_supplier',
        'nohp_supplier',
    ];

    /**
     * Relasi ke tbl_barang (One to Many)
     * Satu supplier dapat menyediakan banyak barang.
     */
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_supplier', 'id_supplier');
    }
}
