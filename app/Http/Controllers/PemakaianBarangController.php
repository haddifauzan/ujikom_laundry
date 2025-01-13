<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PemakaianBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use DB;

class PemakaianBarangController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $idBarang = $request->id_barang;

        $pemakaianBarang = PemakaianBarang::with(['barang', 'karyawan'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('waktu_pemakaian', [$startDate, $endDate]);
            })
            ->when($idBarang, function ($query, $idBarang) {
                return $query->where('id_barang', $idBarang);
            })
            ->orderBy('waktu_pemakaian', 'desc')
            ->get();

        $barangs = Barang::all(); // Untuk opsi dropdown filter

        return view('karyawan.pengelola-barang.pemakaian-barang.index', compact('pemakaianBarang', 'barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:tbl_barang,id_barang',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
            'waktu_pemakaian' => 'required|date',
        ]);

        $barang = Barang::find($request->id_barang);
        
        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        // Kurangi stok barang
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Simpan pemakaian barang
        PemakaianBarang::create([
            'id_barang' => $request->id_barang,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'waktu_pemakaian' => $request->waktu_pemakaian,
            'id_karyawan' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Pemakaian barang berhasil dicatat');
    }

    public function getLaporanByDateRange(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $pemakaian = PemakaianBarang::with(['barang', 'karyawan'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('waktu_pemakaian', [$startDate, $endDate]);
            })
            ->orderBy('waktu_pemakaian', 'desc')
            ->get();

        return response()->json($pemakaian);
    }

    public function getLaporanByBarang(Request $request)
    {
        $idBarang = $request->id_barang;

        $pemakaian = PemakaianBarang::with(['barang', 'karyawan'])
            ->when($idBarang, function ($query, $idBarang) {
                return $query->where('id_barang', $idBarang);
            })
            ->orderBy('waktu_pemakaian', 'desc')
            ->get();

        return response()->json($pemakaian);
    }


    public function cetakLaporan(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $idBarang = $request->id_barang;

        // Query data pemakaian barang
        $pemakaianBarang = PemakaianBarang::with(['barang', 'karyawan'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('waktu_pemakaian', [$startDate, $endDate]);
            })
            ->when($idBarang, function ($query, $idBarang) {
                return $query->where('id_barang', $idBarang);
            })
            ->orderBy('waktu_pemakaian', 'desc')
            ->get();

        // Data barang yang dipilih untuk filter
        $selectedBarang = $idBarang ? Barang::find($idBarang) : null;

        // Ringkasan total pemakaian barang
        $totalPemakaian = PemakaianBarang::select('id_barang', DB::raw('SUM(jumlah) as total_jumlah'))
            ->with('barang')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('waktu_pemakaian', [$startDate, $endDate]);
            })
            ->when($idBarang, function ($query, $idBarang) {
                return $query->where('id_barang', $idBarang);
            })
            ->groupBy('id_barang')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_barang' => $item->barang->nama_barang,
                    'total_jumlah' => $item->total_jumlah,
                ];
            });

        // Generate PDF
        $pdf = PDF::loadView('karyawan.pengelola-barang.pemakaian-barang.laporan', compact(
            'pemakaianBarang',
            'startDate',
            'endDate',
            'selectedBarang',
            'totalPemakaian'
        ));

        return $pdf->stream('laporan-pemakaian-barang.pdf');
    }

    
}