@extends('layout.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="space-y-8">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl shadow-lg p-10 text-white flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl font-bold mb-3">Halo, {{ auth('siswa')->user()->nama }}!</h1>
            <p class="text-emerald-50 mb-8 max-w-xl text-sm leading-relaxed opacity-90">Pantau kehadiranmu dan ajukan izin dengan mudah. Jangan lupa untuk selalu melakukan scan QR saat pelajaran dimulai.</p>
            
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('presensi.scan') }}" class="bg-white text-emerald-700 hover:bg-emerald-50 font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center gap-3">
                    <i class="fas fa-qrcode text-lg"></i>
                    Scan QR Sekarang
                </a>
                <a href="{{ route('siswa.riwayat') }}" class="bg-emerald-500/50 hover:bg-emerald-500/70 text-white border border-emerald-400 font-bold py-3 px-8 rounded-xl transition-all backdrop-blur-sm flex items-center gap-3">
                    <i class="fas fa-history text-lg"></i>
                    Lihat Riwayat
                </a>
            </div>
        </div>
        <div class="hidden lg:block relative z-10 opacity-20">
            <i class="fas fa-user-graduate text-[180px]"></i>
        </div>
        <!-- Decorative subtle pattern -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-12 transform origin-right"></div>
    </div>

    @php
        $siswa = auth('siswa')->user();
        $totalHadir = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
        $totalTerlambat = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Terlambat')->count();
        $totalAlfa = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Alfa')->count();
        $totalIzinSakit = \App\Models\Presensi::where('siswa_id', $siswa->id)->whereIn('status', ['Izin', 'Sakit'])->count();
    @endphp

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Hadir</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalHadir }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Terlambat</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalTerlambat }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Alfa</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalAlfa }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <i class="fas fa-info-circle text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Izin/Sakit</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalIzinSakit }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex items-start gap-6">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                <i class="fas fa-lightbulb text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Informasi Penting</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Pastikan kamu melakukan absensi dalam kurun waktu 15 menit pertama sejak jam pelajaran dimulai agar status kehadiranmu tercatat sebagai <strong>Hadir</strong>. Jika lebih dari itu, sistem akan otomatis mencatat kamu sebagai <strong>Terlambat</strong>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
