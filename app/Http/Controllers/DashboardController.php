<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->position === 'Administrator') {
            return view('dashboard.admin');
        } elseif ($user->position === 'Guru') {
            return view('dashboard.guru');
        } elseif ($user->position === 'Guru BK') {
            return view('dashboard.gurubk');
        } elseif ($user->position === 'Wali Kelas' || $user->is_wali) {
            return view('dashboard.walikelas');
        }

        return abort(403, 'Akses ditolak.');
    }

    public function siswaDashboard(Request $request)
    {
        return view('siswa.dashboard');
    }
}
