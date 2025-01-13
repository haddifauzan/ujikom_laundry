<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class TarifLaundry extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_tarif_laundry';

    protected $primaryKey = 'id_tarif';

    protected $fillable = [
        'jenis_tarif', // satuan, jenis pakaian (jika satuan, maka nama pakaian null, jika jenis pakaian, maka satuan null)
        'satuan', // isinya Per Kilo 
        'nama_pakaian', // isinya jenis_pakaian
        'tarif',
        'id_jenis',
    ];

    /**
     * Relasi dengan model JenisLaundry.
     * Tarif laundry memiliki satu jenis laundry.
     */
    public function jenisLaundry()
    {
        return $this->belongsTo(JenisLaundry::class, 'id_jenis', 'id_jenis');
    }

    public function rincianTransaksi()
    {
        return $this->hasMany(RincianTransaksi::class, 'id_tarif');
    }
}
