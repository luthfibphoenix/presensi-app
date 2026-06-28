@extends('layout.app')

@section('title', 'Surat Pemanggilan Orang Tua')

@section('content')
<div class="w-full flex flex-col gap-6 pb-10" x-data="{
    searchSiswa: '',
    selectedSiswaId: null,
    siswas: {!! json_encode($siswas) !!},
    get filteredSiswas() {
        if (this.searchSiswa === '') return this.siswas;
        const q = this.searchSiswa.toLowerCase();
        return this.siswas.filter(s => 
            s.nama.toLowerCase().includes(q) || 
            (s.kelas && s.kelas.nama_kelas.toLowerCase().includes(q))
        );
    }
}">
    <div class="bg-white rounded-[2rem] md:rounded-[2.5rem] border border-gray-100 shadow-sm p-5 md:p-8 flex-shrink-0 flex flex-col min-h-0 h-full">
        <div class="flex items-center gap-4 mb-8 flex-shrink-0">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                <i class="fas fa-envelope-open-text text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Panggilan Orang Tua / Wali</h2>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Buat surat undangan resmi untuk wali siswa</p>
            </div>
        </div>

        <form action="{{ route('bk.surat_panggil') }}" target="_blank" method="GET" class="flex-1 flex flex-col overflow-hidden">
            <input type="hidden" name="print" value="1">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 flex-1 overflow-hidden">
                {{-- Left Side: Siswa Selection --}}
                <div class="lg:col-span-5 flex flex-col overflow-hidden">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Siswa</label>
                    <div class="relative mb-4 flex-shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-300 text-sm"></i>
                        </div>
                        <input type="text" x-model="searchSiswa" placeholder="Cari nama atau kelas..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                    </div>
                    
                    <div class="flex-1 overflow-y-auto pr-2 space-y-2 custom-scrollbar">
                        <template x-for="siswa in filteredSiswas" :key="siswa.id">
                            <label class="block cursor-pointer group">
                                <input type="radio" name="siswa_id" :value="siswa.id" required class="hidden peer" x-model="selectedSiswaId">
                                <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 bg-gray-50/30 peer-checked:bg-emerald-600 peer-checked:border-emerald-700 peer-checked:shadow-lg peer-checked:scale-[1.01] transition-all group-hover:bg-gray-50">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 shadow-sm" :class="selectedSiswaId == siswa.id ? 'text-emerald-600' : 'text-gray-400'">
                                        <i class="fas fa-user-graduate"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black transition-colors" :class="selectedSiswaId == siswa.id ? 'text-white' : 'text-gray-700'" x-text="siswa.nama"></p>
                                        <p class="text-[10px] font-bold uppercase tracking-tighter transition-colors" :class="selectedSiswaId == siswa.id ? 'text-emerald-100' : 'text-gray-400'" x-text="siswa.kelas ? siswa.kelas.nama_kelas : 'Tanpa Kelas'"></p>
                                    </div>
                                    <div x-show="selectedSiswaId == siswa.id" class="px-3 py-1 bg-white/20 rounded-lg border border-white/20">
                                        <i class="fas fa-check text-white text-[10px]"></i>
                                    </div>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
                
                {{-- Right Side: Details Form --}}
                <div class="lg:col-span-7 flex flex-col gap-6 overflow-y-auto pr-2 custom-scrollbar">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Waktu Pertemuan</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar-day text-gray-300"></i>
                                    </div>
                                    <input type="date" name="tanggal" required class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-clock text-gray-300"></i>
                                    </div>
                                    <input type="time" name="waktu" required class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alasan / Keperluan Pemanggilan</label>
                            <textarea name="alasan" required rows="4" class="w-full px-5 py-4 bg-gray-50 border border-gray-100 rounded-3xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-none" placeholder="Jelaskan alasan pemanggilan orang tua (Contoh: Menindaklanjuti ketidakhadiran siswa tanpa keterangan selama 3 hari berturut-turut...)"></textarea>
                        </div>

                        <div class="md:col-span-2 p-5 bg-blue-50/50 rounded-3xl border border-blue-100/50">
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                <div>
                                    <h4 class="text-[11px] font-black text-blue-900 uppercase tracking-widest mb-1">Informasi Cetak</h4>
                                    <p class="text-[10px] text-blue-600/70 font-bold leading-relaxed uppercase tracking-tight">Surat akan menggunakan Kop Resmi SMK Negeri 7 Purworejo secara otomatis. Pastikan data siswa dan waktu sudah tepat sebelum mencetak.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-50 flex flex-col md:flex-row items-center justify-between sticky bottom-0 bg-white gap-4">
                        <button type="button" @click="window.history.back()" class="w-full md:w-auto px-8 py-4 text-gray-400 font-black text-[10px] uppercase tracking-widest hover:text-gray-600 transition-colors">
                            Kembali
                        </button>
                        <button type="submit" class="w-full md:w-auto bg-emerald-600 text-white font-black py-4 px-12 rounded-2xl shadow-lg hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center gap-3 text-xs uppercase tracking-widest">
                            <i class="fas fa-print text-sm"></i> Cetak Undangan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #cbd5e1;
}
</style>
@endsection
