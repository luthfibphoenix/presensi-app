@extends('layout.app')

@section('title', 'Pengajuan Izin')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-7xl mx-auto space-y-6">
    {{-- Form Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 p-6 md:p-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fas fa-file-signature text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-black text-gray-900">Form Pengajuan Izin</h2>
                <p class="text-sm text-gray-500">Silakan isi detail izin atau sakit Anda.</p>
            </div>
        </div>
        
        <form action="{{ route('izin.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="tanggal" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Tanggal Izin</label>
                    <input type="date" id="tanggal" name="tanggal" min="{{ date('Y-m-d') }}" 
                           class="w-full px-5 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm shadow-sm" required>
                </div>
                
                <div>
                    <label for="tipe" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Tipe</label>
                    <select id="tipe" name="tipe" 
                            class="w-full px-5 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm shadow-sm appearance-none cursor-pointer" required>
                        <option value="Izin">Izin (Keperluan Keluarga/Lainnya)</option>
                        <option value="Sakit">Sakit</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label for="alasan" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Alasan</label>
                <textarea id="alasan" name="alasan" rows="3" 
                          class="w-full px-5 py-3.5 rounded-2xl bg-gray-50 border-2 border-gray-50 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-sm shadow-sm" 
                          placeholder="Contoh: Sakit demam / Ada keperluan keluarga mendadak" required></textarea>
            </div>
            
            <button type="submit" class="w-full md:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest text-xs">
                Ajukan Izin Sekarang
            </button>
        </form>
    </div>

    {{-- History Section --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between">
            <h3 class="font-black text-gray-900 uppercase tracking-tight">Riwayat Pengajuan</h3>
            <span class="text-[10px] font-bold text-gray-400 px-3 py-1 bg-gray-50 rounded-full">{{ $izins->count() }} Total</span>
        </div>
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Tipe</th>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Alasan</th>
                        <th class="px-8 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-8 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($izins as $izin)
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($izin->tanggal)->format('d M Y') }}</td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest
                                @if($izin->tipe == 'Masuk Telat') bg-orange-100 text-orange-700
                                @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-100 text-purple-700
                                @elseif($izin->tipe == 'Sakit') bg-red-100 text-red-700
                                @else bg-blue-100 text-blue-700
                                @endif">
                                {{ $izin->tipe }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm text-gray-500 font-medium max-w-xs truncate">{{ $izin->alasan }}</td>
                        <td class="px-8 py-5 whitespace-nowrap">
                            @if($izin->status == 'pending')
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-yellow-100 text-yellow-700">⏳ Menunggu</span>
                            @elseif($izin->status == 'approve')
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">✅ Disetujui</span>
                            @else
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-red-100 text-red-700">❌ Ditolak</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 whitespace-nowrap text-right">
                            @if($izin->status == 'approve')
                                <a href="{{ route('izin.print', $izin->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl text-xs font-bold transition-all">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center opacity-30">Belum ada riwayat izin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden divide-y divide-gray-50">
            @forelse($izins as $izin)
            <div class="p-5 space-y-3">
                <div class="flex justify-between items-start">
                    <div class="text-[10px] font-black text-blue-600 uppercase tracking-widest">
                        {{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d M Y') }}
                    </div>
                    @if($izin->status == 'pending')
                        <span class="text-[9px] font-black text-yellow-600 uppercase">⏳ Pending</span>
                    @elseif($izin->status == 'approve')
                        <span class="text-[9px] font-black text-emerald-600 uppercase">✅ Approved</span>
                    @else
                        <span class="text-[9px] font-black text-red-600 uppercase">❌ Rejected</span>
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest
                            @if($izin->tipe == 'Masuk Telat') bg-orange-100 text-orange-700
                            @elseif($izin->tipe == 'Keluar Sekolah') bg-purple-100 text-purple-700
                            @elseif($izin->tipe == 'Sakit') bg-red-100 text-red-700
                            @else bg-blue-100 text-blue-700
                            @endif">
                            {{ $izin->tipe }}
                        </span>
                    </div>
                    <p class="text-sm font-bold text-gray-800 leading-snug">{{ $izin->alasan }}</p>
                </div>
                @if($izin->status == 'approve')
                <div class="pt-2">
                    <a href="{{ route('izin.print', $izin->id) }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 bg-gray-50 text-blue-600 rounded-xl text-[10px] font-black uppercase tracking-widest border border-blue-100">
                        <i class="fas fa-print"></i> Cetak Surat Izin
                    </a>
                </div>
                @endif
            </div>
            @empty
            <div class="p-10 text-center opacity-30">
                <p class="text-xs font-black uppercase tracking-widest">Tidak ada riwayat</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
    
    @if($izins->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $izins->links() }}
    </div>
    @endif
</div>
@endsection
