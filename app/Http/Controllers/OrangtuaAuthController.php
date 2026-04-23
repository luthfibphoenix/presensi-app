<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangtuaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('ortu.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $identifier = $request->username;
        $password = $request->password;

        // 1. Coba cari berdasarkan NIS Siswa dulu
        $siswa = \App\Models\Siswa::where('nis', $identifier)->first();
        if ($siswa) {
            // Ambil semua akun orang tua yang terhubung dengan siswa ini (bisa Ayah, Ibu, dll)
            $ortus = \App\Models\Orangtua::where('siswa_id', $siswa->id)->get();
            
            foreach ($ortus as $ortu) {
                // Coba login untuk setiap akun orang tua yang ditemukan
                if (Auth::guard('orangtua')->attempt(['username' => $ortu->username, 'password' => $password], $request->filled('remember'))) {
                    $request->session()->regenerate();
                    return redirect()->intended(route('ortu.dashboard'));
                }
            }
        }

        // 2. Fallback: Coba login normal pakai username orang tua
        if (Auth::guard('orangtua')->attempt(['username' => $identifier, 'password' => $password], $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('ortu.dashboard'));
        }

        return back()->withErrors([
            'username' => 'NIS Siswa / Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('orangtua')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
