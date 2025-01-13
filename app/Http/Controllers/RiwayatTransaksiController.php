<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use DataTables;

class RiwayatTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['konsumen', 'statusPesanan'])
            ->where('id_karyawan', auth()->user()->id_karyawan)
            ->where('status_transaksi', 'selesai');

        // Apply filters
        if ($request->startDate) {
            $query->whereDate('waktu_transaksi', '>=', $request->startDate);
        }

        if ($request->endDate) {
            $query->whereDate('waktu_transaksi', '<=', $request->endDate);
        }

        if ($request->statusPesanan) {
            $query->whereHas('statusPesanan', function($q) use ($request) {
                $q->where('status', $request->statusPesanan)
                ->whereIn('id_status_pesanan', function($subquery) {
                    $subquery->select(\DB::raw('MAX(id_status_pesanan)'))
                            ->from('tbl_status_pesanan')
                            ->groupBy('id_transaksi');
                });
            });
        }

        if ($request->minTotal) {
            $query->whereRaw('(subtotal - diskon) >= ?', [$request->minTotal]);
        }

        $transaksis = $query->orderBy('waktu_transaksi', 'desc')->get();

        return view('karyawan.kasir.riwayat.index', compact('transaksis', 'request'));
    }

    // Method lainnya tetap sama seperti sebelumnya
    public function detail($id)
    {
        $pesanan = Transaksi::with([
            'konsumen', 
            'statusPesanan', 
            'rincianTransaksi.tarifLaundry.jenisLaundry',
            'rincianTransaksi.layananTambahan'
        ])->findOrFail($id);        
        
        return view('karyawan.kasir.riwayat.detail', compact('pesanan'));
    }

    public function print(Request $request)
    {
        $karyawan = Karyawan::find(auth()->user()->karyawan->id_karyawan);
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $statusPesanan = $request->input('statusPesanan');
        $minTotal = $request->input('minTotal');

        $query = Transaksi::query();

        // Memfilter berdasarkan status transaksi
        if ($statusPesanan) {
            // Filter berdasarkan status tertentu ("selesai" atau "gagal")
            $query->where('status_transaksi', $statusPesanan);
        } else {
            // Tampilkan semua data dengan status "selesai" atau "gagal"
            $query->whereIn('status_transaksi', ['selesai', 'gagal']);
        }
        

        // Memfilter berdasarkan tanggal jika ada
        if ($startDate) {
            $query->whereDate('waktu_transaksi', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('waktu_transaksi', '<=', $endDate);
        }

        // Memfilter berdasarkan minimum total jika ada
        if ($minTotal) {
            $query->whereRaw('(subtotal - diskon) >= ?', [$minTotal]);
        }

        $transaksis = $query->get();
        
        // Menghitung total transaksi dan pendapatan
        $totalTransaksi = $transaksis->count();
        $totalTransaksiSelesai = $transaksis->where('status_transaksi', 'selesai')->count();
        $totalTransaksiGagal = $transaksis->where('status_transaksi', 'gagal')->count();
        $totalPendapatan = $transaksis->sum(function($transaksi) {
            return $transaksi->subtotal - $transaksi->diskon;
        });

        return view('karyawan.kasir.riwayat.print', compact(
            'transaksis', 
            'totalTransaksi',
            'totalTransaksiSelesai', 
            'totalTransaksiGagal', 
            'totalPendapatan', 
            'startDate', 
            'endDate', 
            'karyawan'
        ));
    }
}