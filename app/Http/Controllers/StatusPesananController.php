<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;

class StatusPesananController extends Controller
{
    public function index()
    {
        $pesanan = Transaksi::with(['konsumen', 'statusPesanan'])
            ->where('id_karyawan', auth()->user()->id_karyawan)
            ->orderBy('waktu_transaksi', 'desc')
            ->get();
            
        return view('karyawan.kasir.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Transaksi::with([
            'konsumen', 
            'statusPesanan', 
            'rincianTransaksi.tarifLaundry.jenisLaundry',
            'rincianTransaksi.layananTambahan'
        ])->findOrFail($id);        
        
        return view('karyawan.kasir.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,batal',
            'keterangan' => 'required|string',
        ]);

        // Tambahkan data ke tabel StatusPesanan
        StatusPesanan::create([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            'waktu_perubahan' => now(),
            'id_karyawan' => auth()->user()->id_karyawan,
            'id_transaksi' => $id,
        ]);

        // Hanya ubah status_transaksi jika status bukan "selesai"
        if ($request->status !== 'selesai') {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->status_transaksi = $request->status;
            $transaksi->save();
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
    }

}
