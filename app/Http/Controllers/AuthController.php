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

        // Validasi agar username guru wajib menggunakan huruf kapital yang sesuai dengan database
        if (!is_numeric($inputIdentifier)) {
            $teacherAccount = \App\Models\User::whereRaw('LOWER(TRIM(username)) = ?', [strtolower($inputIdentifier)])->first();
            if ($teacherAccount && $teacherAccount->username !== $inputIdentifier) {
                return back()->withErrors([
                    'username' => 'Username guru harus menggunakan huruf kapital yang sesuai (Contoh: ' . $teacherAccount->username . ').',
                ])->onlyInput('username');
            }
        }

        // Cek keberadaan akun di database (Users, Siswa, atau Orangtua)
        $userExistsInDb = false;

        // 1. Cek di tabel Users (Case-Sensitive Match agar sesuai input persis)
        $hasUser = \App\Models\User::where(function($q) use ($inputIdentifier) {
            $q->whereRaw('TRIM(username) = ?', [$inputIdentifier])
              ->orWhereRaw('TRIM(nip) = ?', [$inputIdentifier]);
        })->exists();

        if ($hasUser) {
            $userExistsInDb = true;
        } else {
            // 2. Cek di tabel Siswa
            $hasSiswa = \App\Models\Siswa::where('username', $inputIdentifier)
                ->orWhere('nis', $inputIdentifier)
                ->exists();
            
            if ($hasSiswa) {
                $userExistsInDb = true;
            } else {
                // 3. Cek di tabel Orangtua
                $hasOrtu = false;
                if (str_contains($inputIdentifier, '.')) {
                    $parts = explode('.', $inputIdentifier);
                    $firstnameInput = strtolower(trim($parts[0]));
                    $nisInput = trim($parts[1] ?? '');
                    
                    $siswaByFormat = \App\Models\Siswa::where('nis', $nisInput)->first();
                    if ($siswaByFormat) {
                        $studentFirstname = strtolower(explode(' ', trim($siswaByFormat->nama))[0]);
                        if ($firstnameInput === $studentFirstname) {
                            $hasOrtu = \App\Models\Orangtua::where('siswa_id', $siswaByFormat->id)->exists();
                        }
                    }
                }
                
                if (!$hasOrtu) {
                    $hasOrtu = \App\Models\Orangtua::where('username', $inputIdentifier)->exists();
                }

                if ($hasOrtu) {
                    $userExistsInDb = true;
                }
            }
        }

        if (!$userExistsInDb) {
            return back()->withErrors([
                'username' => 'Akun tidak ditemukan.',
            ])->onlyInput('username');
        }

        // 1. CEK TABEL USERS (Case-Sensitive Match agar sesuai input persis)
        $users = \App\Models\User::where(function($q) use ($inputIdentifier) {
            $q->whereRaw('TRIM(username) = ?', [$inputIdentifier])
            ->orWhereRaw('TRIM(nip) = ?', [$inputIdentifier]);
        })->get();

        foreach ($users as $user) {
            // 1. Cek Password Utama
            if (Hash::check($inputPassword, $user->password)) {
                // Tentukan role default dari position untuk session
                $pos = strtolower($user->position ?? '');
                $role = 'guru';
                if (str_contains($pos, 'piket') && !str_contains($pos, 'guru')) $role = 'piket';
                if (str_contains($pos, 'administrator')) $role = 'admin';
                if (str_contains($pos, 'bk')) $role = 'bk';
                if (str_contains($pos, 'tu') || str_contains($pos, 'tata usaha') || str_contains(strtolower($user->fullname ?? ''), 'sudar')) $role = 'tu';

                Auth::guard('web')->login($user, $request->filled('remember'));
                $request->session()->regenerate();
                session(['login_role' => $role]);
                return redirect()->intended(route('dashboard'));
            }

            // 2. Cek Password Piket (Khusus jika kolom password_piket diisi)
            if (!empty($user->password_piket) && Hash::check($inputPassword, $user->password_piket)) {
                Auth::guard('web')->login($user, $request->filled('remember'));
                $request->session()->regenerate();
                session(['login_role' => 'piket']); // Masuk sebagai mode piket
                return redirect()->intended(route('dashboard'));
            }
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
        // Coba cari berdasarkan format: namadepan.nis (Portal Satu Pintu)
        if (str_contains($inputIdentifier, '.')) {
            $parts = explode('.', $inputIdentifier);
            $firstnameInput = strtolower(trim($parts[0]));
            $nisInput = trim($parts[1] ?? '');

            $siswaByFormat = \App\Models\Siswa::where('nis', $nisInput)->first();
            
            if ($siswaByFormat) {
                $studentFirstname = strtolower(explode(' ', trim($siswaByFormat->nama))[0]);
                
                // Jika nama depan cocok, cari akun orang tuanya
                if ($firstnameInput === $studentFirstname) {
                    $ortus = \App\Models\Orangtua::where('siswa_id', $siswaByFormat->id)->get();
                    foreach ($ortus as $o) {
                        // Coba cocokkan password 
                        if (Hash::check($inputPassword, $o->password)) {
                            Auth::guard('orangtua')->login($o, $request->filled('remember'));
                            $request->session()->regenerate();
                            return redirect()->route('ortu.dashboard');
                        }
                    }
                }
            }
        }

        // Coba cari berdasarkan username orang tua di DB (Fallback)
        $ortuFallback = \App\Models\Orangtua::where('username', $inputIdentifier)->first();
        if ($ortuFallback && Hash::check($inputPassword, $ortuFallback->password)) {
            Auth::guard('orangtua')->login($ortuFallback, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->route('ortu.dashboard');
        }

        return back()->withErrors([
            'username' => 'Password yang Anda masukkan salah.',
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