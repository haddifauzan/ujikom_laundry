<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('supplier')->get();
        $suppliers = Supplier::all();
        return view('admin.data-barang.index', compact('barang', 'suppliers'));
    }

    private function generateKodeBarang($nama_barang)
    {
        $prefix = strtoupper(substr($nama_barang, 0, 3));
        $randomNumber = mt_rand(10000, 99999);
        return $prefix . '-' . $randomNumber;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori_barang' => 'required',
            'harga_satuan' => 'required',
            'id_supplier' => 'required|exists:tbl_supplier,id_supplier'
        ]);
    
        $harga_satuan = str_replace(['Rp ', '.', ','], '', $request->harga_satuan);
        
        $data = $request->all();
        $data['kode_barang'] = $this->generateKodeBarang($request->nama_barang);
        $data['harga_satuan'] = $harga_satuan;
        $data['stok'] = 0;
    
        Barang::create($data);
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan!');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'kategori_barang' => 'required',
            'harga_satuan' => 'required',
            'id_supplier' => 'required|exists:tbl_supplier,id_supplier'
        ]);
    
        $harga_satuan = str_replace(['Rp ', '.', ','], '', $request->harga_satuan);
        
        $barang = Barang::findOrFail($id);
        $data = $request->all();
        $data['kode_barang'] = $this->generateKodeBarang($request->nama_barang);
        $data['harga_satuan'] = $harga_satuan;
        unset($data['stok']);
    
        $barang->update($data);
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus!');
    }

    public function index_karyawan()
    {
        $barang = Barang::with('supplier')->get();
        $suppliers = Supplier::all();
        return view('karyawan.pengelola-barang.data-barang.index', compact('barang', 'suppliers'));
    }
}