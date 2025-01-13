<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.data-supplier.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'nohp_supplier' => 'required|numeric'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'alamat_supplier.required' => 'Alamat supplier wajib diisi',
            'nohp_supplier.required' => 'Nomor HP supplier wajib diisi',
            'nohp_supplier.numeric' => 'Nomor HP harus berupa angka'
        ]);

        Supplier::create($request->all());
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'alamat_supplier' => 'required',
            'nohp_supplier' => 'required|numeric'
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'alamat_supplier.required' => 'Alamat supplier wajib diisi',
            'nohp_supplier.required' => 'Nomor HP supplier wajib diisi',
            'nohp_supplier.numeric' => 'Nomor HP harus berupa angka'
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        // Check if supplier has related items
        if($supplier->barang()->count() > 0) {
            return redirect()->route('supplier.index')
                           ->with('error', 'Supplier tidak dapat dihapus karena masih memiliki barang terkait.');
        }

        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil dihapus!');
    }
}