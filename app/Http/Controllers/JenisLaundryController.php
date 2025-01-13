<?php

namespace App\Http\Controllers;

use App\Models\JenisLaundry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class JenisLaundryController extends Controller
{
    public function index()
    {
        $jenisLaundry = JenisLaundry::all();
        return view('admin.data-jenis.index', compact('jenisLaundry'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'deskripsi' => 'required',
            'waktu_estimasi' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $gambar = $request->file('gambar');
        $gambarName = time() . '.' . $gambar->extension();
        $gambar->move(public_path('storage/jenis-laundry'), $gambarName);

        JenisLaundry::create([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi' => $request->deskripsi,
            'waktu_estimasi' => $request->waktu_estimasi,
            'gambar' => $gambarName
        ]);

        return redirect()->route('jenis-laundry.index')->with('success', 'Jenis laundry berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jenis' => 'required',
            'deskripsi' => 'required',
            'waktu_estimasi' => 'required|numeric',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $jenisLaundry = JenisLaundry::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $oldImagePath = public_path('storage/jenis-laundry/' . $jenisLaundry->gambar);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $gambar = $request->file('gambar');
            $gambarName = time() . '.' . $gambar->extension();
            $gambar->move(public_path('storage/jenis-laundry'), $gambarName);
            $jenisLaundry->gambar = $gambarName;
        }

        $jenisLaundry->update([
            'nama_jenis' => $request->nama_jenis,
            'deskripsi' => $request->deskripsi,
            'waktu_estimasi' => $request->waktu_estimasi
        ]);

        return redirect()->route('jenis-laundry.index')->with('success', 'Jenis laundry berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $jenisLaundry = JenisLaundry::findOrFail($id);
        $imagePath = public_path('storage/jenis-laundry/' . $jenisLaundry->gambar);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $jenisLaundry->delete();

        return redirect()->route('jenis-laundry.index')->with('success', 'Jenis laundry berhasil dihapus!');
    }
}