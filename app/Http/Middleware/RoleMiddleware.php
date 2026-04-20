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

        if (!$user) {
            return redirect('/');
        }

        if (in_array($user->position, $roles)) {
            return $next($request);
        }

        // Allow any position that contains 'Guru', 'Waka', 'Kakonli', 'Piket', 'Kepala Sekolah' if 'Guru' is one of the allowed roles
        if (in_array('Guru', $roles)) {
            $allowedPatterns = ['Guru', 'Waka', 'Kakonli', 'Piket', 'Kepala Sekolah'];
            foreach ($allowedPatterns as $pattern) {
                if (strpos($user->position, $pattern) !== false) {
                    return $next($request);
                }
            }
        }

        // Check if role is 'Wali Kelas' specifically using the is_wali boolean
        if (in_array('Wali Kelas', $roles) && $user->is_wali) {
            return $next($request);
        }

        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
