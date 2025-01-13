<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class JenisLaundry extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_jenis_laundry';

    protected $primaryKey = 'id_jenis';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'waktu_estimasi', // per hari
        'gambar',
    ];

    /**
     * Relasi dengan model TarifLaundry.
     * Satu jenis laundry memiliki banyak tarif.
     */
    public function tarif()
    {
        return $this->hasMany(TarifLaundry::class, 'id_jenis', 'id_jenis');
    }
}
