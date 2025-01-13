<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckKaryawanStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $status
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$statuses)
    {
        $user = Auth::user(); // Mendapatkan user yang terautentikasi

        if (!$user || $user->role !== 'Karyawan') {
            return redirect()->route('login.form')->with('error', 'Anda tidak memiliki akses.');
        }

        // Cek apakah status_karyawan user ada dalam daftar status yang diizinkan
        if (!in_array($user->karyawan->status_karyawan, $statuses)) {
            return redirect()->route('login.form')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}