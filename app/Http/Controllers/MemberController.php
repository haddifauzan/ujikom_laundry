<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\Transaksi;

class MemberController extends Controller
{
    public function vouchers()
    {
        $vouchers = Voucher::aktif()
            ->berlaku()
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('landing.member.vouchers', compact('vouchers'));
    }

    public function orderTracking(Request $request)
    {
        $order = null;
        $message = '';
        
        if ($request->has('order_number')) {
            $order = Transaksi::with([
                'konsumen',
                'statusPesanan' => function($query) {
                    $query->orderBy('waktu_perubahan', 'asc');
                },
                'rincianTransaksi.tarifLaundry.jenisLaundry',
                'rincianTransaksi.layananTambahan'
            ])->where('no_transaksi', $request->order_number)
            ->first();
            
            if (!$order) {
                $message = 'Order number not found. Please check and try again.';
            }
        }
        
        return view('landing.member.tracking', compact('order', 'message'));
    }

    public function transactions()
    {
        $userId = auth()->user()->konsumen->id_konsumen;
        
        // Get ongoing transactions (not completed)
        $ongoingTransactions = Transaksi::with([
            'rincianTransaksi.tarifLaundry.jenisLaundry',
            'rincianTransaksi.layananTambahan',
        ])
        ->where('id_konsumen', $userId)
        ->whereNotIn('status_transaksi', ['selesai']) // Get all except completed
        ->orderBy('waktu_transaksi', 'desc')
        ->get();

        // Get completed transactions
        $completedTransactions = Transaksi::with([
            'rincianTransaksi.tarifLaundry.jenisLaundry',
            'rincianTransaksi.layananTambahan',
        ])
        ->where('id_konsumen', $userId)
        ->where('status_transaksi', 'selesai')
        ->orderBy('waktu_transaksi', 'desc')
        ->get();

        return view('landing.member.history', compact('ongoingTransactions', 'completedTransactions'));
    }

}
