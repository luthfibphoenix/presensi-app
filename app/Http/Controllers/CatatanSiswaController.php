<?php

namespace App\Http\Controllers;

use App\Models\CatatanSiswa;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class CatatanSiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Ambil nama-nama kelas unik dari jadwal guru dengan trim
        $taughtClassesNames = Jadwal::where('user_id', $user->id)
            ->distinct()
            ->pluck('kelas')
            ->map(fn($k) => trim($k))
            ->unique()
            ->toArray();

        // Cari ID Kelas yang sesuai dengan nama-nama tersebut secara case-insensitive & trim
        $allTaughtKelas = Kelas::get()->filter(function($k) use ($taughtClassesNames) {
            foreach ($taughtClassesNames as $name) {
                if (strtolower(trim($k->nama_kelas)) === strtolower(trim($name))) {
                    return true;
                }
            }
            return false;
        });

        $allKelasIds = $allTaughtKelas->pluck('id')->toArray();
        
        // Filter berdasarkan input kelas dari dropdown (jika ada)
        $selectedKelasId = $request->get('kelas_id');
        $queryKelasIds = $allKelasIds;
        
        if ($selectedKelasId && in_array($selectedKelasId, $allKelasIds)) {
            $queryKelasIds = [$selectedKelasId];
        }

        if (empty($allKelasIds)) {
            $siswas = collect();
            $availableKelas = collect();
            return view('guru.catatan.index', compact('siswas', 'availableKelas', 'selectedKelasId'));
        }

        $siswas = Siswa::whereIn('kelas_id', $queryKelasIds)
            ->with(['kelas', 'catatan' => function($q) use ($user) {
                $q->where('guru_id', $user->id)->orderBy('created_at', 'desc');
            }])
            ->orderBy('nama')
            ->get();

        $availableKelas = $allTaughtKelas->sortBy('nama_kelas');

        return view('guru.catatan.index', compact('siswas', 'availableKelas', 'selectedKelasId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|in:Perilaku,Akademik,Prestasi,Lainnya',
        ]);

        CatatanSiswa::create([
            'guru_id'  => auth()->id(),
            'siswa_id' => $request->siswa_id,
            'judul'    => $request->judul,
            'isi'      => $request->isi,
            'kategori' => $request->kategori,
        ]);

        return redirect()->back()->with('success', 'Catatan siswa berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $catatan = CatatanSiswa::findOrFail($id);

        if ($catatan->guru_id !== auth()->id()) {
            abort(403);
        }

        $catatan->delete();

        return redirect()->back()->with('success', 'Catatan siswa berhasil dihapus.');
    }
}