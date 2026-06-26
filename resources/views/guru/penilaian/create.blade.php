@extends('layout.app')

@section('title', 'Input Nilai Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm" x-data="{
    selectedKelas: '',
    siswas: {!! json_encode($siswas) !!},
    get filteredSiswas() {
        return this.siswas.filter(s => s.kelas && s.kelas.nama_kelas === this.selectedKelas);
    }
}">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Form Input Nilai Siswa</h2>
        <a href="{{ route('guru.penilaian.index') }}" class="text-blue-600 hover:text-blue-800 text-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    <form action="{{ route('guru.penilaian.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Penilaian</label>
                <input type="date" name="tanggal" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" value="{{ date('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="mata_pelajaran" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->nama_mapel }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="kelas" x-model="selectedKelas" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <select name="semester" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="20241">Ganjil 2024/2025</option>
                    <option value="20242">Genap 2024/2025</option>
                    <option value="20251" selected>Ganjil 2025/2026</option>
                    <option value="20252">Genap 2025/2026</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Komponen Penilaian</label>
                <select name="komponen" required class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Pilih Komponen</option>
                    <option value="Ulangan Harian">Ulangan Harian</option>
                    <option value="Tugas">Tugas</option>
                    <option value="UTS">Ulangan Tengah Semester (UTS)</option>
                    <option value="UAS">Ulangan Akhir Semester (UAS)</option>
                    <option value="Praktik">Ujian Praktik</option>
                </select>
            </div>
        </div>

        <div x-show="selectedKelas !== ''" class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Daftar Siswa</h3>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="py-2 px-3 text-left border-b w-10">No</th>
                                <th class="py-2 px-3 text-left border-b">Nama Siswa</th>
                                <th class="py-2 px-3 text-left border-b w-32">Nilai (0-100)</th>
                                <th class="py-2 px-3 text-left border-b">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(siswa, index) in filteredSiswas" :key="siswa.id">
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-2 px-3 text-center" x-text="index + 1"></td>
                                    <td class="py-2 px-3 font-medium" x-text="siswa.nama"></td>
                                    <td class="py-2 px-3">
                                        <input type="number" :name="'penilaian[' + siswa.nama + '][nilai]'" step="0.01" min="0" max="100" class="w-full border-gray-300 rounded-md py-1 px-2 text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </td>
                                    <td class="py-2 px-3">
                                        <input type="text" :name="'penilaian[' + siswa.nama + '][keterangan]'" class="w-full border-gray-300 rounded-md py-1 px-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Opsional">
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="filteredSiswas.length === 0">
                                <td colspan="4" class="py-4 text-center text-gray-500">Tidak ada data siswa untuk kelas ini.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Simpan Nilai
            </button>
        </div>
    </form>
</div>
@endsection
