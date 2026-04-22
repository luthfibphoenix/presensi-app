<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        $loginRole = session('login_role', 'umum');

        if (!$user) {
            return redirect('/');
        }

        // Always allow Super Administrator
        if (str_contains(strtolower($user->position ?? ''), 'super administrator')) {
            return $next($request);
        }

        // 1. Cek berdasarkan session login_role (Prioritas Utama)
        if ($loginRole === 'piket' && in_array('Guru Piket', $roles)) return $next($request);
        if ($loginRole === 'admin' && in_array('Administrator', $roles)) return $next($request);
        if ($loginRole === 'bk' && in_array('Guru BK', $roles)) return $next($request);
        if ($loginRole === 'guru' && in_array('Guru', $roles)) return $next($request);

        // 2. Cek berdasarkan jabatan di database (Ditingkatkan dengan Partial Matching)
        $userPositions = array_map('trim', explode(',', $user->position ?? ''));
        
        foreach ($roles as $requiredRole) {
            foreach ($userPositions as $userPos) {
                // Bersihkan string untuk pembandingan
                $cleanPos = strtolower($userPos);
                $cleanReq = strtolower($requiredRole);

                // Cek kecocokan eksak atau parsial dua arah
                if ($cleanPos === $cleanReq || 
                    str_contains($cleanPos, $cleanReq) || 
                    str_contains($cleanReq, $cleanPos)) {
                    return $next($request);
                }

                // Penanganan khusus TU
                if (($cleanReq === 'tu' || $cleanReq === 'tata usaha') && 
                    (str_contains($cleanPos, 'tu') || str_contains($cleanPos, 'tata usaha'))) {
                    return $next($request);
                }
            }
        }

        // 3. Khusus Wali Kelas (menggunakan boolean is_wali)
        if (in_array('Wali Kelas', $roles) && $user->is_wali) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
