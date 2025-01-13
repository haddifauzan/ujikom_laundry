<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Konsumen;
use App\Models\StatusPesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KasirDashboardController extends Controller
{
    public function index()
    {
        // Get today's date
        $today = Carbon::today();
        
        // Get authenticated user's ID
        $kasirId = auth()->user()->id_karyawan;

        // Get today's transactions count
        $todayTransactions = Transaksi::where('id_karyawan', $kasirId)
            ->whereDate('waktu_transaksi', $today)
            ->count();

        // Get today's revenue
        $todayRevenue = Transaksi::where('id_karyawan', $kasirId)
            ->whereDate('waktu_transaksi', $today)
            ->sum('subtotal');

        // Get pending orders count
        $pendingOrders = Transaksi::whereHas('statusPesanan', function($query) {
            $query->where('status', 'pending');
        })->where('id_karyawan', $kasirId)
        ->count();

        // Get total members
        $totalMembers = Konsumen::where('member', true)->count();

        // Get weekly revenue data
        $weeklyRevenue = Transaksi::where('id_karyawan', $kasirId)
            ->whereBetween('waktu_transaksi', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->select(
                DB::raw('DATE(waktu_transaksi) as date'),
                DB::raw('SUM(subtotal) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get order status distribution
        $orderStatus = StatusPesanan::whereHas('transaksi', function($query) use ($kasirId) {
            $query->where('id_karyawan', $kasirId);
        })
        ->select('status', DB::raw('COUNT(*) as total'))
        ->groupBy('status')
        ->get();

        // Get recent transactions
        $recentTransactions = Transaksi::with(['konsumen', 'statusPesanan'])
            ->where('id_karyawan', $kasirId)
            ->orderBy('waktu_transaksi', 'desc')
            ->limit(10)
            ->get();

        return view('karyawan.kasir.dashboard', compact(
            'todayTransactions',
            'todayRevenue',
            'pendingOrders',
            'totalMembers',
            'weeklyRevenue',
            'orderStatus',
            'recentTransactions'
        ));
    }

    public function getChartData()
    {
        $kasirId = auth()->user()->karyawan->id_karyawan;
        
        // Get weekly revenue data
        $weeklyRevenue = Transaksi::where('id_karyawan', $kasirId)
            ->whereBetween('waktu_transaksi', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->select(
                DB::raw('DATE(waktu_transaksi) as date'),
                DB::raw('SUM(subtotal) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get order status data
        $orderStatus = StatusPesanan::whereHas('transaksi', function($query) use ($kasirId) {
            $query->where('id_karyawan', $kasirId);
        })
        ->select('status', DB::raw('COUNT(*) as total'))
        ->groupBy('status')
        ->get();

        return response()->json([
            'weeklyRevenue' => $weeklyRevenue,
            'orderStatus' => $orderStatus
        ]);
    }
}
