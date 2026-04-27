@extends('layout.app')

@section('title', 'Generate QR Presensi')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10 mb-8">
    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-800 leading-tight">Mulai Sesi Kelas</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Input Detail Pelajaran Hari Ini</p>
    </div>
    
    <form action="{{ route('guru.qr.generate') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kelas --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kelas</label>
                    <select name="kelas" required
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base appearance-none">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Mapel --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Mata Pelajaran</label>
                    <input type="text" name="mata_pelajaran" list="mapel-list" 
                           value="{{ $defaultMapel }}"
                           placeholder="Ketik Mapel..." required
                           class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base">
                    <datalist id="mapel-list">
                        @foreach($historyMapels as $m)
                            <option value="{{ $m->mata_pelajaran }}">
                        @endforeach
                    </datalist>
                </div>

                {{-- Jam Ke --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Mulai</label>
                    <select name="jam_mulai" required
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}">Jam Ke-{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jam Selesai</label>
                    <select name="jam_selesai" required
                            class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 focus:border-blue-500 focus:bg-white outline-none transition-all font-bold text-base">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>Jam Ke-{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-5 rounded-[2rem] shadow-xl shadow-blue-100 transition-all uppercase tracking-[0.3em] text-xs active:scale-95">
            <i class="fas fa-qrcode mr-2 opacity-50"></i> Generate QR Code
        </button>
    </form>
</div>

@if(session('success'))
<div class="bg-white rounded-lg shadow overflow-hidden p-6 text-center">
    <h3 class="text-xl font-bold text-gray-900 mb-2">QR Code Presensi Aktif</h3>
    <p class="mb-6 text-gray-600">Minta siswa Anda untuk memindai QR Code di bawah ini.</p>
    
    <!-- Div for QRCode.js to render the QR Code -->
    <div id="qrcode" class="flex justify-center mb-6"></div>
    
    <p class="text-md font-bold text-red-600 mb-4"><i class="fas fa-clock mr-1"></i> QR Code ini hanya berlaku selama 15 menit.</p>
    
    <div class="mt-4">
        <a href="{{ route('guru.qr.status', session('jadwal_id')) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
            <i class="fas fa-users mr-2"></i> Pantau Siswa Hadir
        </a>
    </div>
</div>

@push('scripts')
<!-- Load QRCode.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Text/URL to encode inside the QR
        var qrUrl = "{{ session('url') }}";
        
        // Generate QR code
        new QRCode(document.getElementById("qrcode"), {
            text: qrUrl,
            width: 300,
            height: 300,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    });
</script>
@endpush
@endif

@endsection
