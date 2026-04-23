<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        if (Auth::guard('siswa')->check()) {
            return redirect()->route('siswa.dashboard');
        }
        if (Auth::guard('orangtua')->check()) {
            return redirect()->route('ortu.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $inputIdentifier = trim($request->username);
        $inputPassword = $request->password;

        // 1. CEK TABEL USERS (Administrator, Guru, Staff)
        $user = \App\Models\User::where(function($q) use ($inputIdentifier) {
            $q->whereRaw('LOWER(TRIM(username)) = ?', [strtolower($inputIdentifier)])
            ->orWhereRaw('TRIM(nip) = ?', [$inputIdentifier]);
        })->first();

        if ($user && Hash::check($inputPassword, $user->password)) {
            Auth::guard('web')->login($user, $request->filled('remember'));
            $request->session()->regenerate();
            
            // Tentukan role default dari position untuk session
            $pos = strtolower($user->position ?? '');
            $role = 'guru';
            if (str_contains($pos, 'piket')) $role = 'piket';
            if (str_contains($pos, 'administrator')) $role = 'admin';
            if (str_contains($pos, 'bk')) $role = 'bk';
            if (str_contains($pos, 'tu') || str_contains($pos, 'tata usaha')) $role = 'tu';
            
            session(['login_role' => $role]);
            return redirect()->intended(route('dashboard'));
        }

        // 2. CEK TABEL SISWAS (Siswa)
        $siswa = \App\Models\Siswa::where('username', $inputIdentifier)
            ->orWhere('nis', $inputIdentifier)
            ->first();
            
        if ($siswa && Hash::check($inputPassword, $siswa->password)) {
            Auth::guard('siswa')->login($siswa, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'));
        }

        // 3. CEK TABEL ORANGTUAS (Orang Tua)
        $ortu = \App\Models\Orangtua::where('username', $inputIdentifier)->first();
        if ($ortu && Hash::check($inputPassword, $ortu->password)) {
            Auth::guard('orangtua')->login($ortu, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('ortu.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        // Logout dari semua guard yang aktif
        if (Auth::guard('web')->check()) Auth::guard('web')->logout();
        if (Auth::guard('siswa')->check()) Auth::guard('siswa')->logout();
        if (Auth::guard('orangtua')->check()) Auth::guard('orangtua')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:3|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai!');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah!');
    }
}