@extends('layout.app')

@section('title', 'Cetak Blangko Administrasi')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm">
    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Cetak Blangko Administrasi Guru</h2>

    @php
        $mapelOptions = $mapels->pluck('nama_mapel', 'nama_mapel')->toArray();
        $kelasOptions = $kelas->pluck('nama_kelas', 'nama_kelas')->toArray();
        $semesterOptions = [
            'Ganjil 2025/2026' => 'Ganjil 2025/2026',
            'Genap 2025/2026' => 'Genap 2025/2026'
        ];
        $semesterCoverOptions = [
            'Ganjil' => 'Ganjil',
            'Genap' => 'Genap'
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Blangko Presensi -->
        <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center gap-4 mb-6">
                <div class="bg-blue-50 text-blue-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-900 tracking-tight text-lg">Blangko Presensi</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Kehadiran Harian</p>
                </div>
            </div>
            
            <form action="{{ route('guru.blangko.presensi') }}" target="_blank" method="GET" class="space-y-6">
                <x-select-modern name="mata_pelajaran" label="Mata Pelajaran" :options="$mapelOptions" required />
                <x-select-modern name="kelas" label="Kelas" :options="$kelasOptions" required />
                <x-select-modern name="semester" label="Semester" :options="$semesterOptions" required selected="Ganjil 2025/2026" />
                
                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> Cetak PDF
                </button>
            </form>
        </div>

        <!-- Blangko Nilai -->
        <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center gap-4 mb-6">
                <div class="bg-emerald-50 text-emerald-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-900 tracking-tight text-lg">Blangko Nilai</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Rekapitulasi Nilai</p>
                </div>
            </div>
            
            <form action="{{ route('guru.blangko.nilai') }}" target="_blank" method="GET" class="space-y-6">
                <x-select-modern name="mata_pelajaran" label="Mata Pelajaran" :options="$mapelOptions" required />
                <x-select-modern name="kelas" label="Kelas" :options="$kelasOptions" required />
                <x-select-modern name="semester" label="Semester" :options="$semesterOptions" required selected="Ganjil 2025/2026" />
                
                <button type="submit" class="w-full bg-emerald-600 text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> Cetak PDF
                </button>
            </form>
        </div>

        <!-- Cover Administrasi -->
        <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm hover:shadow-xl transition-all duration-300 group">
            <div class="flex items-center gap-4 mb-6">
                <div class="bg-purple-50 text-purple-600 p-4 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <div>
                    <h3 class="font-black text-gray-900 tracking-tight text-lg">Cover Admin</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Halaman Depan</p>
                </div>
            </div>
            
            <form action="{{ route('guru.blangko.cover') }}" target="_blank" method="GET" class="space-y-6">
                <x-select-modern name="mata_pelajaran" label="Mata Pelajaran" :options="$mapelOptions" required />
                <x-select-modern name="kelas" label="Kelas" :options="$kelasOptions" required />
                <x-select-modern name="semester" label="Semester" :options="$semesterCoverOptions" required selected="Ganjil" />
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" value="2025/2026" required class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-purple-500 transition-all outline-none font-bold text-sm text-gray-700" placeholder="2025/2026">
                </div>

                <button type="submit" class="w-full bg-purple-600 text-white py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-purple-700 shadow-lg shadow-purple-200 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-print"></i> Cetak PDF
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
