@extends('layout.app')

@section('title', 'Surat Pemanggilan Orang Tua')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm" x-data="{
    searchSiswa: '',
    siswas: {{ json_encode($siswas) }},
    get filteredSiswas() {
        if (this.searchSiswa === '') return this.siswas;
        return this.siswas.filter(s => s.nama.toLowerCase().includes(this.searchSiswa.toLowerCase()) || 
                                     (s.kelas && s.kelas.nama_kelas.toLowerCase().includes(this.searchSiswa.toLowerCase())));
    }
}">
    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Buat Surat Pemanggilan Orang Tua</h2>

    <form action="{{ route('bk.surat_panggil') }}" target="_blank" method="GET">
        <input type="hidden" name="print" value="1">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Siswa</label>
                <div class="relative mb-3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" x-model="searchSiswa" placeholder="Ketik nama atau kelas..." class="w-full pl-10 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Siswa</label>
                <select name="siswa_id" required size="5" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <template x-for="siswa in filteredSiswas" :key="siswa.id">
                        <option :value="siswa.id" x-text="siswa.nama + ' - ' + (siswa.kelas ? siswa.kelas.nama_kelas : 'Tidak Ada Kelas')"></option>
                    </template>
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih satu siswa dari daftar di atas.</p>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kehadiran</label>
                    <input type="date" name="tanggal" required class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Kehadiran</label>
                    <input type="time" name="waktu" required class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan / Keperluan</label>
                    <textarea name="alasan" required rows="3" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Contoh: Membicarakan presensi dan kedisiplinan siswa."></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6 border-t pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-print mr-1"></i> Cetak Surat
            </button>
        </div>
    </form>
</div>
@endsection
