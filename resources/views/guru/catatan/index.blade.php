@extends('layout.app')

@section('title', 'Catatan Siswa')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="{ 
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
        <form action="{{ route('guru.catatan.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-2xl border border-gray-100 shadow-sm">
            <select name="kelas_id" onchange="this.form.submit()" class="bg-gray-50 border-none rounded-xl px-4 py-2 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 outline-none cursor-pointer">
                <option value="">Semua Kelas</option>
                @foreach($availableKelas as $k)
                <option value="{{ $k->id }}" {{ $selectedKelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-1">
                <i class="fas fa-filter text-xs"></i>
            </div>
        </form>
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
                <button @click="openModal('{{ $siswa->id }}', '{{ $siswa->nama }}')" class="w-10 h-10 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
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

    <!-- Modal Add Note -->
    <div x-show="showModal" x-transition.opacity class="fixed inset-0 z-[70] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
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
                
                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Kategori</label>
                    <select name="kategori" required class="w-full px-4 py-3 rounded-2xl bg-gray-50 border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm">
                        <option value="Perilaku">Perilaku</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Prestasi">Prestasi</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Judul Catatan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Terlambat Mengumpulkan Tugas" class="w-full px-4 py-3 rounded-2xl bg-gray-50 border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm">
                </div>

                <div>
                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Isi Catatan</label>
                    <textarea name="isi" required rows="4" placeholder="Tuliskan detail catatan di sini..." class="w-full px-4 py-3 rounded-2xl bg-gray-50 border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm"></textarea>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showModal = false" class="flex-1 py-3.5 rounded-2xl font-black text-gray-400 hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Batal</button>
                    <button type="submit" class="flex-1 py-3.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black transition-all shadow-lg shadow-blue-200 uppercase tracking-widest text-xs">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
