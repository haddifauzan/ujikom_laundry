<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class LayananTambahan extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_layanan_tambahan';

    protected $primaryKey = 'id_layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'satuan', //(Per kilo, Per item)
        'harga',
        'status', //(Aktif, Non-Aktif)
    ];

    public function rincianTransaksi()
    {
        return $this->hasMany(RincianTransaksi::class, 'id_layanan', 'id_layanan');
    }

}
