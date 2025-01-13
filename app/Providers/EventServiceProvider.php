<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $observers = [
        \App\Models\User::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Barang::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\HomePageSettings::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\JenisLaundry::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Karyawan::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Konsumen::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\LayananTambahan::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\PemakaianBarang::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Pembelian::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Review::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\RincianPembelian::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\RincianTransaksi::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\StatusPesanan::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Supplier::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\TarifLaundry::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Transaksi::class => \App\Observers\LogAktivitasObserver::class,
        \App\Models\Voucher::class => \App\Observers\LogAktivitasObserver::class,
    ];

    public function boot()
    {
        parent::boot();

        // Register all observers
        foreach ($this->observers as $model => $observer) {
            $model::observe($observer);
        }
    }
}
