@extends('layout.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="h-full overflow-y-auto no-scrollbar pb-10 space-y-8">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 rounded-[2rem] shadow-xl p-6 md:p-10 text-white relative overflow-hidden">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest mb-4 border border-white/30">
                <i class="fas fa-school text-[8px]"></i>
                Kelas {{ auth('siswa')->user()->kelas->nama_kelas ?? 'N/A' }}
            </div>
            <h1 class="text-2xl md:text-4xl font-black mb-2 leading-tight">Halo, {{ explode(' ', auth('siswa')->user()->nama)[0] }}! 👋</h1>
            <p class="text-emerald-50 mb-6 md:mb-8 max-w-xl text-[11px] md:text-sm leading-relaxed opacity-90 font-medium">Jangan lupa untuk selalu melakukan scan QR saat pelajaran dimulai tepat waktu ya!</p>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('presensi.scan') }}" class="bg-white text-emerald-700 hover:scale-105 active:scale-95 font-black py-3 px-8 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-3 text-sm">
                    <i class="fas fa-qrcode text-lg"></i>
                    Scan QR
                </a>
            </div>
        </div>
        
        <!-- Decorative subtle pattern -->
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-400/20 rounded-full blur-3xl"></div>
    </div>

    @php
        $siswa = auth('siswa')->user();
        $totalHadir = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
        $totalTerlambat = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Terlambat')->count();
        $totalAlfa = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Alfa')->count();
        $totalIzinSakit = \App\Models\Presensi::where('siswa_id', $siswa->id)->whereIn('status', ['Izin', 'Sakit'])->count();
    @endphp

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6">
        <div class="bg-white rounded-3xl shadow-sm p-4 md:p-6 border border-gray-100 flex flex-col items-center justify-center text-center group hover:bg-emerald-50 transition-colors">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-2 group-hover:bg-white transition-colors">
                <i class="fas fa-calendar-check text-sm md:text-lg"></i>
            </div>
            <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Hadir</p>
            <h3 class="text-lg md:text-2xl font-black text-gray-800">{{ $totalHadir }}</h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm p-4 md:p-6 border border-gray-100 flex flex-col items-center justify-center text-center group hover:bg-amber-50 transition-colors">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-2 group-hover:bg-white transition-colors">
                <i class="fas fa-clock text-sm md:text-lg"></i>
            </div>
            <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Telat</p>
            <h3 class="text-lg md:text-2xl font-black text-gray-800">{{ $totalTerlambat }}</h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm p-4 md:p-6 border border-gray-100 flex flex-col items-center justify-center text-center group hover:bg-red-50 transition-colors">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center mb-2 group-hover:bg-white transition-colors">
                <i class="fas fa-times-circle text-sm md:text-lg"></i>
            </div>
            <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Alfa</p>
            <h3 class="text-lg md:text-2xl font-black text-gray-800">{{ $totalAlfa }}</h3>
        </div>

        <div class="bg-white rounded-3xl shadow-sm p-4 md:p-6 border border-gray-100 flex flex-col items-center justify-center text-center group hover:bg-blue-50 transition-colors">
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-2 group-hover:bg-white transition-colors">
                <i class="fas fa-info-circle text-sm md:text-lg"></i>
            </div>
            <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Izin</p>
            <h3 class="text-lg md:text-2xl font-black text-gray-800">{{ $totalIzinSakit }}</h3>
        </div>
    </div>

    {{-- Jadwal Hari Ini --}}
    <div class="animate-page-content" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between mb-4 px-2">
            <h2 class="text-sm font-black text-gray-800 uppercase tracking-wider">Jadwal Hari Ini</h2>
            <div class="flex items-center gap-2 text-[9px] font-black text-gray-400 bg-gray-100 px-3 py-1.5 rounded-full uppercase tracking-widest">
                <i class="far fa-calendar-alt text-emerald-500"></i>
                {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>
        
        <div class="space-y-4">
            @forelse($jadwals as $jadwal)
                @php
                    $presensi = $presensis->get($jadwal->id);
                    $status = $presensi ? $presensi->status : 'Belum Absen';
                    $colorClass = match($status) {
                        'Hadir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                        'Terlambat' => 'bg-amber-50 text-amber-600 border-amber-100',
                        'Izin', 'Sakit' => 'bg-blue-50 text-blue-600 border-blue-100',
                        'Alfa' => 'bg-red-50 text-red-600 border-red-100',
                        default => 'bg-gray-50 text-gray-400 border-gray-200'
                    };
                @endphp
                @php
                    $waktuMulaiStr = jamPelajaranToWaktu($jadwal->jam_mulai);
                    $waktuSelesaiStr = jamPelajaranToWaktu($jadwal->jam_selesai + 1);
                    
                    $waktuMulai = \Carbon\Carbon::createFromFormat('H:i', $waktuMulaiStr, 'Asia/Jakarta')->subMinutes(5); // 5 menit buffer
                    $waktuSelesai = \Carbon\Carbon::createFromFormat('H:i', $waktuSelesaiStr, 'Asia/Jakarta');
                    
                    $isSekarang = now('Asia/Jakarta')->between($waktuMulai, $waktuSelesai);
                    $isSudahAbsen = $status !== 'Belum Absen';
                @endphp

                @if($isSekarang && !$isSudahAbsen)
                    <a href="{{ route('presensi.scan') }}" class="group bg-white p-4 rounded-[2rem] border border-gray-100 shadow-sm active:scale-[0.98] transition-all duration-200 flex items-center justify-between hover:border-emerald-200 hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg {{ $colorClass }} border shadow-inner transition-transform group-hover:scale-110">
                                <i class="fas fa-book-reader"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-gray-800 leading-tight text-sm group-hover:text-emerald-600 transition-colors">{{ $jadwal->mata_pelajaran }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-black text-emerald-600 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">Jam {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}</span>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase">{{ jamPelajaranToWaktu($jadwal->jam_mulai) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest {{ $colorClass }} border shadow-sm">
                            {{ $status }}
                        </div>
                    </a>
                @else
                    <div class="bg-gray-50/50 p-4 rounded-[2rem] border border-gray-100 flex items-center justify-between opacity-60">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg bg-gray-100 text-gray-400 border border-gray-200">
                                @if($isSudahAbsen)
                                    <i class="fas fa-check-circle"></i>
                                @else
                                    <i class="fas fa-lock"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-black text-gray-400 leading-tight text-sm">{{ $jadwal->mata_pelajaran }}</h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest bg-gray-100 px-2 py-0.5 rounded-lg border border-gray-200">Jam {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}</span>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase">{{ jamPelajaranToWaktu($jadwal->jam_mulai) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-2 rounded-full text-[9px] font-black uppercase tracking-widest {{ $isSudahAbsen ? $colorClass : 'bg-gray-100 text-gray-400 border-gray-200' }} border">
                            {{ $status }}
                        </div>
                    </div>
                @endif
            @empty
                <div class="py-10 flex flex-col items-center justify-center text-gray-300 bg-white rounded-[2rem] border-2 border-dashed border-gray-100">
                    <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <i class="fas fa-calendar-day text-xl"></i>
                    </div>
                    <p class="font-black uppercase tracking-widest text-[10px]">Tidak ada jadwal hari ini</p>
                </div>
            @endforelse
        </div>
    </div>


    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 relative overflow-hidden">
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 flex-shrink-0">
                <i class="fas fa-lightbulb text-lg"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-gray-800 mb-1">Tips Absensi</h3>
                <p class="text-gray-500 text-[10px] leading-relaxed font-medium">
                    Lakukan absensi dalam <strong>15 menit pertama</strong> agar tercatat sebagai <strong>Hadir</strong>.
                </p>
            </div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-emerald-50 rounded-full opacity-50"></div>
    </div>
</div>
@endsection
