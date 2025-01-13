<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Karyawan;
use Carbon\Carbon;
use PDF;

class LaporanTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['konsumen', 'karyawan', 'rincianTransaksi', 'voucher']);
        
        // Filter Periode
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('waktu_transaksi', [$startDate, $endDate]);
        }
        
        // Filter Status
        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }
        
        // Filter Karyawan
        if ($request->filled('karyawan')) {
            $query->where('id_karyawan', $request->karyawan);
        }

        $transaksi = $query->orderBy('waktu_transaksi', 'desc')->get();
        $totalPendapatan = $transaksi->sum('subtotal');

        // Ambil Data Karyawan
        $karyawan = Karyawan::select('id_karyawan', 'nama_karyawan')
            ->orderBy('nama_karyawan', 'asc')
            ->get();

        return view('admin.laporan.transaksi.index', compact('transaksi', 'totalPendapatan', 'karyawan'));
    }

    public function detail($id)
    {
        $transaksi = Transaksi::with([
            'rincianTransaksi.tarifLaundry',
            'rincianTransaksi.layananTambahan',
            'konsumen',
            'karyawan',
            'voucher'
        ])->findOrFail($id);
        
        return view('admin.laporan.transaksi.detail', compact('transaksi'));
    }

    public function print(Request $request)
    {
        $data = $this->getFilteredData($request);
        return view('admin.laporan.transaksi.print', $data);
    }

    private function getFilteredData($request)
    {
        $query = Transaksi::with(['konsumen', 'karyawan', 'rincianTransaksi', 'voucher']);
        
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('waktu_transaksi', [$startDate, $endDate]);
        }
        
        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }
        
        if ($request->filled('karyawan')) {
            $query->where('id_karyawan', $request->karyawan);
        }

        $transaksi = $query->orderBy('waktu_transaksi', 'desc')->get();
        $totalPendapatan = $transaksi->sum('subtotal');

        return compact('transaksi', 'totalPendapatan');
    }
}
