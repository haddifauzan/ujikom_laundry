<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class StatusPesanan extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_status_pesanan';
    protected $primaryKey = 'id_status_pesanan';

    protected $fillable = [
        'status', // (pending, diproses, selesai, gagal)
        'keterangan',
        'waktu_perubahan',
        'id_karyawan',
        'id_transaksi',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}