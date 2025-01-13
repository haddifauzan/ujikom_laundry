<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Transaksi extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'no_transaksi',
        'waktu_transaksi',
        'diskon',
        'subtotal',
        'bayar',
        'pesan_konsumen',
        'pesan_karyawan',
        'status_transaksi',
        'id_karyawan',
        'id_konsumen',
        'id_voucher',
    ];

    public function rincianTransaksi()
    {
        return $this->hasMany(RincianTransaksi::class, 'id_transaksi' , 'id_transaksi');
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan' , 'id_karyawan');
    }

    public function konsumen()
    {
        return $this->belongsTo(Konsumen::class, 'id_konsumen', 'id_konsumen');
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class, 'id_voucher', 'id_voucher');
    }

    public function statusPesanan()
    {
        return $this->hasMany(StatusPesanan::class, 'id_transaksi', 'id_transaksi');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_voucher', 'id_voucher');
    }
}