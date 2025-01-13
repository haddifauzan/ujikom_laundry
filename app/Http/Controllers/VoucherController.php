<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::orderBy('created_at', 'desc')->get();
        return view('admin.data-voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.data-voucher.form');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateVoucher($request);
        
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/voucher'), $filename);
            $validatedData['gambar'] = $filename;
        }

        if ($request->tipe_diskon === 'persen') {
            $validatedData['diskon_nominal'] = null;
        } else {
            $validatedData['diskon_persen'] = null;
        }

        Voucher::create($validatedData);

        return redirect()
            ->route('voucher.index')
            ->with('success', 'Voucher berhasil ditambahkan!');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.data-voucher.form', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $validatedData = $this->validateVoucher($request);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($voucher->gambar) {
                $oldPath = public_path('uploads/voucher/' . $voucher->gambar);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $gambar = $request->file('gambar');
            $filename = time() . '.' . $gambar->getClientOriginalExtension();
            $gambar->move(public_path('uploads/voucher'), $filename);
            $validatedData['gambar'] = $filename;
        }

        if ($request->tipe_diskon === 'persen') {
            $validatedData['diskon_nominal'] = null;
        } else {
            $validatedData['diskon_persen'] = null;
        }

        $voucher->update($validatedData);

        return redirect()
            ->route('voucher.index')
            ->with('success', 'Voucher berhasil diperbarui!');
    }

    public function destroy(Voucher $voucher)
    {
        if ($voucher->gambar) {
            $path = public_path('uploads/voucher/' . $voucher->gambar);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $voucher->delete();

        return redirect()
            ->route('voucher.index')
            ->with('success', 'Voucher berhasil dihapus!');
    }

    private function validateVoucher(Request $request)
    {
        return $request->validate([
            'kode_voucher' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'jumlah_voucher' => 'required|integer|min:1',
            'diskon_persen' => 'nullable|numeric|min:0|max:100',
            'diskon_nominal' => 'nullable|numeric|min:0',
            'min_subtotal_transaksi' => 'required|numeric|min:0',
            'max_diskon' => 'nullable|numeric|min:0',
            'masa_berlaku_mulai' => 'required|date',
            'masa_berlaku_selesai' => 'nullable|date|after:masa_berlaku_mulai',
            'min_jumlah_transaksi' => 'required|integer|min:0',
            'syarat_ketentuan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:Aktif,Non-Aktif',
        ]);
    }
}