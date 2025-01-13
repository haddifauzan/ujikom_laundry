<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('user')->get();

        $countKaryawan = $karyawan->count();
        $countLakiLaki = $karyawan->where('gender_karyawan', 'L')->count();
        $countPerempuan = $karyawan->where('gender_karyawan', 'P')->count();
        $countKasir = $karyawan->where('status_karyawan', 'kasir')->count();
        $countPengelola = $karyawan->where('status_karyawan', 'pengelola barang')->count();
        $countKaryawanAktif = $karyawan->filter(function ($k) {
            return $k->user && $k->user->status_akun == 'Aktif';
        })->count();

        return view('admin.data-karyawan.index', compact(
            'karyawan', 
            'countKaryawan', 
            'countLakiLaki', 
            'countPerempuan', 
            'countKasir', 
            'countPengelola', 
            'countKaryawanAktif'
        ));
    }

    public function create()
    {
        return view('admin.data-karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:tbl_karyawan',
            'nama_karyawan' => 'required',
            'noHp_karyawan' => 'required',
            'gender_karyawan' => 'required',
            'foto_karyawan' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status_karyawan' => 'required',
            'email' => 'required|email|unique:tbl_login',
            'password' => 'required|min:6'
        ]);

        // Generate kode karyawan
        $date = now()->format('dmY');
        $count = Karyawan::count() + 1;
        $random = mt_rand(100, 999); // Generate 3 random digits
        $kode_karyawan = "KAR-" . $date . str_pad($count, 2, '0', STR_PAD_LEFT) . $random;

        // Upload foto
        if ($request->hasFile('foto_karyawan')) {
            $foto = $request->file('foto_karyawan');
            $nama_foto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/karyawan'), $nama_foto);
        }

        // Simpan data karyawan
        $karyawan = Karyawan::create([
            'nik' => $request->nik,
            'kode_karyawan' => $kode_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'noHp_karyawan' => $request->noHp_karyawan,
            'gender_karyawan' => $request->gender_karyawan,
            'foto_karyawan' => $nama_foto ?? null,
            'status_karyawan' => $request->status_karyawan
        ]);

        // Buat akun login
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status_akun' => 'Aktif',
            'role' => "Karyawan",
            'id_karyawan' => $karyawan->id_karyawan
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('admin.data-karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:tbl_karyawan,nik,'.$id.',id_karyawan',
            'nama_karyawan' => 'required',
            'noHp_karyawan' => 'required',
            'gender_karyawan' => 'required',
            'foto_karyawan' => 'image|mimes:jpeg,png,jpg|max:2048',
            'status_karyawan' => 'required',
            'password' => 'nullable|min:6' // Validasi password baru (opsional)
        ]);

        $karyawan = Karyawan::findOrFail($id);

        if ($request->hasFile('foto_karyawan')) {
            // Hapus foto lama
            if ($karyawan->foto_karyawan && File::exists(public_path('uploads/karyawan/'.$karyawan->foto_karyawan))) {
                File::delete(public_path('uploads/karyawan/'.$karyawan->foto_karyawan));
            }
            
            // Upload foto baru
            $foto = $request->file('foto_karyawan');
            $nama_foto = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/karyawan'), $nama_foto);
            
            $karyawan->foto_karyawan = $nama_foto;
        }

        $karyawan->update([
            'nik' => $request->nik,
            'nama_karyawan' => $request->nama_karyawan,
            'noHp_karyawan' => $request->noHp_karyawan,
            'gender_karyawan' => $request->gender_karyawan,
            'status_karyawan' => $request->status_karyawan
        ]);

        // Update password jika diisi
        if ($request->filled('password')) {
            $user = $karyawan->user; // Akses relasi ke User
            if ($user) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        
        // Hapus foto jika ada
        if ($karyawan->foto_karyawan && File::exists(public_path('uploads/karyawan/'.$karyawan->foto_karyawan))) {
            File::delete(public_path('uploads/karyawan/'.$karyawan->foto_karyawan));
        }
        
        // Hapus data login terkait
        if ($karyawan->user) {
            $karyawan->user->delete();
        }
        
        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }


    public function update_profile(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'foto_karyawan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update data karyawan
        $karyawan = auth()->user()->karyawan;
        $karyawan->nama_karyawan = $request->nama_karyawan;
        
        // Handle foto upload
        if ($request->hasFile('foto_karyawan')) {
            // Hapus foto lama jika ada
            if ($karyawan->foto_karyawan && File::exists(public_path('uploads/karyawan/' . $karyawan->foto_karyawan))) {
            File::delete(public_path('uploads/karyawan/' . $karyawan->foto_karyawan));
            }
            
            // Upload foto baru
            $file = $request->file('foto_karyawan');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/karyawan'), $filename);
            $karyawan->foto_karyawan = $filename;
        }
        
        $karyawan->save();

        // Update data user
        $user = auth()->user();
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui!');
    }
}