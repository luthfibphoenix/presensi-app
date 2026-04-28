<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlangkoController extends Controller
{
    public function index()
    {
        $mapels = \App\Models\Jadwal::where('user_id', auth()->id())
            ->select('mata_pelajaran as nama_mapel')
            ->distinct()
            ->get();
        if ($mapels->isEmpty()) {
            $mapels = \App\Models\Mapel::orderBy('nama_mapel')->get();
        }

        $kelas = \App\Models\Jadwal::where('user_id', auth()->id())
            ->select('kelas as nama_kelas')
            ->distinct()
            ->get();
        if ($kelas->isEmpty()) {
            $kelas = \App\Models\Kelas::orderBy('nama_kelas')->get();
        }

        return view('guru.blangko.index', compact('mapels', 'kelas'));
    }

    public function presensi(Request $request)
    {
        $kelas = $request->kelas;
        $mapel = $request->mata_pelajaran;
        $semester = $request->semester;
        
        $siswas = \App\Models\Siswa::whereHas('kelas', function($q) use ($kelas) {
            $q->where('nama_kelas', $kelas);
        })->orderBy('nama', 'asc')->get();
        
        return view('guru.blangko.presensi', compact('kelas', 'mapel', 'semester', 'siswas'));
    }

    public function nilai(Request $request)
    {
        $kelas = $request->kelas;
        $mapel = $request->mata_pelajaran;
        $semester = $request->semester;
        
        $siswas = \App\Models\Siswa::whereHas('kelas', function($q) use ($kelas) {
            $q->where('nama_kelas', $kelas);
        })->orderBy('nama', 'asc')->get();
        
        return view('guru.blangko.nilai', compact('kelas', 'mapel', 'semester', 'siswas'));
    }

    public function cover(Request $request)
    {
        $kelas = $request->kelas;
        $mapel = $request->mata_pelajaran;
        $semester = $request->semester;
        $tahun_ajaran = $request->tahun_ajaran ?? '2025/2026'; // Default or from input
        
        return view('guru.blangko.cover', compact('kelas', 'mapel', 'semester', 'tahun_ajaran'));
    }
}
