<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TuController extends Controller
{
    public function suratDinas(Request $request)
    {
        $gurus = \App\Models\User::where('position', 'not like', '%Piket%')
            ->orderBy('fullname', 'asc')
            ->get();
        
        if ($request->has('print')) {
            $guru = \App\Models\User::find($request->guru_id);
            $kepala = \App\Models\User::where('position', 'like', '%Kepala Sekolah%')->first();
            
            $tujuan = $request->tujuan;
            $provinsi = $request->provinsi_name;
            $kabupaten = $request->kabupaten_name;
            $kecamatan = $request->kecamatan_name;
            $tanggal_mulai = $request->tanggal_mulai;
            $tanggal_selesai = $request->tanggal_selesai;
            $keperluan = $request->keperluan;
            
            return view('tu.cetak-surat-dinas', compact(
                'guru', 'kepala', 'tujuan', 'provinsi', 'kabupaten', 'kecamatan', 
                'tanggal_mulai', 'tanggal_selesai', 'keperluan'
            ));
        }
        
        return view('tu.surat-dinas', compact('gurus'));
    }
}
