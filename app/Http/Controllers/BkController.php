<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BkController extends Controller
{
    public function suratPanggil(Request $request)
    {
        $siswas = \App\Models\Siswa::with('kelas')->get();
        
        if ($request->has('print')) {
            $siswa = \App\Models\Siswa::with('kelas')->find($request->siswa_id);
            $tanggal = $request->tanggal;
            $alasan = $request->alasan;
            $waktu = $request->waktu;
            return view('bk.cetak-surat-panggil', compact('siswa', 'tanggal', 'alasan', 'waktu'));
        }
        
        return view('bk.surat-panggil', compact('siswas'));
    }
}
