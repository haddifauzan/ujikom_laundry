<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['Karyawan', 'Konsumen'])
            ->with(['karyawan', 'konsumen'])
            ->get();

        return view('admin.data-akun.index', compact('users'));
    }


    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $status = $request->input('status');
        $user->status_akun = $status;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status akun berhasil diubah.',
        ]);
    }
}
