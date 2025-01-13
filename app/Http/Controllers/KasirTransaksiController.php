<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Konsumen;
use App\Models\User;
use App\Models\JenisLaundry;
use App\Models\TarifLaundry;
use App\Models\LayananTambahan;
use App\Models\Voucher;
use App\Models\Transaksi;
use App\Models\RincianTransaksi;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KasirTransaksiController extends Controller
{
    public function step1()
    {
        return view('karyawan.kasir.transaksi.step1');
    }

    public function storeKonsumen(Request $request)
{
    try {
        DB::beginTransaction();

        // Validate request
        if ($request->want_member) {
            $validated = $request->validate([
                'nama_konsumen' => 'required',
                'noHp_konsumen' => 'required|unique:tbl_konsumen,noHp_konsumen,NULL,id_konsumen,member,1',
                'email' => 'required|email|unique:tbl_login',
                'password' => 'required|min:6',
                'alamat_konsumen' => 'required'
            ]);
        } else {
            $validated = $request->validate([
                'nama_konsumen' => 'required',
                'noHp_konsumen' => 'required'
            ]);
        }

        // Generate kode konsumen
        $lastKonsumen = Konsumen::latest('id_konsumen')->first();
        $lastNumber = $lastKonsumen ? intval(substr($lastKonsumen->kode_konsumen, 3)) : 0;
        $kodeKonsumen = 'CST' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Create konsumen
        $konsumen = Konsumen::create([
            'kode_konsumen' => $kodeKonsumen,
            'nama_konsumen' => $request->nama_konsumen,
            'noHp_konsumen' => $request->noHp_konsumen,
            'alamat_konsumen' => $request->want_member ? $request->alamat_konsumen : null,
            'member' => $request->want_member ? true : false
        ]);

        if ($request->want_member) {
            // Create user account
            User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'Konsumen',
                'id_konsumen' => $konsumen->id_konsumen,
                'status_akun' => "Aktif",
                'remember_token' => Str::random(60),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'member' => true,
                'message' => 'Pendaftaran member berhasil',
                'invoice_url' => route('transaksi.member.invoice', ['id_konsumen' => $konsumen->id_konsumen]),
                'next_step_url' => route('transaksi.step2', ['id_konsumen' => $konsumen->id_konsumen])
            ], 200);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'member' => false,
            'message' => 'Data konsumen berhasil disimpan',
            'next_step_url' => route('transaksi.step2', ['id_konsumen' => $konsumen->id_konsumen])
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'status' => 'error',
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Transaction Error: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
        ], 500);
    }
}

    public function memberInvoice($id_konsumen)
    {
        $konsumen = Konsumen::findOrFail($id_konsumen);
        return view('karyawan.kasir.transaksi.member-invoice', compact('konsumen'));
    }

    public function searchKonsumen(Request $request)
    {
        $search = $request->search;
        
        $members = Konsumen::where('member', true)
            ->where(function($query) use ($search) {
                $query->where('nama_konsumen', 'LIKE', "%{$search}%")
                    ->orWhere('kode_konsumen', 'LIKE', "%{$search}%");
            })
            ->get();
            
        return response()->json($members);
    }

    public function step2($id_konsumen)
    {
        $konsumen = Konsumen::findOrFail($id_konsumen);
        $jenisLaundry = JenisLaundry::all();
        $layananTambahan = LayananTambahan::where('status', "Aktif")->get();

        return view('karyawan.kasir.transaksi.step2', compact('konsumen', 'jenisLaundry', 'layananTambahan'));
    }

    public function getTarif($id_jenis)
    {
        $tarif = TarifLaundry::with('jenisLaundry')
                            ->where('id_jenis', $id_jenis)
                            ->get();

        return response()->json($tarif);
    }


    public function getLayanan($id_layanan)
    {
        $layanan = LayananTambahan::findOrFail($id_layanan);
        return response()->json($layanan);
    }

    public function step3($id_konsumen)
    {
        $konsumen = Konsumen::findOrFail($id_konsumen);
        
        // Only fetch vouchers if customer is a member
        $vouchers = $konsumen->member ? Voucher::aktif()
            ->berlaku()
            ->where(function($query) {
                $query->where('jumlah_voucher', '>', 0)
                    ->orWhereNull('jumlah_voucher');
            })
            ->get() : collect();

        return view('karyawan.kasir.transaksi.step3', compact('konsumen', 'vouchers'));
    }

    public function checkVoucher(Request $request)
    {
        $voucher = Voucher::where('kode_voucher', $request->code)
            ->aktif()
            ->berlaku()
            ->first();

        if (!$voucher) {
            return response()->json([
                'valid' => false,
                'message' => 'Voucher tidak ditemukan atau sudah tidak berlaku'
            ]);
        }

        if ($voucher->jumlah_voucher !== null && $voucher->jumlah_voucher <= 0) {
            return response()->json([
                'valid' => false,
                'message' => 'Voucher sudah habis digunakan'
            ]);
        }

        if ($voucher->min_subtotal_transaksi && $request->subtotal < $voucher->min_subtotal_transaksi) {
            return response()->json([
                'valid' => false,
                'message' => 'Minimal transaksi belum terpenuhi'
            ]);
        }

        return response()->json([
            'valid' => true,
            'voucher' => $voucher
        ]);
    }


    public function step4($id_konsumen)
    {
        $konsumen = Konsumen::findOrFail($id_konsumen);
        
        return view('karyawan.kasir.transaksi.step4', compact('konsumen'));
    }
    
    public function processPayment(Request $request)
    {
        try {
            DB::beginTransaction();

            $cartData = json_decode($request->cart_data, true);
            $konsumen = Konsumen::find($request->id_konsumen);

            // Create transaction
            $transaction = Transaksi::create([
                'no_transaksi' => 'TRX/' . date('Ymd') . '/' . strtoupper(Str::random(5)),
                'waktu_transaksi' => now(),
                'pesan_konsumen' => $request->pesan_konsumen,
                'pesan_karyawan' => $request->pesan_karyawan,
                'subtotal' => $request->subtotal,
                'diskon' => $request->diskon ?? 0,
                'bayar' => $request->bayar,
                'status_transaksi' => 'pending',
                'id_karyawan' => auth()->user()->karyawan->id_karyawan,
                'id_konsumen' => $request->id_konsumen,
                'id_voucher' => $request->id_voucher ?? null,
            ]);

            // Create transaction details for laundry items
            foreach ($cartData['items'] as $item) {
                if (!empty($item['tarifId'])) {
                    RincianTransaksi::create([
                        'jumlah' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                        'id_transaksi' => $transaction->id_transaksi,
                        'id_tarif' => $item['tarifId'],
                        'id_layanan' => null
                    ]);
                }
            }

            // Create transaction details for additional services
            $additionalServices = [];
            foreach ($cartData['additionalServices'] as $service) {
                if (!empty($service['layananId'])) {
                    if (isset($additionalServices[$service['layananId']])) {
                        $additionalServices[$service['layananId']]['jumlah'] += 1;
                        $additionalServices[$service['layananId']]['subtotal'] += $service['harga'];
                    } else {
                        $additionalServices[$service['layananId']] = [
                            'jumlah' => 1,
                            'subtotal' => $service['harga'],
                            'id_layanan' => $service['layananId']
                        ];
                    }
                }
            }

            foreach ($additionalServices as $service) {
                if (!empty($service['id_layanan'])) {
                    RincianTransaksi::create([
                        'jumlah' => $service['jumlah'],
                        'subtotal' => $service['subtotal'],
                        'id_transaksi' => $transaction->id_transaksi,
                        'id_tarif' => null,
                        'id_layanan' => $service['id_layanan']
                    ]);
                }
            }

            // Create initial status
            StatusPesanan::create([
                'id_transaksi' => $transaction->id_transaksi,
                'status' => 'pending',
                'waktu_perubahan' => now(),
                'id_karyawan' => auth()->user()->karyawan->id_karyawan,
                'keterangan' => 'Pesanan akan diproses, mohon tunggu',
            ]);

            // If this was a member registration transaction
            if (session()->has('member_registration')) {
                $memberTransaction = Transaksi::create([
                    'no_transaksi' => 'MEMBER/' . date('Ymd') . '/' . strtoupper(Str::random(5)),
                    'waktu_transaksi' => now(),
                    'status_transaksi' => 'completed',
                    'id_karyawan' => auth()->user()->karyawan->id_karyawan,
                    'id_konsumen' => $request->id_konsumen
                ]);

                // Add member registration fee to transaction details
                $registrationFee = 100000; // Biaya pendaftaran member
                RincianTransaksi::create([
                    'jumlah' => 1,
                    'subtotal' => $registrationFee,
                    'id_transaksi' => $memberTransaction->id_transaksi,
                    'id_tarif' => null, 
                    'id_layanan' => null
                ]);

                // Add the registration fee to the main transaction as well
                RincianTransaksi::create([
                    'jumlah' => 1,
                    'subtotal' => $registrationFee,
                    'id_transaksi' => $transaction->id_transaksi,
                    'id_tarif' => null,
                    'id_layanan' => null
                ]);

                session()->forget('member_registration');
            }

            DB::commit();

            return redirect()->route('kasir.transaksi.invoice', $transaction->id_transaksi)
                ->with('success', 'Transaksi berhasil diproses!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function invoice($id_transaksi)
    {

        $transaksi = Transaksi::with([
            'rincianTransaksi.tarifLaundry.jenisLaundry',
            'rincianTransaksi.layananTambahan',
            'konsumen',
            'karyawan',
            'voucher'
        ])->findOrFail($id_transaksi);

        return view('karyawan.kasir.transaksi.invoice', compact('transaksi'));
    }
    
}