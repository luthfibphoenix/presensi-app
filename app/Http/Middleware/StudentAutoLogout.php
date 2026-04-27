<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentAutoLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('siswa')->check()) {
            $lastActivity = session('siswa_last_activity');
            $timeout = 5 * 60; // 5 minutes

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                auth('siswa')->logout();
                session()->forget('siswa_last_activity');
                return redirect()->route('login')->with('info', 'Sesi Anda telah berakhir karena tidak ada aktivitas selama 5 menit.');
            }

            session(['siswa_last_activity' => time()]);
        }

        return $next($request);
    }
}
