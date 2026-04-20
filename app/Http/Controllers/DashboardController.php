<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $pos = strtolower($user->position ?? '');
        $loginRole = session('login_role', 'umum');

        // Prioritas berdasarkan session login_role
        if ($loginRole === 'admin') {
            return view('dashboard.admin');
        }

        if ($loginRole === 'piket') {
            return view('dashboard.gurupiket');
        }

        if ($loginRole === 'bk') {
            return view('dashboard.gurubk');
        }

        if ($loginRole === 'guru') {
            return view('dashboard.guru');
        }

        // Fallback berdasarkan position
        if (str_contains($pos, 'administrator')) return view('dashboard.admin');
        if (str_contains($pos, 'kepala sekolah')) return view('dashboard.admin');
        if (str_contains($pos, 'bk')) return view('dashboard.gurubk');
        if (str_contains($pos, 'guru') || str_contains($pos, 'waka') || str_contains($pos, 'kakonli') || str_contains($pos, 'tata usaha')) return view('dashboard.guru');
        if ($user->is_wali) return view('dashboard.walikelas');
        if (str_contains($pos, 'piket')) return view('dashboard.gurupiket');

        return view('dashboard.guru');
    }

    public function siswaDashboard(Request $request)
    {
        return view('siswa.dashboard');
    }
}