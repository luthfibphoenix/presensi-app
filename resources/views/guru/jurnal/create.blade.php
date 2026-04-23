@extends('layout.app')

@section('title', 'Buat Jurnal Mengajar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm" x-data="{
    selectedKelas: '',
    siswas: {{ json_encode($siswas) }},
    get filteredSiswas() {
        return this.siswas.filter(s => s.kelas && s.kelas.nama_kelas === this.selectedKelas);
    }
}">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Form Jurnal Mengajar & Presensi</h2>
        <a href="{{ route('guru.jurnal.index') }}" class="text-blue-600 hover:text-blue-800 text-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <form action="{{ route('guru.jurnal.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            @php
                $mapelOptions = $mapels->pluck('nama_mapel', 'nama_mapel')->toArray();
                $kelasOptions = $kelas->pluck('nama_kelas', 'nama_kelas')->toArray();
                $semesterOptions = [
                    '20241' => 'Ganjil 2024/2025',
                    '20242' => 'Genap 2024/2025',
                    '20251' => 'Ganjil 2025/2026',
                    '20252' => 'Genap 2025/2026'
                ];
            @endphp
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tanggal</label>
                <input type="date" name="tanggal" required class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-sm text-gray-700" value="{{ date('Y-m-d') }}">
            </div>
            
            <x-select-modern name="mata_pelajaran" label="Mata Pelajaran" :options="$mapelOptions" required placeholder="Pilih Mata Pelajaran" />
            
            <div @change="selectedKelas = $event.target.value">
                <x-select-modern name="kelas" label="Kelas" :options="$kelasOptions" required placeholder="Pilih Kelas" />
            </div>
            
            <x-select-modern name="semester" label="Semester" :options="$semesterOptions" required selected="20251" />

            <div class="flex gap-4">
                <div class="flex-1 space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jam Mulai (Ke-)</label>
                    <input type="number" name="jam_mulai" min="1" max="12" required class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-sm text-gray-700" placeholder="1">
                </div>
                <div class="flex-1 space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Jam Selesai (Ke-)</label>
                    <input type="number" name="jam_selesai" min="1" max="12" required class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-sm text-gray-700" placeholder="2">
                </div>
            </div>
            <div class="md:col-span-2 space-y-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Ringkasan Materi</label>
                <textarea name="ringkasan_materi" rows="3" required class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-sm text-gray-700" placeholder="Tuliskan ringkasan materi pembelajaran hari ini..."></textarea>
            </div>

        </div>

        <div x-show="selectedKelas !== ''" class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Presensi Siswa</h3>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500 mb-4">Tandai status kehadiran siswa untuk kelas <span x-text="selectedKelas" class="font-bold"></span>.</p>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-3 text-left border-b w-10">No</th>
                                <th class="py-2 px-3 text-left border-b">Nama Siswa</th>
                                <th class="py-2 px-3 text-center border-b w-64">Status Presensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(siswa, index) in filteredSiswas" :key="siswa.id">
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-3 text-center" x-text="index + 1"></td>
                                    <td class="py-2 px-3 font-medium" x-text="siswa.nama"></td>
                                    <td class="py-2 px-3 text-center">
                                        <div class="flex justify-center gap-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" :name="'presensi[' + siswa.nama + ']'" value="Hadir" class="text-green-600 focus:ring-green-500" :checked="siswa.auto_status === 'Hadir' || !siswa.auto_status">
                                                <span class="ml-1 text-green-700">H</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" :name="'presensi[' + siswa.nama + ']'" value="Sakit" class="text-blue-600 focus:ring-blue-500" :checked="siswa.auto_status === 'Sakit'">
                                                <span class="ml-1 text-blue-700">S</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" :name="'presensi[' + siswa.nama + ']'" value="Izin" class="text-yellow-600 focus:ring-yellow-500" :checked="siswa.auto_status === 'Izin'">
                                                <span class="ml-1 text-yellow-700">I</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" :name="'presensi[' + siswa.nama + ']'" value="Alfa" class="text-red-600 focus:ring-red-500" :checked="siswa.auto_status === 'Alfa'">
                                                <span class="ml-1 text-red-700">A</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredSiswas.length === 0">
                                <td colspan="3" class="py-4 text-center text-gray-500">Tidak ada data siswa untuk kelas ini.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-8 pb-24 md:pb-0">
            <button type="submit" class="w-full md:w-auto bg-blue-600 text-white px-8 py-4 md:py-3 rounded-2xl font-black hover:bg-blue-700 focus:ring-4 focus:ring-blue-100 transition-all shadow-lg shadow-blue-100 uppercase tracking-widest text-[10px] md:text-xs">
                <i class="fas fa-save mr-2"></i> Simpan Jurnal & Presensi
            </button>
        </div>
    </form>
</div>
@endsection
