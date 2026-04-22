@extends('layout.app')

@section('title', 'Surat Perjalanan Dinas')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm" x-data="{
    searchGuru: '',
    gurus: {{ json_encode($gurus) }},
    get filteredGurus() {
        if (this.searchGuru === '') return this.gurus;
        return this.gurus.filter(g => g.fullname.toLowerCase().includes(this.searchGuru.toLowerCase()) || 
                                     (g.position && g.position.toLowerCase().includes(this.searchGuru.toLowerCase())));
    }
}">
    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Buat Surat Perjalanan Dinas (SPD)</h2>

    <form action="{{ route('tu.surat_dinas') }}" target="_blank" method="GET">
        <input type="hidden" name="print" value="1">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pegawai / Guru</label>
                <div class="relative mb-3">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" x-model="searchGuru" placeholder="Ketik nama atau jabatan..." class="w-full pl-10 border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Pegawai / Guru</label>
                <select name="guru_id" required size="5" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <template x-for="guru in filteredGurus" :key="guru.id">
                        <option :value="guru.id" x-text="guru.fullname + ' - ' + (guru.position ? guru.position : '-')"></option>
                    </template>
                </select>
                <p class="text-xs text-gray-500 mt-1">Pilih satu pegawai yang ditugaskan.</p>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan Dinas</label>
                    <input type="text" name="tujuan" required class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Instansi/Kota Tujuan">
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat</label>
                        <input type="date" name="tanggal_mulai" required class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                        <input type="date" name="tanggal_selesai" required class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan / Acara</label>
                    <textarea name="keperluan" required rows="2" class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Dalam rangka..."></textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-6 border-t pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-print mr-1"></i> Cetak Surat Tugas
            </button>
        </div>
    </form>
</div>
@endsection
