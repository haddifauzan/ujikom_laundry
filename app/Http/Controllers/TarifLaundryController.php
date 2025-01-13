<?php

namespace App\Http\Controllers;

use App\Models\TarifLaundry;
use App\Models\JenisLaundry;
use Illuminate\Http\Request;

class TarifLaundryController extends Controller
{
    public function index()
    {
        $tarifLaundry = TarifLaundry::with('jenisLaundry')->get();
        $jenisLaundry = JenisLaundry::all();
        return view('admin.data-tarif.index', compact('tarifLaundry', 'jenisLaundry'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_tarif' => 'required|in:satuan,jenis pakaian',
            'satuan' => 'required_if:jenis_tarif,satuan',
            'nama_pakaian' => 'required_if:jenis_tarif,jenis pakaian',
            'tarif' => 'required|numeric',
            'id_jenis' => 'required|exists:tbl_jenis_laundry,id_jenis'
        ]);

        // Bersihkan field yang tidak digunakan berdasarkan jenis tarif
        $data = $request->all();
        if ($request->jenis_tarif === 'satuan') {
            $data['nama_pakaian'] = null;
        } else {
            $data['satuan'] = null;
        }

        TarifLaundry::create($data);

        return redirect()->route('tarif-laundry.index')
            ->with('success', 'Tarif laundry berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_tarif' => 'required|in:satuan,jenis pakaian',
            'satuan' => 'required_if:jenis_tarif,satuan',
            'nama_pakaian' => 'required_if:jenis_tarif,jenis pakaian',
            'tarif' => 'required|numeric',
            'id_jenis' => 'required|exists:tbl_jenis_laundry,id_jenis'
        ]);

        $tarifLaundry = TarifLaundry::findOrFail($id);
        
        // Bersihkan field yang tidak digunakan berdasarkan jenis tarif
        $data = $request->all();

        if ($request->jenis_tarif === 'satuan') {
            $data['nama_pakaian'] = null;
        } else {
            $data['satuan'] = null;
        }

        $tarifLaundry->update($data);

        return redirect()->route('tarif-laundry.index')
            ->with('success', 'Tarif laundry berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tarifLaundry = TarifLaundry::findOrFail($id);
        $tarifLaundry->delete();

        return redirect()->route('tarif-laundry.index')
            ->with('success', 'Tarif laundry berhasil dihapus');
    }
}