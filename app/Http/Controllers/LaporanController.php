<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $presensis = Presensi::with(['siswa', 'jadwal'])->orderBy('tanggal', 'desc')->paginate(20);
        return view('laporan.index', compact('presensis'));
    }
}
