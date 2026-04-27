<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $jurnals = \App\Models\JurnalMengajar::with('presensi')
            ->where('user_id', auth()->id())
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();
            
        return view('guru.jurnal.index', compact('jurnals'));
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

        // Fetch students and their approved permissions for today
        $tanggal = now()->toDateString();
        $siswas = \App\Models\Siswa::with('kelas')->get()->map(function($siswa) use ($tanggal) {
            $izin = \App\Models\Izin::where('siswa_id', $siswa->id)
                ->where('tanggal', $tanggal)
                ->where('status', 'Disetujui')
                ->first();
            
            $siswa->auto_status = $izin ? $izin->tipe : 'Hadir';
            return $siswa;
        });

        return view('guru.jurnal.create', compact('mapels', 'kelas', 'siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'jam_mulai' => 'required|integer',
            'jam_selesai' => 'required|integer',
            'ringkasan_materi' => 'required|string',
            'semester' => 'required|string',
            'presensi' => 'required|array'
        ]);

        $jurnal = \App\Models\JurnalMengajar::create([
            'user_id' => auth()->id(),
            'tanggal' => $request->tanggal,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ringkasan_materi' => $request->ringkasan_materi,
            'semester' => $request->semester,
        ]);

        foreach ($request->presensi as $nama_siswa => $status) {
            \App\Models\JurnalPresensi::create([
                'jurnal_id' => $jurnal->id,
                'nama_siswa' => $nama_siswa,
                'status' => $status
            ]);
        }

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    public function cetak(Request $request)
    {
        $query = \App\Models\JurnalMengajar::with('presensi')->where('user_id', auth()->id());
        
        if ($request->jurnal_id) {
            $query->where('id', $request->jurnal_id);
        }
        if ($request->tanggal) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        if ($request->semester) {
            $query->where('semester', $request->semester);
        }
        
        // simple filter implementation, expand as needed
        $jurnals = $query->orderBy('tanggal', 'asc')->get();
        return view('guru.jurnal.cetak', compact('jurnals'));
    }
    public function edit($id)
    {
        $jurnal = \App\Models\JurnalMengajar::with('presensi')->where('user_id', auth()->id())->findOrFail($id);
        
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
        
        return view('guru.jurnal.edit', compact('jurnal', 'mapels', 'kelas', 'siswas'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = \App\Models\JurnalMengajar::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'tanggal' => 'required|date',
            'mata_pelajaran' => 'required|string',
            'kelas' => 'required|string',
            'jam_mulai' => 'required|integer',
            'jam_selesai' => 'required|integer',
            'ringkasan_materi' => 'required|string',
            'semester' => 'required|string',
            'presensi' => 'required|array'
        ]);

        $jurnal->update([
            'tanggal' => $request->tanggal,
            'mata_pelajaran' => $request->mata_pelajaran,
            'kelas' => $request->kelas,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'ringkasan_materi' => $request->ringkasan_materi,
            'semester' => $request->semester,
        ]);

        // Hapus presensi lama dan simpan yang baru
        \App\Models\JurnalPresensi::where('jurnal_id', $jurnal->id)->delete();
        
        foreach ($request->presensi as $nama_siswa => $status) {
            \App\Models\JurnalPresensi::create([
                'jurnal_id' => $jurnal->id,
                'nama_siswa' => $nama_siswa,
                'status' => $status
            ]);
        }

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jurnal = \App\Models\JurnalMengajar::where('user_id', auth()->id())->findOrFail($id);
        \App\Models\JurnalPresensi::where('jurnal_id', $jurnal->id)->delete();
        $jurnal->delete();

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil dihapus.');
    }

    public function deleteAll()
    {
        $userId = auth()->id();
        $jurnalIds = \App\Models\JurnalMengajar::where('user_id', $userId)->pluck('id');
        
        // Delete associated attendance first
        \App\Models\JurnalPresensi::whereIn('jurnal_id', $jurnalIds)->delete();
        
        // Delete all journals for this teacher
        \App\Models\JurnalMengajar::where('user_id', $userId)->delete();

        return redirect()->route('guru.jurnal.index')->with('success', 'Semua riwayat jurnal Anda telah dibersihkan.');
    }
}
