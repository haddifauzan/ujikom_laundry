<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Karyawan extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    protected $table = 'tbl_karyawan';

    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nik',
        'kode_karyawan',
        'nama_karyawan',
        'noHp_karyawan',
        'gender_karyawan', //(L, P)
        'foto_karyawan',
        'status_karyawan' //(kasir, pengelola barang)
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_karyawan', 'id_karyawan');
    }

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'id_karyawan', 'id_karyawan');
    }

    public function pemakaianBarang()
    {
        return $this->hasMany(PemakaianBarang::class, 'id_karyawan', 'id_karyawan');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_karyawan', 'id_karyawan');
    }
}