@extends('layout.app')

@section('title', 'Approval Izin')

@section('content')
@php
    $loginRole = session('login_role', 'guru');
    $isPiketMode = $loginRole === 'piket' || str_contains(auth()->user()->position, 'Piket');
@endphp

@if($isPiketMode)
<div class="bg-white rounded-lg shadow p-6 mb-6" x-data="{ 
    showForm: false,
    selectedKelas: '',
    allSiswas: {{ $siswas->map(fn($s) => ['id' => $s->id, 'nama' => $s->nama, 'kelas_id' => $s->kelas_id])->toJson() }}
}">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">Pencatatan Izin Piket</h3>
        <button @click="showForm = !showForm" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium transition">
            <span x-show="!showForm"><i class="fas fa-plus mr-2"></i> Tambah Data</span>
            <span x-show="showForm"><i class="fas fa-times mr-2"></i> Batal</span>
        </button>
    </div>
    
    <div x-show="showForm" x-collapse x-cloak class="mt-6 pt-6 border-t border-gray-100">
        <form action="{{ route('izin.store.guru') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @csrf
            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Kelas</label>
                <div x-data="{ 
                    open: false, 
                    selected: '',
                    selectedName: 'Pilih Kelas',
                    select(id, name) {
                        this.selected = id;
                        this.selectedName = name;
                        this.open = false;
                        $dispatch('input', id);
                        selectedKelas = id;
                    }
                }" class="relative">
                    <button type="button" @click="open = !open" 
                            class="w-full flex items-center justify-between bg-gray-50 px-5 py-3.5 rounded-2xl border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base">
                        <span x-text="selectedName"></span>
                        <i class="fas fa-chevron-down text-xs text-gray-300 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak
                         class="absolute left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden py-2 max-h-60 overflow-y-auto no-scrollbar animate-fade-in-up">
                        <template x-for="kelas in {{ $kelases->map(fn($k) => ['id' => $k->id, 'nama' => $k->nama_kelas])->toJson() }}" :key="kelas.id">
                            <button type="button" @click="select(kelas.id, kelas.nama)" 
                                    class="w-full px-5 py-3 text-left text-sm font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition"
                                    x-text="kelas.nama"></button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Siswa</label>
                <div x-data="{ 
                    open: false, 
                    selected: '',
                    selectedName: 'Pilih Siswa',
                    select(id, name) {
                        this.selected = id;
                        this.selectedName = name;
                        this.open = false;
                        document.getElementById('siswa_id_input').value = id;
                    },
                    init() {
                        $watch('selectedKelas', value => {
                            this.selected = '';
                            this.selectedName = 'Pilih Siswa';
                            document.getElementById('siswa_id_input').value = '';
                        });
                    }
                }" class="relative">
                    <input type="hidden" name="siswa_id" id="siswa_id_input" required>
                    <button type="button" @click="if(selectedKelas) open = !open" 
                            :class="!selectedKelas ? 'opacity-50 cursor-not-allowed' : ''"
                            class="w-full flex items-center justify-between bg-gray-50 px-5 py-3.5 rounded-2xl border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base">
                        <span x-text="selectedName"></span>
                        <i class="fas fa-chevron-down text-xs text-gray-300 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak
                         class="absolute left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden py-2 max-h-60 overflow-y-auto no-scrollbar animate-fade-in-up">
                        <template x-for="siswa in allSiswas.filter(s => s.kelas_id == selectedKelas)" :key="siswa.id">
                            <button type="button" @click="select(siswa.id, siswa.nama)" 
                                    class="w-full px-5 py-3 text-left text-sm font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition"
                                    x-text="siswa.nama"></button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Tipe Keterangan</label>
                <div x-data="{ 
                    open: false, 
                    selected: 'Masuk Telat',
                    selectedName: 'Masuk Telat (Terlambat)',
                    select(val, name) {
                        this.selected = val;
                        this.selectedName = name;
                        this.open = false;
                        document.getElementById('tipe_input').value = val;
                    }
                }" class="relative">
                    <input type="hidden" name="tipe" id="tipe_input" value="Masuk Telat">
                    <button type="button" @click="open = !open" 
                            class="w-full flex items-center justify-between bg-gray-50 px-5 py-3.5 rounded-2xl border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base">
                        <span x-text="selectedName"></span>
                        <i class="fas fa-chevron-down text-xs text-gray-300 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak
                         class="absolute left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-gray-100 z-50 overflow-hidden py-2 animate-fade-in-up">
                        <button type="button" @click="select('Masuk Telat', 'Masuk Telat (Terlambat)')" 
                                class="w-full px-5 py-3 text-left text-sm font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition">Masuk Telat (Terlambat)</button>
                        <button type="button" @click="select('Keluar Sekolah', 'Izin Keluar Sekolah')" 
                                class="w-full px-5 py-3 text-left text-sm font-bold text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition">Izin Keluar Sekolah</button>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" 
                    class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl px-5 py-3.5 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1 mb-2">Alasan / Catatan</label>
                <input type="text" name="alasan" placeholder="Contoh: Ban bocor / Izin ke Puskesmas" 
                    class="w-full bg-gray-50 border-2 border-gray-50 rounded-2xl px-5 py-3.5 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base" required>
            </div>
            <div class="lg:col-span-3 flex justify-end pt-2">
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black shadow-lg shadow-blue-100 transition-all uppercase tracking-widest text-xs">
                    Simpan Data Izin
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Daftar Pengajuan Izin Siswa</h3>
    </div>
    
    {{-- Desktop View --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($izins as $izin)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}</div>
                        @if($izin->created_at)
                            <div class="text-[10px] font-bold text-blue-500 uppercase tracking-tighter">{{ $izin->created_at->format('H:i') }} WIB</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                        {{ $izin->siswa->nama ?? 'Unknown' }}
                        <div class="text-xs text-gray-500">{{ $izin->siswa->kelas->nama_kelas ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                            @if($izin->tipe == 'Masuk Telat') bg-orange-100 text-orange-700
                            @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-100 text-purple-700
                            @elseif($izin->tipe == 'Sakit') bg-red-100 text-red-700
                            @else bg-blue-100 text-blue-700
                            @endif">
                            {{ $izin->tipe }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                        {{ $izin->alasan }}
                        @if($izin->bukti)
                            <div class="mt-1">
                                <a href="{{ asset($izin->bukti) }}" target="_blank" class="inline-flex items-center text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100 hover:bg-blue-100 transition">
                                    <i class="fas fa-image mr-1"></i> LIHAT BUKTI
                                </a>
                                @if($izin->latitude && $izin->longitude)
                                    <a href="https://www.google.com/maps?q={{ $izin->latitude }},{{ $izin->longitude }}" target="_blank" class="inline-flex items-center text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100 hover:bg-emerald-100 transition ml-1">
                                        <i class="fas fa-location-dot mr-1"></i> LOKASI
                                    </a>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($izin->status == 'pending')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                        @elseif($izin->status == 'approve')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($izin->status == 'pending')
                        <div class="flex justify-end space-x-2">
                            <form action="{{ route('izin.approve', $izin->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-900 bg-green-100 hover:bg-green-200 px-2 py-1 rounded">Setujui</button>
                            </form>
                            <form action="{{ route('izin.reject', $izin->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-2 py-1 rounded">Tolak</button>
                            </form>
                        </div>
                        @elseif($izin->status == 'approve')
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('izin.print', $izin->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded flex items-center gap-1">
                                <i class="fas fa-print text-xs"></i> Cetak
                            </a>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Belum ada pengajuan izin.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Mobile View --}}
    <div class="md:hidden divide-y divide-gray-100">
        @forelse($izins as $izin)
            <div class="p-5 space-y-4 hover:bg-gray-50 transition-colors">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                            {{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d F Y') }}
                            @if($izin->created_at)
                                • <span class="text-blue-500">{{ $izin->created_at->format('H:i') }} WIB</span>
                            @endif
                        </p>
                        <h4 class="text-sm font-black text-gray-900">{{ $izin->siswa->nama ?? 'Unknown' }}</h4>
                        <p class="text-xs font-bold text-gray-500">{{ $izin->siswa->kelas->nama_kelas ?? '' }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase
                        @if($izin->status == 'pending') bg-yellow-100 text-yellow-700
                        @elseif($izin->status == 'approve') bg-emerald-100 text-emerald-700
                        @else bg-rose-100 text-rose-700
                        @endif">
                        {{ $izin->status == 'pending' ? 'Menunggu' : ($izin->status == 'approve' ? 'Disetujui' : 'Ditolak') }}
                    </span>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="px-2 py-1 rounded text-[9px] font-black uppercase
                        @if($izin->tipe == 'Masuk Telat') bg-orange-100 text-orange-700
                        @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-100 text-purple-700
                        @elseif($izin->tipe == 'Sakit') bg-rose-100 text-rose-700
                        @else bg-blue-100 text-blue-700
                        @endif">
                        {{ $izin->tipe }}
                    </span>
                    @if($izin->bukti)
                        <a href="{{ asset($izin->bukti) }}" target="_blank" class="inline-flex items-center text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                            <i class="fas fa-image mr-1"></i> BUKTI
                        </a>
                    @endif
                    @if($izin->latitude && $izin->longitude)
                        <a href="https://www.google.com/maps?q={{ $izin->latitude }},{{ $izin->longitude }}" target="_blank" class="inline-flex items-center text-[9px] font-black text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">
                            <i class="fas fa-location-dot mr-1"></i> LOKASI
                        </a>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 italic text-xs text-gray-600">
                    "{{ $izin->alasan }}"
                </div>

                <div class="flex items-center gap-2 pt-2">
                    @if($izin->status == 'pending')
                        <form action="{{ route('izin.approve', $izin->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-emerald-100">Setujui</button>
                        </form>
                        <form action="{{ route('izin.reject', $izin->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-white text-rose-600 border border-rose-100 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest">Tolak</button>
                        </form>
                    @elseif($izin->status == 'approve')
                        <a href="{{ route('izin.print', $izin->id) }}" target="_blank" class="w-full bg-blue-50 text-blue-600 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest text-center border border-blue-100">
                            <i class="fas fa-print mr-2"></i> Cetak Surat
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">Belum ada pengajuan izin.</p>
            </div>
        @endforelse
    </div>
    
    @if($izins->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $izins->links() }}
    </div>
    @endif
</div>
@endsection
