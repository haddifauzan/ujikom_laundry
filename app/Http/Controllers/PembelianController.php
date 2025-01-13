<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\RincianPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar
        $query = Pembelian::with(['karyawan', 'rincianPembelian.barang']);

        // Filter periode
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('waktu_pembelian', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter range biaya
        if ($request->min_biaya && $request->max_biaya) {
            $query->whereBetween('total_biaya', [$request->min_biaya, $request->max_biaya]);
        }

        // Filter barang spesifik
        if ($request->id_barang) {
            $query->whereHas('rincianPembelian', function($q) use ($request) {
                $q->where('id_barang', $request->id_barang);
            });
        }

        $pembelian = $query->orderBy('waktu_pembelian', 'desc')->get();
        $barang = Barang::select('id_barang', 'kode_barang', 'nama_barang', 'harga_satuan')
            ->where('stok', '>=', 0)
            ->get();

        // Generate nomor pembelian
        $lastPembelian = Pembelian::orderBy('id_pembelian', 'desc')->first();
        $nomorPembelian = 'PB' . date('Ymd') . sprintf('%04d', 
            $lastPembelian ? (intval(substr($lastPembelian->no_pembelian, -4)) + 1) : 1
        );

        return view('karyawan.pengelola-barang.barang-masuk.index', compact(
            'pembelian', 
            'barang', 
            'nomorPembelian'
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate request
            $request->validate([
                'no_pembelian' => 'required|unique:tbl_pembelian',
                'waktu_pembelian' => 'required|date',
                'total_biaya' => 'required|numeric|min:0',
                'barang' => 'required|array',
                'jumlah' => 'required|array',
                'subtotal' => 'required|array',
            ]);

            // Create pembelian
            $pembelian = Pembelian::create([
                'no_pembelian' => $request->no_pembelian,
                'waktu_pembelian' => $request->waktu_pembelian,
                'total_biaya' => $request->total_biaya,
                'id_karyawan' => auth()->id(),
            ]);

            // Create rincian pembelian
            foreach ($request->barang as $index => $idBarang) {
                RincianPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_barang' => $idBarang,
                    'jumlah' => $request->jumlah[$index],
                    'subtotal' => $request->subtotal[$index],
                ]);

                // Update stok barang
                $barang = Barang::find($idBarang);
                $barang->update([
                    'stok' => $barang->stok + $request->jumlah[$index]
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pembelian = Pembelian::with(['karyawan', 'rincianPembelian.barang'])
            ->findOrFail($id);
            
        return view('karyawan.pengelola-barang.components.detail-pembelian', compact('pembelian'));
    }

    public function cetakInvoice($id)
    {
        $pembelian = Pembelian::with(['karyawan', 'rincianPembelian.barang'])
            ->findOrFail($id);
            
        return view('karyawan.pengelola-barang.components.invoice-pembelian', compact('pembelian'));
    }

    public function cetakLaporan(Request $request)
    {
        // Query dasar
        $query = Pembelian::with(['karyawan', 'rincianPembelian.barang']);

        // Filter periode
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('waktu_pembelian', [
                $request->start_date . ' 00:00:00', 
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter range biaya
        if ($request->min_biaya && $request->max_biaya) {
            $query->whereBetween('total_biaya', [$request->min_biaya, $request->max_biaya]);
        }

        // Filter barang spesifik
        if ($request->id_barang) {
            $query->whereHas('rincianPembelian', function($q) use ($request) {
                $q->where('id_barang', $request->id_barang);
            });
        }

        $pembelian = $query->orderBy('waktu_pembelian', 'desc')->get();

        // Hitung total per barang
        $totalPerBarang = RincianPembelian::with('barang')
            ->whereIn('id_pembelian', $pembelian->pluck('id_pembelian'))
            ->select('id_barang', 
                DB::raw('SUM(jumlah) as total_jumlah'), 
                DB::raw('SUM(subtotal) as total_biaya'))
            ->groupBy('id_barang')
            ->get();

        $pdf = PDF::loadView('karyawan.pengelola-barang.barang-masuk.laporan', [
            'pembelian' => $pembelian,
            'totalPerBarang' => $totalPerBarang,
            'filterInfo' => [
                'startDate' => $request->start_date,
                'endDate' => $request->end_date,
                'minBiaya' => $request->min_biaya,
                'maxBiaya' => $request->max_biaya,
                'barang' => $request->id_barang ? Barang::find($request->id_barang) : null
            ]
        ]);

        return $pdf->stream('laporan-pembelian-barang.pdf');
    }
}