<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\PemakaianBarang;
use App\Models\Pembelian;
use App\Models\RincianPembelian;
use App\Models\Supplier;
use Carbon\Carbon;
use PDF;

class LaporanBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with(['supplier', 'pemakaianBarang', 'rincianPembelian']);

        // Filter by date range if provided
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();

            $query->whereHas('pemakaianBarang', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('waktu_pemakaian', [$startDate, $endDate]);
            });
        }

        // Filter by category if provided
        if ($request->filled('kategori')) {
            $query->where('kategori_barang', $request->kategori);
        }

        // Filter by supplier if provided
        if ($request->filled('supplier')) {
            $query->where('id_supplier', $request->supplier);
        }

        // Get filtered barang
        $barang = $query->get();

        // Fetch distinct categories from barang
        $categories = Barang::select('kategori_barang')->distinct()->pluck('kategori_barang');

        // Fetch all suppliers
        $suppliers = Supplier::all();

        return view('admin.laporan.barang.index', compact('barang', 'categories', 'suppliers'));
    }


    public function print(Request $request)
    {
        $barang = $this->getFilteredData($request);
        return view('admin.laporan.barang.print', compact('barang'));
    }

    private function getFilteredData($request)
    {
        // Similar filtering logic as index method
        $query = Barang::with(['supplier', 'pemakaianBarang', 'rincianPembelian']);
        
        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            
            $query->whereHas('pemakaianBarang', function($q) use ($startDate, $endDate) {
                $q->whereBetween('waktu_pemakaian', [$startDate, $endDate]);
            });
        }
        
        if ($request->filled('kategori')) {
            $query->where('kategori_barang', $request->kategori);
        }
        
        if ($request->filled('supplier')) {
            $query->where('id_supplier', $request->supplier);
        }

        return $query->get();
    }
}