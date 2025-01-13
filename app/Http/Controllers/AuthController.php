<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Method untuk menampilkan form login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(strtolower(Auth::user()->role) . '.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the login form input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->withInput($request->only('email'));
        }

        $guard = strtolower($user->role);

        // Attempt to log in with the specified guard
        if (Auth::guard($guard)->attempt($credentials, $request->has('remember'))) {
            // Check account status
            if ($user->status_akun !== 'Aktif') {
            Auth::guard($guard)->logout();
            return redirect()->route('login')->with('error', 'Status akun anda Non-Aktif.');
            }

            // Update last login time
            $user->last_login = now();
            $user->save();

            // Redirect to the appropriate dashboard
            if ($guard === 'karyawan') {
                if ($user->karyawan->status_karyawan === 'pengelola barang') {
                    return redirect()->route('karyawan.pengelola-barang.dashboard')->with('success', 'Login berhasil!');
                } elseif ($user->karyawan->status_karyawan === 'kasir') {
                    return redirect()->route('karyawan.kasir.dashboard')->with('success', 'Login berhasil!');
                }
            } else {
                return redirect()->route($guard . '.dashboard')->with('success', 'Login berhasil!');
            }
        }

        // If login fails
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        // Tentukan guard berdasarkan role yang sedang login
        $roleGuards = [
            'Admin' => 'admin',
            'Karyawan' => 'karyawan',
            'Konsumen' => 'konsumen',
        ];

        // Logout dari guard yang aktif
        foreach ($roleGuards as $guard) {
            if (Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();

                // Invalidate session
                $request->session()->invalidate();

                // Regenerate CSRF token
                $request->session()->regenerateToken();

                // Hapus remember_me dari session
                $request->session()->forget('remember');

                // Redirect ke halaman login atau halaman lain setelah logout
                return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
            }
        }

        // Redirect to login if no user was logged in (fallback)
        return redirect()->route('login')->with('error', 'Tidak ada pengguna yang login.');
    }


    public function showLoginModal()
    {
        return response()->json([
            'title' => 'Login Required',
            'message' => 'Anda harus login sebagai konsumen member terlebih dahulu untuk mengakses fitur ini.'
        ]);
    }

    // Show member login form
    public function showMemberLoginForm()
    {
        if (Auth::guard('konsumen')->check()) {
            return redirect()->route('landing');
        }
        return view('auth.member-login');
    }

    // Handle member login
    public function memberLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)
                    ->where('role', 'Konsumen')
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->withInput($request->only('email'));
        }

        if ($user->status_akun !== 'Aktif') {
            return back()->withErrors([
                'email' => 'Akun anda tidak aktif. Silahkan hubungi admin.',
            ])->withInput($request->only('email'));
        }

        if (Auth::guard('konsumen')->attempt($credentials, $request->has('remember'))) {
            $user->last_login = now();
            $user->save();

            return redirect()->intended(route('landing.member'))
                           ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Handle member logout
    public function memberLogout(Request $request)
    {
        Auth::guard('konsumen')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('landing')
                        ->with('success', 'Anda telah berhasil logout.');
    }

    // Get authenticated member data
    public function getMemberData()
    {
        if (Auth::guard('konsumen')->check()) {
            $user = Auth::guard('konsumen')->user();
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'name' => $user->konsumen->nama_konsumen,
                    'email' => $user->email
                ]
            ]);
        }

        return response()->json(['authenticated' => false]);
    }

    public function getProfileData()
    {
        if (Auth::guard('konsumen')->check()) {
            $user = Auth::guard('konsumen')->user();
            $konsumen = $user->konsumen;

            return response()->json([
                'nama_konsumen' => $konsumen->nama_konsumen,
                'email' => $user->email,
                'kode_konsumen' => $konsumen->kode_konsumen,
                'no_hp' => $konsumen->noHp_konsumen,
                'alamat' => $konsumen->alamat_konsumen,
                'tanggal_bergabung' => $konsumen->created_at->format('d F Y'),
                'total_transaksi' => $konsumen->transaksi->count(),
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
