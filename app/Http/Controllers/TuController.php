<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TuController extends Controller
{
    public function suratDinas(Request $request)
    {
        $gurus = \App\Models\User::all();
        
        if ($request->has('print')) {
            $guru = \App\Models\User::find($request->guru_id);
            $tujuan = $request->tujuan;
            $tanggal_mulai = $request->tanggal_mulai;
            $tanggal_selesai = $request->tanggal_selesai;
            $keperluan = $request->keperluan;
            return view('tu.cetak-surat-dinas', compact('guru', 'tujuan', 'tanggal_mulai', 'tanggal_selesai', 'keperluan'));
        }
        
        return view('tu.surat-dinas', compact('gurus'));
    }
}
