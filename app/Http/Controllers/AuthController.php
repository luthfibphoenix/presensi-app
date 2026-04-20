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

        // 1. CEK SEBAGAI GURU / STAFF (User Model)
        $user = \App\Models\User::where(function($q) use ($inputIdentifier) {
            $q->whereRaw('LOWER(TRIM(username)) = ?', [strtolower($inputIdentifier)])
            ->orWhereRaw('TRIM(nip) = ?', [$inputIdentifier])
            ->orWhereRaw('LOWER(TRIM(fullname)) = ?', [strtolower($inputIdentifier)]);
        })
        ->orderByRaw("CASE WHEN position = 'Piket' THEN 1 ELSE 0 END")
        ->first();

        if ($user) {
            $dbHash = trim($user->password);
            $dbHashPiket = trim($user->password_piket ?? '');

            // Cek password guru (222)
            if (Hash::check($inputPassword, $dbHash)) {
                Auth::guard('web')->login($user);
                $request->session()->regenerate();
                session(['login_role' => 'guru']);
                return redirect()->intended(route('dashboard'));
            }

            // Cek password piket (333)
            if ($dbHashPiket && Hash::check($inputPassword, $dbHashPiket)) {
                Auth::guard('web')->login($user);
                $request->session()->regenerate();
                session(['login_role' => 'piket']);
                return redirect()->intended(route('dashboard'));
            }

            // Cek password umum (fallback)
            if (Hash::check($inputPassword, $dbHash)) {
                 Auth::guard('web')->login($user);
                 $request->session()->regenerate();
                 // Tentukan role default dari position
                 $pos = strtolower($user->position ?? '');
                 $role = 'guru';
                 if (str_contains($pos, 'piket')) $role = 'piket';
                 if (str_contains($pos, 'administrator')) $role = 'admin';
                 if (str_contains($pos, 'bk')) $role = 'bk';
                 session(['login_role' => $role]);
                 return redirect()->intended(route('dashboard'));
            }
        }

        // 2. CEK SEBAGAI SISWA (Siswa Model)
        $siswa = \App\Models\Siswa::where('username', $inputIdentifier)->first();
        if ($siswa && Hash::check($inputPassword, $siswa->password)) {
            Auth::guard('siswa')->login($siswa);
            $request->session()->regenerate();
            return redirect()->intended(route('siswa.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}