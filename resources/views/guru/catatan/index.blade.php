@extends('layout.app')

@section('title', 'Catatan Siswa')

@section('content')
<div class="h-full overflow-y-auto no-scrollbar pb-20 max-w-7xl mx-auto space-y-6" x-data="{ 
    showModal: false, 
    selectedSiswa: {id: '', nama: ''},
    openModal(id, nama) {
        this.selectedSiswa = {id, nama};
        this.showModal = true;
    }
}">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900">Database Catatan Siswa</h1>
            <p class="text-sm text-gray-500">Kelola catatan perilaku, akademik, dan prestasi siswa Anda.</p>
        </div>
        
        @if($availableKelas->count() > 0)
        <div x-data="{ 
            open: false, 
            selected: '{{ $selectedKelasId ? $availableKelas->firstWhere('id', $selectedKelasId)->nama_kelas : 'Semua Kelas' }}',
            select(id, name) {
                this.selected = name;
                this.open = false;
                document.getElementById('kelas_filter_input').value = id;
                document.getElementById('kelas_filter_form').submit();
            }
        }" class="relative">
            <form id="kelas_filter_form" action="{{ route('guru.catatan.index') }}" method="GET">
                <input type="hidden" name="kelas_id" id="kelas_filter_input" value="{{ $selectedKelasId }}">
                <button type="button" @click="open = !open" 
                        class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-2xl border border-gray-100 shadow-sm hover:border-blue-300 transition-all min-w-[180px]">
                    <div class="flex-1 text-left">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Pilih Kelas</p>
                        <p class="text-sm font-black text-gray-700 leading-none" x-text="selected"></p>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-300 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                </button>
            </form>

            <div x-show="open" 
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 class="absolute right-0 mt-3 w-64 bg-white rounded-3xl shadow-2xl border border-gray-100 z-50 overflow-hidden py-2"
                 x-cloak>
                <div class="max-h-64 overflow-y-auto no-scrollbar">
                    <button @click="select('', 'Semua Kelas')" 
                            class="w-full px-5 py-3 text-left text-sm font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition">
                        Semua Kelas
                    </button>
                    @foreach($availableKelas as $k)
                    <button @click="select('{{ $k->id }}', '{{ $k->nama_kelas }}')" 
                            class="w-full px-5 py-3 text-left text-sm font-bold {{ $selectedKelasId == $k->id ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }} transition flex items-center justify-between">
                        <span>{{ $k->nama_kelas }}</span>
                        @if($selectedKelasId == $k->id)
                        <i class="fas fa-check text-[10px]"></i>
                        @endif
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Student List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($siswas as $siswa)
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-md transition-all duration-300">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600 font-black">
                        {{ substr($siswa->nama, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-black text-gray-900 leading-tight">{{ $siswa->nama }}</h3>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $siswa->kelas->nama_kelas }}</p>
                    </div>
                </div>
                <button @click="$dispatch('open-note-modal', {id: '{{ $siswa->id }}', nama: '{{ $siswa->nama }}'})" class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            
            <div class="flex-1 p-6 space-y-4 max-h-[300px] overflow-y-auto no-scrollbar">
                @forelse($siswa->catatan as $catatan)
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 group relative">
                    <div class="flex items-center justify-between mb-2">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest 
                            {{ $catatan->kategori === 'Prestasi' ? 'bg-emerald-100 text-emerald-700' : 
                               ($catatan->kategori === 'Perilaku' ? 'bg-amber-100 text-amber-700' : 
                               ($catatan->kategori === 'Akademik' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600')) }}">
                            {{ $catatan->kategori }}
                        </span>
                        <span class="text-[10px] font-bold text-gray-400">{{ $catatan->created_at->diffForHumans() }}</span>
                    </div>
                    <h4 class="font-bold text-gray-800 text-sm mb-1">{{ $catatan->judul }}</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $catatan->isi }}</p>
                    
                    <form action="{{ route('catatan.destroy', $catatan->id) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                            <i class="fas fa-trash-alt text-[10px]"></i>
                        </button>
                    </form>
                </div>
                @empty
                <div class="h-full flex flex-col items-center justify-center py-10 opacity-30">
                    <i class="fas fa-clipboard text-2xl mb-2"></i>
                    <p class="text-xs font-bold text-center">Belum ada catatan</p>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>

    @push('modals')
    <!-- Modal Add Note -->
    <div x-data="{ 
            showModal: false, 
            selectedSiswa: {id: '', nama: ''} 
         }" 
         x-show="showModal" 
         x-on:open-note-modal.window="selectedSiswa = $event.detail; showModal = true"
         x-transition.opacity 
         class="fixed inset-0 z-[100] bg-gray-900/60 backdrop-blur-md flex items-center justify-center p-4" 
         x-cloak>
        <div @click.outside="showModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-fade-in-up">
            <div class="p-6 bg-blue-600 text-white flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black">Tambah Catatan</h3>
                    <p class="text-sm text-blue-100" x-text="'Siswa: ' + selectedSiswa.nama"></p>
                </div>
                <button @click="showModal = false" class="text-white/50 hover:text-white transition">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form action="{{ route('catatan.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="siswa_id" :value="selectedSiswa.id">
                
                <x-select-modern 
                    name="kategori" 
                    label="Kategori" 
                    :options="[
                        'Perilaku' => 'Perilaku',
                        'Akademik' => 'Akademik',
                        'Prestasi' => 'Prestasi',
                        'Lainnya' => 'Lainnya'
                    ]" 
                    selected="Perilaku"
                    required
                />

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Judul Catatan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Terlambat Mengumpulkan Tugas" class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-sm text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Isi Catatan</label>
                    <textarea name="isi" required rows="4" placeholder="Tuliskan detail catatan di sini..." class="w-full px-5 py-3.5 bg-gray-50 border-2 border-gray-50 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-bold text-sm text-gray-700"></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showModal = false" class="flex-1 py-3.5 rounded-2xl font-black text-gray-400 hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Batal</button>
                    <button type="submit" class="flex-1 py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black transition-all shadow-lg shadow-blue-200 uppercase tracking-widest text-xs">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endpush
</div>
@endsection
