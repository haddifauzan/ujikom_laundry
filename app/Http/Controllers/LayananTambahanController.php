<?php

namespace App\Http\Controllers;

use App\Models\LayananTambahan;
use Illuminate\Http\Request;

class LayananTambahanController extends Controller
{
    public function index()
    {
        $layananTambahan = LayananTambahan::all();
        return view('admin.data-layanan.index', compact('layananTambahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        LayananTambahan::create($request->all());

        return redirect()->route('layanan-tambahan.index')
            ->with('success', 'Layanan tambahan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $layanan = LayananTambahan::findOrFail($id);
        $layanan->update($request->all());

        return redirect()->route('layanan-tambahan.index')
            ->with('success', 'Layanan tambahan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $layanan = LayananTambahan::findOrFail($id);
        $layanan->delete();

        return redirect()->route('layanan-tambahan.index')
            ->with('success', 'Layanan tambahan berhasil dihapus!');
    }
}