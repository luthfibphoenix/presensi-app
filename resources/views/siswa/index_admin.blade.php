@extends('layout.app')

@section('title', 'Database Siswa')

@section('content')
<div class="h-full flex flex-col gap-6 overflow-hidden">
    {{-- Search & Filter Section --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-6 flex-shrink-0">
        <form action="{{ route('siswa.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Cari Nama atau Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-300">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data siswa..." 
                           class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Filter Kelas</label>
                <select name="kelas_id" onchange="this.form.submit()" class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full bg-blue-600 text-white font-black py-3.5 px-6 rounded-2xl shadow-lg hover:bg-blue-700 active:scale-95 transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-widest">
                    <i class="fas fa-filter"></i> Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- Data Table Section --}}
    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm flex-1 flex flex-col overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                    <i class="fas fa-users text-sm"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-tight">Daftar Siswa</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $siswas->total() }} Total Siswa</p>
                </div>
            </div>
        </div>

        <div class="flex-1 overflow-auto no-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 bg-gray-50/80 backdrop-blur-md z-10">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">No</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Nama Lengkap</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Kelas</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Username</th>
                        <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-100">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($siswas as $index => $siswa)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4 text-xs font-bold text-gray-400">
                            {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 font-black text-[10px] group-hover:bg-white transition-colors">
                                    {{ substr($siswa->nama, 0, 1) }}
                                </div>
                                <span class="text-xs font-black text-gray-800">{{ $siswa->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-[10px] font-black rounded-lg uppercase tracking-wider">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-500">{{ $siswa->username }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black rounded-lg uppercase tracking-wider border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Aktif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center opacity-20">
                                <i class="fas fa-folder-open text-4xl mb-4"></i>
                                <p class="text-xs font-black uppercase tracking-widest">Tidak ada data ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswas->hasPages())
        <div class="p-6 border-t border-gray-50 bg-gray-50/30 flex-shrink-0">
            {{ $siswas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
