@extends('layout.app')

@section('title', 'Cetak Blangko Administrasi')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm">
    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Cetak Blangko Administrasi Guru</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Blangko Presensi -->
        <div class="border rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-800">Blangko Presensi</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4 h-10">Cetak daftar hadir manual untuk diisi di kelas saat pembelajaran.</p>
            
            <form action="{{ route('guru.blangko.presensi') }}" target="_blank" method="GET">
                <div class="space-y-3 mb-4">
                    <select name="mata_pelajaran" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Mapel</option>
                        @foreach($mapels as $mapel) <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option> @endforeach
                    </select>
                    <select name="kelas" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k) <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option> @endforeach
                    </select>
                    <select name="semester" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="Ganjil 2025/2026">Ganjil 2025/2026</option>
                        <option value="Genap 2025/2026">Genap 2025/2026</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-bold hover:bg-blue-700">
                    <i class="fas fa-print mr-1"></i> Cetak PDF
                </button>
            </form>
        </div>

        <!-- Blangko Nilai -->
        <div class="border rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-emerald-100 text-emerald-600 p-3 rounded-full">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-800">Blangko Nilai</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4 h-10">Cetak daftar nilai kosong untuk merekap nilai harian, tugas, atau ujian.</p>
            
            <form action="{{ route('guru.blangko.nilai') }}" target="_blank" method="GET">
                <div class="space-y-3 mb-4">
                    <select name="mata_pelajaran" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Mapel</option>
                        @foreach($mapels as $mapel) <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option> @endforeach
                    </select>
                    <select name="kelas" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k) <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option> @endforeach
                    </select>
                    <select name="semester" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="Ganjil 2025/2026">Ganjil 2025/2026</option>
                        <option value="Genap 2025/2026">Genap 2025/2026</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-lg text-sm font-bold hover:bg-emerald-700">
                    <i class="fas fa-print mr-1"></i> Cetak PDF
                </button>
            </form>
        </div>

        <!-- Cover Administrasi -->
        <div class="border rounded-xl p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center gap-3 mb-4">
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-800">Cover Administrasi</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4 h-10">Cetak halaman depan (cover) untuk berkas administrasi guru.</p>
            
            <form action="{{ route('guru.blangko.cover') }}" target="_blank" method="GET">
                <div class="space-y-3 mb-4">
                    <select name="mata_pelajaran" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Mapel</option>
                        @foreach($mapels as $mapel) <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option> @endforeach
                    </select>
                    <select name="kelas" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $k) <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option> @endforeach
                    </select>
                    <select name="semester" required class="w-full border-gray-300 rounded-md text-sm">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                    <input type="text" name="tahun_ajaran" value="2025/2026" required class="w-full border-gray-300 rounded-md text-sm" placeholder="Tahun Ajaran (e.g., 2025/2026)">
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded-lg text-sm font-bold hover:bg-purple-700">
                    <i class="fas fa-print mr-1"></i> Cetak PDF
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
