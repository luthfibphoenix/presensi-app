<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $penilaians = \App\Models\Penilaian::where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->get();
            
        return view('guru.penilaian.index', compact('penilaians'));
    }

    public function create()
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

        $siswas = \App\Models\Siswa::with('kelas')->get();
        return view('guru.penilaian.create', compact('mapels', 'kelas', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'semester' => 'required|string',
            'komponen' => 'required|string',
            'penilaian' => 'required|array'
        ]);

        foreach ($request->penilaian as $nama_siswa => $data) {
            if (isset($data['nilai']) && $data['nilai'] !== null) {
                \App\Models\Penilaian::create([
                    'user_id' => auth()->id(),
                    'nama_siswa' => $nama_siswa,
                    'kelas' => $request->kelas,
                    'mata_pelajaran' => $request->mata_pelajaran,
                    'semester' => $request->semester,
                    'nilai' => $data['nilai'],
                    'komponen' => $request->komponen,
                    'tanggal' => $request->tanggal,
                    'keterangan' => $data['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('guru.penilaian.index')->with('success', 'Nilai berhasil disimpan.');
    }
}
