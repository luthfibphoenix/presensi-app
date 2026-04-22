@extends('layout.app')

@section('title', 'Surat Perjalanan Dinas')

@section('content')
<div class="h-[calc(100vh-10rem)] flex flex-col gap-6 overflow-hidden">
    <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm p-8 flex-1 flex flex-col overflow-hidden" x-data="{
        searchGuru: '',
        selectedGuru: null,
        gurus: {{ json_encode($gurus) }},
        get filteredGurus() {
            if (this.searchGuru === '') return this.gurus;
            return this.gurus.filter(g => g.fullname.toLowerCase().includes(this.searchGuru.toLowerCase()) || 
                                         (g.position && g.position.toLowerCase().includes(this.searchGuru.toLowerCase())));
        }
    }">
        <div class="flex items-center gap-4 mb-8 flex-shrink-0">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                <i class="fas fa-plane-departure text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-800 uppercase tracking-tight">Buat Surat Perjalanan Dinas (SPD)</h2>
                <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Lengkapi formulir untuk mencetak surat tugas</p>
            </div>
        </div>

        <form action="{{ route('tu.surat_dinas') }}" target="_blank" method="GET" class="flex-1 flex flex-col overflow-hidden">
            <input type="hidden" name="print" value="1">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 flex-1 overflow-hidden">
                {{-- Left Side: Guru Selection --}}
                <div class="lg:col-span-5 flex flex-col overflow-hidden">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Pilih Pegawai / Guru</label>
                    <div class="relative mb-4">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-300 text-sm"></i>
                        </div>
                        <input type="text" x-model="searchGuru" placeholder="Cari nama atau jabatan..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                    </div>
                    
                    <div class="flex-1 overflow-y-auto pr-2 no-scrollbar space-y-2">
                        <template x-for="guru in filteredGurus" :key="guru.id">
                            <label class="block cursor-pointer group">
                                <input type="radio" name="guru_id" :value="guru.id" required class="hidden peer">
                                <div class="flex items-center gap-4 p-4 rounded-2xl border border-gray-50 bg-gray-50/30 peer-checked:bg-blue-50 peer-checked:border-blue-200 peer-checked:shadow-sm transition-all group-hover:bg-gray-50">
                                    <div class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 peer-checked:text-blue-600 transition-colors">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-black text-gray-700 peer-checked:text-blue-900" x-text="guru.fullname"></p>
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter" x-text="guru.position || '-'"></p>
                                    </div>
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:border-blue-500 peer-checked:bg-blue-500">
                                        <i class="fas fa-check text-[10px] text-white"></i>
                                    </div>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
                
                {{-- Right Side: Details Form --}}
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Tujuan Perjalanan</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-gray-300"></i>
                                </div>
                                <input type="text" name="tujuan" required class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" placeholder="Contoh: Kantor Cabang Dinas Pontianak">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Tgl Berangkat</label>
                                <input type="date" name="tanggal_mulai" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Tgl Kembali</label>
                                <input type="date" name="tanggal_selesai" required class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Keperluan / Dasar Penugasan</label>
                            <textarea name="keperluan" required rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none resize-none" placeholder="Masukkan deskripsi tugas atau keperluan perjalanan dinas..."></textarea>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                        <div class="flex items-center gap-3 text-amber-500">
                            <i class="fas fa-exclamation-circle text-sm"></i>
                            <p class="text-[10px] font-bold uppercase tracking-tight">Pastikan semua data sudah benar sebelum dicetak.</p>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white font-black py-4 px-10 rounded-2xl shadow-lg hover:bg-blue-700 active:scale-95 transition-all flex items-center gap-3 text-xs uppercase tracking-widest">
                            <i class="fas fa-print text-sm"></i> Cetak Surat Tugas
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
