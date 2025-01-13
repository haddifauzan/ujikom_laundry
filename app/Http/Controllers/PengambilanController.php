<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengambilanController extends Controller
{
    public function index()
    {
        // Get all transactions where the latest status_pesanan is 'selesai'
        $transaksis = Transaksi::whereHas('statusPesanan', function($query) {
            $query->where('status', 'selesai')
                  ->whereIn('id_status_pesanan', function($subquery) {
                      $subquery->select(\DB::raw('MAX(id_status_pesanan)'))
                              ->from('tbl_status_pesanan')
                              ->groupBy('id_transaksi');
                  });
        })->get();

        return view('karyawan.kasir.pengambilan.index', compact('transaksis'));
    }

    public function verifyQR(Request $request)
    {
        $transaksi = Transaksi::where('no_transaksi', $request->no_transaksi)
            ->whereHas('statusPesanan', function($query) {
                $query->where('status', 'selesai')
                      ->whereIn('id_status_pesanan', function($subquery) {
                          $subquery->select(\DB::raw('MAX(id_status_pesanan)'))
                                  ->from('tbl_status_pesanan')
                                  ->groupBy('id_transaksi');
                      });
            })
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan atau belum selesai diproses'
            ]);
        }

        if ($transaksi->status_transaksi === 'selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi sudah selesai'
            ]);
        }

        // Update transaction status
        $transaksi->status_transaksi = 'selesai';
        $transaksi->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diselesaikan'
        ]);
    }

    public function complete(Request $request)
    {
        $transaksi = Transaksi::findOrFail($request->id_transaksi);

        // Check if the latest status is 'selesai'
        $latestStatus = $transaksi->statusPesanan()->latest('id_status_pesanan')->first();
        
        if ($latestStatus->status !== 'selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum selesai diproses'
            ]);
        }

        if ($transaksi->status_transaksi === 'selesai') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi sudah selesai'
            ]);
        }

        // Update transaction status
        $transaksi->status_transaksi = 'selesai';
        $transaksi->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil diselesaikan'
        ]);
    }
}