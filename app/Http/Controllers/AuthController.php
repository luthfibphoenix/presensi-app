<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $role = $request->route()->defaults['role'] ?? 'umum';
        if (Auth::guard('web')->check()) {
            session(['login_role' => $role]);
            return redirect()->route('dashboard');
        }
        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $inputIdentifier = trim($request->username);
        $inputPassword = $request->password;

        $user = \App\Models\User::where(function($q) use ($inputIdentifier) {
            $q->whereRaw('LOWER(TRIM(username)) = ?', [strtolower($inputIdentifier)])
            ->orWhereRaw('TRIM(nip) = ?', [$inputIdentifier])
            ->orWhereRaw('LOWER(TRIM(fullname)) = ?', [strtolower($inputIdentifier)]);
        })
        ->orderByRaw("CASE WHEN position = 'Piket' THEN 1 ELSE 0 END") // Guru duluan
        ->first();

        // dd([
        //     'input' => $inputIdentifier,
        //     'user_found' => $user ? $user->username : 'tidak ditemukan',
        //     'password_input' => $inputPassword,
        //     'password_db' => $user ? substr($user->password, 0, 20) : null,
        //     'hash_check' => $user ? Hash::check($inputPassword, trim($user->password)) : false,
        // ]);

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