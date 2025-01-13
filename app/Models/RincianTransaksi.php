<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class RincianTransaksi extends Model
{
    use HasFactory;

    protected $table = 'tbl_rincian_transaksi';
    protected $primaryKey = 'id_rincian_transaksi';

    protected $fillable = [
        'jumlah',
        'subtotal',
        'id_transaksi',
        'id_tarif',
        'id_layanan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function layananTambahan()
    {
        return $this->belongsTo(LayananTambahan::class, 'id_layanan')->withDefault();
    }

    public function tarifLaundry()
    {
        return $this->belongsTo(TarifLaundry::class, 'id_tarif')->withDefault();
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);

        static::saving(function ($model) {
            // Validasi id_tarif
            if (!is_null($model->id_tarif) && !TarifLaundry::where('id_tarif', $model->id_tarif)->exists()) {
                throw new \Exception("Tarif laundry tidak valid.");
            }

            // Validasi id_layanan
            if (!is_null($model->id_layanan) && !LayananTambahan::where('id_layanan', $model->id_layanan)->exists()) {
                throw new \Exception("Layanan tambahan tidak valid.");
            }
        });
    }
}
