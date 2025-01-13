<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\PemakaianBarang;
use App\Models\Pembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengelolaBarangDashboardController extends Controller
{
    public function index()
    {
        // Get total items count
        $totalItems = Barang::count();

        // Get low stock items (assuming stock below 10 is low)
        $lowStockItems = Barang::where('stok', '<', 5)->count();

        // Get today's usage count
        $todayUsage = PemakaianBarang::whereDate('waktu_pemakaian', Carbon::today())->count();

        // Get total suppliers
        $totalSuppliers = Supplier::count();

        // Get stock distribution per item
        $stockDistribution = Barang::select('nama_barang', 'stok')
            ->orderByDesc('stok')
            ->get();

        // Get most used items
        $mostUsedItems = PemakaianBarang::select('id_barang', DB::raw('SUM(jumlah) as total_usage'))
            ->with('barang:id_barang,nama_barang')
            ->groupBy('id_barang')
            ->orderByDesc('total_usage')
            ->limit(5)
            ->get();

        // Get recent activities (combined from pembelian and pemakaian)
        $recentPurchases = Pembelian::with(['karyawan', 'rincianPembelian.barang'])
            ->latest('waktu_pembelian')
            ->limit(5)
            ->get()
            ->map(function ($purchase) {
                return [
                    'waktu' => $purchase->waktu_pembelian,
                    'tipe' => 'Pembelian',
                    'barang' => $purchase->rincianPembelian->first()->barang->nama_barang,
                    'jumlah' => $purchase->rincianPembelian->first()->jumlah,
                    'karyawan' => $purchase->karyawan->nama_karyawan,
                    'status' => 'Selesai'
                ];
            });

        $recentUsage = PemakaianBarang::with(['karyawan', 'barang'])
            ->latest('waktu_pemakaian')
            ->limit(5)
            ->get()
            ->map(function ($usage) {
                return [
                    'waktu' => $usage->waktu_pemakaian,
                    'tipe' => 'Pemakaian',
                    'barang' => $usage->barang->nama_barang,
                    'jumlah' => $usage->jumlah,
                    'karyawan' => $usage->karyawan->nama_karyawan,
                    'status' => 'Selesai'
                ];
            });

        $recentActivities = $recentPurchases->concat($recentUsage)
            ->sortByDesc('waktu')
            ->take(10)
            ->values();

        return view('karyawan.pengelola-barang.dashboard', compact(
            'totalItems',
            'lowStockItems',
            'todayUsage',
            'totalSuppliers',
            'stockDistribution',
            'mostUsedItems',
            'recentActivities'
        ));
    }

    public function getChartData()
    {
        // Get stock distribution per item
        $stockDistribution = Barang::select('nama_barang', 'stok')
            ->orderByDesc('stok')
            ->get();

        // Get usage data for the past 7 days
        $itemUsage = PemakaianBarang::select('id_barang', DB::raw('SUM(jumlah) as total_usage'))
            ->with('barang:id_barang,nama_barang')
            ->whereBetween('waktu_pemakaian', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('id_barang')
            ->orderByDesc('total_usage')
            ->limit(5)
            ->get();

        return response()->json([
            'stockDistribution' => $stockDistribution,
            'itemUsage' => $itemUsage
        ]);
    }
}
