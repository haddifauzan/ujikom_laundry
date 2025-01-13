<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\JenisLaundry;
use App\Models\Karyawan;
use App\Models\Konsumen;
use App\Models\Transaksi;
use App\Models\TarifLaundry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function updateAccount(Request $request)
    {
        $request->validate([
            'new_email' => 'nullable|email|unique:tbl_login,email', // Email opsional
            'new_password' => 'nullable|min:6', // Password opsional
        ]);

        $user = Auth::user(); // Mendapatkan user yang sedang login

        // Update email jika ada
        if ($request->filled('new_email')) {
            $user->email = $request->new_email;
        }

        // Update password jika ada
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save(); // Simpan perubahan

        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    public function index()
    {
        $today = Carbon::now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();
        $startOfYear = $today->copy()->startOfYear();

        // Quick Stats
        $totalKonsumen = Konsumen::count();
        $konsumenBulanIni = Konsumen::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        
        $totalPendapatan = Transaksi::sum('subtotal');
        $pendapatanBulanIni = Transaksi::whereBetween('waktu_transaksi', [$startOfMonth, $endOfMonth])
            ->sum('subtotal');
            
        $totalTransaksi = Transaksi::count();
        $transaksiBulanIni = Transaksi::whereBetween('waktu_transaksi', [$startOfMonth, $endOfMonth])->count();
        
        $totalMember = Konsumen::where('member', true)->count();
        $memberBulanIni = Konsumen::where('member', true)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Chart Data
        $chartData = $this->generateChartData($startOfYear);

        // Performa Karyawan
        $performaKaryawan = $this->getPerformaKaryawan($startOfMonth, $endOfMonth);

        // Stok Menipis
        $stokMenipis = Barang::where('stok', '<=', 10)
            ->orderBy('stok', 'asc')
            ->limit(5)
            ->get();

        // Transaksi Terbaru
        $transaksiTerbaru = Transaksi::with(['konsumen', 'rincianTransaksi.tarifLaundry'])
            ->orderBy('waktu_transaksi', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalKonsumen',
            'konsumenBulanIni',
            'totalPendapatan',
            'pendapatanBulanIni',
            'totalTransaksi',
            'transaksiBulanIni',
            'totalMember',
            'memberBulanIni',
            'chartData',
            'performaKaryawan',
            'stokMenipis',
            'transaksiTerbaru'
        ));
    }

    private function generateChartData($startOfYear)
    {
        // Generate monthly revenue data
        $monthlyRevenue = Transaksi::select(
            DB::raw('MONTH(waktu_transaksi) as month'),
            DB::raw('SUM(subtotal) as total_revenue')
        )
        ->whereYear('waktu_transaksi', $startOfYear->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $labels = [];
        $revenue = [];
        
        // Fill in data for all months
        for ($month = 1; $month <= 12; $month++) {
            $labels[] = Carbon::create()->month($month)->format('F');
            $monthData = $monthlyRevenue->firstWhere('month', $month);
            $revenue[] = $monthData ? $monthData->total_revenue : 0;
        }

        // Generate laundry type distribution data
        $laundryTypes = JenisLaundry::withCount([
            'tarif as total_orders' => function ($query) use ($startOfYear) {
                $query->whereHas('rincianTransaksi', function ($rincianQuery) use ($startOfYear) {
                    $rincianQuery->whereYear('created_at', $startOfYear->year);
                });
            },
        ])->get();
        

        $typeLabels = $laundryTypes->pluck('nama_jenis')->toArray();
        $typeData = $laundryTypes->pluck('total_orders')->toArray();

        return [
            'labels' => $labels,
            'revenue' => $revenue,
            'typeLabels' => $typeLabels,
            'typeData' => $typeData
        ];
    }

    private function getPerformaKaryawan($startOfMonth, $endOfMonth)
    {
        return Karyawan::select(
            'tbl_karyawan.id_karyawan',
            'tbl_karyawan.nama_karyawan',
            DB::raw('COUNT(tbl_transaksi.id_transaksi) as total_transaksi'),
            DB::raw('SUM(tbl_transaksi.subtotal) as total_pendapatan'),
            DB::raw('COALESCE(AVG(
                CASE 
                    WHEN tbl_transaksi.status_transaksi = "selesai" THEN 5
                    WHEN tbl_transaksi.status_transaksi = "diproses" THEN 3
                    ELSE 1
                END
            ), 0) as rating')
        )
        ->leftJoin('tbl_transaksi', 'tbl_karyawan.id_karyawan', '=', 'tbl_transaksi.id_karyawan')
        ->whereBetween('tbl_transaksi.waktu_transaksi', [$startOfMonth, $endOfMonth])
        ->groupBy('tbl_karyawan.id_karyawan', 'tbl_karyawan.nama_karyawan')
        ->orderBy('total_transaksi', 'desc')
        ->limit(5)
        ->get();
    }


    public function getMonthlyComparison()
    {
        $lastMonth = Carbon::now()->subMonth();
        $currentMonth = Carbon::now();

        $lastMonthData = $this->getMonthlyStats($lastMonth);
        $currentMonthData = $this->getMonthlyStats($currentMonth);

        $percentageChange = [
            'revenue' => $this->calculatePercentageChange(
                $lastMonthData['revenue'],
                $currentMonthData['revenue']
            ),
            'transactions' => $this->calculatePercentageChange(
                $lastMonthData['transactions'],
                $currentMonthData['transactions']
            ),
            'customers' => $this->calculatePercentageChange(
                $lastMonthData['new_customers'],
                $currentMonthData['new_customers']
            ),
        ];

        return [
            'lastMonth' => $lastMonthData,
            'currentMonth' => $currentMonthData,
            'percentageChange' => $percentageChange
        ];
    }

    private function getMonthlyStats($date)
    {
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        return [
            'revenue' => Transaksi::whereBetween('waktu_transaksi', [$startOfMonth, $endOfMonth])
                ->sum('subtotal'),
            'transactions' => Transaksi::whereBetween('waktu_transaksi', [$startOfMonth, $endOfMonth])
                ->count(),
            'new_customers' => Konsumen::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count(),
        ];
    }

    private function calculatePercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }
        
        return (($newValue - $oldValue) / $oldValue) * 100;
    }

}
