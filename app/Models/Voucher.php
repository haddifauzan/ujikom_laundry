<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\LogAktivitasObserver;

class Voucher extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        static::observe(LogAktivitasObserver::class);
    }

    // Tentukan nama tabel jika tidak mengikuti konvensi Laravel
    protected $table = 'tbl_voucher';

    // Primary key dari tabel
    protected $primaryKey = 'id_voucher';

    // Tentukan atribut-atribut yang bisa diisi
    protected $fillable = [
        'kode_voucher',
        'deskripsi',
        'jumlah_voucher',
        'diskon_persen',
        'diskon_nominal',
        'min_subtotal_transaksi',
        'max_diskon',
        'masa_berlaku_mulai',
        'masa_berlaku_selesai',
        'min_jumlah_transaksi',
        'syarat_ketentuan',
        'gambar',
        'status', //(Aktif, Non-Aktif)
    ];

    /**
     * Format atribut menjadi tipe data yang sesuai.
     */
    protected $casts = [
        'diskon_persen' => 'float',
        'diskon_nominal' => 'float',
        'min_subtotal_transaksi' => 'float',
        'max_diskon' => 'float',
        'masa_berlaku_mulai' => 'datetime',
        'masa_berlaku_selesai' => 'datetime',
    ];

    /**
     * Scope untuk filter berdasarkan status aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter berdasarkan periode aktif voucher.
     */
    public function scopeBerlaku($query)
    {
        $now = now();
        return $query->where('masa_berlaku_mulai', '<=', $now)
                     ->where('masa_berlaku_selesai', '>=', $now);
    }

    /**
     * Cek apakah voucher masih berlaku.
     */
    public function isValid()
    {
        $now = now();
        return $this->status === 'aktif' &&
               $this->masa_berlaku_mulai <= $now &&
               $this->masa_berlaku_selesai >= $now;
    }

    public function calculateDiscount($total)
    {
        if ($this->diskon_persen) {
            $discount = ($total * $this->diskon_persen) / 100;
        } else {
            $discount = $this->diskon_nominal;
        }
        
        if ($this->max_diskon && $discount > $this->max_diskon) {
            $discount = $this->max_diskon;
        }
        
        return $discount;
    }
}
