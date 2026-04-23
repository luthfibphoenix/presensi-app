@extends('layout.app')

@section('title', 'Dashboard Siswa')

@section('content')
@php
    $siswa = auth('siswa')->user();
    
    // Status Hari Ini & Mapel Sekarang
    $hariMap = [
        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu',
    ];
    $hariIni = $hariMap[date('l')];
    $jamSekarang = now('Asia/Jakarta')->format('H:i');
    
    // Ambil jadwal hari ini
    $jadwalHariIni = \App\Models\Jadwal::where('kelas', $siswa->kelas->nama_kelas)
        ->where('hari', $hariIni)
        ->get();

    $mapelSekarang = null;
    $statusAbsenHariIni = false;
    
    foreach($jadwalHariIni as $j) {
        $waktuMulaiStr = jamPelajaranToWaktu($j->jam_mulai);
        $waktuSelesaiStr = jamPelajaranToWaktu($j->jam_selesai + 1);
        
        $waktuMulai = \Carbon\Carbon::createFromFormat('H:i', $waktuMulaiStr, 'Asia/Jakarta');
        $waktuSelesai = \Carbon\Carbon::createFromFormat('H:i', $waktuSelesaiStr, 'Asia/Jakarta');
        
        if (now('Asia/Jakarta')->between($waktuMulai->copy()->subMinutes(5), $waktuSelesai)) {
            $mapelSekarang = $j;
            $mapelSekarang->waktu_mulai = $waktuMulaiStr;
            $mapelSekarang->batas_scan = $waktuMulai->copy()->addMinutes(15)->format('H:i');
            break;
        }
    }

    // Cek apakah sudah absen hari ini
    $presensiHariIni = \App\Models\Presensi::where('siswa_id', $siswa->id)
        ->whereDate('tanggal', today())
        ->exists();
    
    // Stats
    $totalHadir = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Hadir')->count();
    $totalTerlambat = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Terlambat')->count();
    $totalAlfa = \App\Models\Presensi::where('siswa_id', $siswa->id)->where('status', 'Alfa')->count();
    $totalIzinSakit = \App\Models\Presensi::where('siswa_id', $siswa->id)->whereIn('status', ['Izin', 'Sakit'])->count();
    
    $totalPertemuan = $totalHadir + $totalTerlambat + $totalAlfa + $totalIzinSakit;
    $persentaseKehadiran = $totalPertemuan > 0 ? round((($totalHadir + $totalTerlambat) / $totalPertemuan) * 100) : 0;
    
    $progressBarColor = 'bg-red-500';
    if($persentaseKehadiran >= 80) $progressBarColor = 'bg-emerald-500';
    elseif($persentaseKehadiran >= 60) $progressBarColor = 'bg-yellow-500';
@endphp

<div class="pb-24 space-y-5" x-data="{ 
    showSuccess: {{ session('success') ? 'true' : 'false' }},
    showError: {{ session('error') ? 'true' : 'false' }},
    showInfo: {{ session('info') ? 'true' : 'false' }},
    init() {
        if(this.showSuccess || this.showError || this.showInfo) {
            setTimeout(() => { this.showSuccess = false; this.showError = false; this.showInfo = false; }, 3000);
        }
    }
}">
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-br from-emerald-600 via-emerald-500 to-teal-500 rounded-[2rem] shadow-xl p-6 md:p-10 text-white relative overflow-hidden">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-[10px] font-black uppercase tracking-widest mb-4 border border-white/30">
                <i class="fas fa-school text-[8px]"></i>
                 {{ $siswa->kelas->nama_kelas ?? 'N/A' }}
            </div>
            <h1 class="text-2xl md:text-3xl font-black mb-2 leading-tight tracking-tight">Halo, {{ explode(' ', $siswa->nama)[0] }}! 👋</h1>
            <p class="text-emerald-50 text-[11px] leading-relaxed opacity-90 font-bold">Jangan lupa untuk selalu melakukan scan QR saat pelajaran dimulai tepat waktu ya!</p>
        </div>
        <!-- Decorative subtle pattern -->
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-emerald-400/20 rounded-full blur-3xl"></div>
    </div>

    {{-- 1. Card Status Hari Ini (Top) --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center justify-between overflow-hidden relative">
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl {{ $presensiHariIni ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }} border-2 shadow-inner">
                <i class="fas {{ $presensiHariIni ? 'fa-check-double' : 'fa-times' }}"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Status Kehadiran</p>
                <h3 class="text-lg font-black {{ $presensiHariIni ? 'text-emerald-700' : 'text-red-700' }}">
                    {{ $presensiHariIni ? 'Sudah Absen' : 'Belum Absen' }}
                </h3>
            </div>
        </div>
        <div class="text-right relative z-10">
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">{{ now()->translatedFormat('l') }}</span>
            <p class="text-xs font-black text-gray-800">{{ now()->translatedFormat('d M Y') }}</p>
        </div>
        <div class="absolute -right-6 -bottom-6 w-24 h-24 {{ $presensiHariIni ? 'bg-emerald-50' : 'bg-red-50' }} rounded-full opacity-40 blur-2xl"></div>
    </div>

    {{-- 2. Card Mapel Sekarang --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                Pelajaran Saat Ini
            </h3>
            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-2 py-1 rounded-lg border border-blue-100 uppercase">Live</span>
        </div>

        @if($mapelSekarang)
            <div class="space-y-4">
                <div>
                    <h2 class="text-xl font-black text-gray-900 leading-tight mb-1">{{ $mapelSekarang->mata_pelajaran }}</h2>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Bersama {{ $mapelSekarang->user->fullname ?? 'Guru Pengampu' }}</p>
                </div>
                
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-2xl p-3 border border-gray-100">
                        <p class="text-[8px] font-black text-gray-400 uppercase mb-1">Mulai</p>
                        <p class="text-sm font-black text-gray-800">{{ $mapelSekarang->waktu_mulai }}</p>
                    </div>
                    <div class="bg-amber-50 rounded-2xl p-3 border border-amber-100">
                        <p class="text-[8px] font-black text-amber-500 uppercase mb-1">Batas Scan</p>
                        <p class="text-sm font-black text-amber-700">{{ $mapelSekarang->batas_scan }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="py-4 text-center">
                <i class="fas fa-coffee text-2xl text-gray-200 mb-2"></i>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">Tidak ada pelajaran saat ini</p>
            </div>
        @endif
    </div>

    {{-- 3. List Mapel Hari Ini --}}
    <div class="space-y-3">
        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1 flex items-center gap-2">
            <i class="fas fa-calendar-day text-emerald-500"></i>
            Jadwal Hari Ini
        </h3>
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 divide-y divide-gray-50 overflow-hidden">
            @forelse($jadwals as $j)
                @php
                    $isNow = $mapelSekarang && $mapelSekarang->id === $j->id;
                    $statusAbsen = $presensis->get($j->id);
                @endphp
                <div class="p-4 flex items-center gap-4 {{ $isNow ? 'bg-emerald-50/50' : '' }}">
                    <div class="w-10 h-10 rounded-xl flex-shrink-0 flex items-center justify-center text-xs font-black {{ $isNow ? 'bg-emerald-100 text-emerald-600' : 'bg-gray-50 text-gray-400' }} border {{ $isNow ? 'border-emerald-200' : 'border-gray-100' }}">
                        JP {{ $j->jam_mulai }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-black text-gray-800 truncate">{{ $j->mata_pelajaran }}</h4>
                        <p class="text-[9px] font-bold text-gray-400 uppercase truncate">{{ $j->user->fullname ?? 'Guru Pengampu' }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        @if($statusAbsen)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-black uppercase {{ $statusAbsen->status === 'Hadir' ? 'bg-emerald-100 text-emerald-600' : ($statusAbsen->status === 'Terlambat' ? 'bg-amber-100 text-amber-600' : 'bg-red-100 text-red-600') }}">
                                <i class="fas {{ $statusAbsen->status === 'Hadir' ? 'fa-check' : ($statusAbsen->status === 'Terlambat' ? 'fa-clock' : 'fa-times') }}"></i>
                                {{ $statusAbsen->status }}
                            </span>
                        @elseif($isNow)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-600 text-[8px] font-black uppercase animate-pulse">
                                Sedang Berlangsung
                            </span>
                        @else
                            <span class="text-[9px] font-bold text-gray-300 uppercase tracking-tighter">
                                {{ jamPelajaranToWaktu($j->jam_mulai) }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <p class="text-xs font-bold text-gray-400 uppercase italic">Tidak ada jadwal hari ini</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- 4. Stat Cards & Progress Bar --}}
    <div class="space-y-4">
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-emerald-600 rounded-3xl p-4 shadow-lg shadow-emerald-100 text-white flex flex-col justify-between h-28 relative overflow-hidden">
                <i class="fas fa-user-check absolute -right-2 -bottom-2 text-5xl opacity-10"></i>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Hadir</p>
                <h4 class="text-3xl font-black">{{ $totalHadir }}</h4>
            </div>
            <div class="bg-amber-500 rounded-3xl p-4 shadow-lg shadow-amber-100 text-white flex flex-col justify-between h-28 relative overflow-hidden">
                <i class="fas fa-clock absolute -right-2 -bottom-2 text-5xl opacity-10"></i>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Terlambat</p>
                <h4 class="text-3xl font-black">{{ $totalTerlambat }}</h4>
            </div>
            <div class="bg-red-600 rounded-3xl p-4 shadow-lg shadow-red-100 text-white flex flex-col justify-between h-28 relative overflow-hidden">
                <i class="fas fa-user-times absolute -right-2 -bottom-2 text-5xl opacity-10"></i>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Alfa</p>
                <h4 class="text-3xl font-black">{{ $totalAlfa }}</h4>
            </div>
            <div class="bg-blue-600 rounded-3xl p-4 shadow-lg shadow-blue-100 text-white flex flex-col justify-between h-28 relative overflow-hidden">
                <i class="fas fa-envelope absolute -right-2 -bottom-2 text-5xl opacity-10"></i>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80">Izin/Sakit</p>
                <h4 class="text-3xl font-black">{{ $totalIzinSakit }}</h4>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Persentase Kehadiran</h4>
                <span class="text-xs font-black text-gray-800">{{ $persentaseKehadiran }}%</span>
            </div>
            <div class="h-3 w-full bg-gray-100 rounded-full overflow-hidden p-0.5 border border-gray-50">
                <div class="h-full {{ $progressBarColor }} rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $persentaseKehadiran }}%"></div>
            </div>
        </div>
    </div>



    {{-- Feedback Modals --}}
    <template x-if="showSuccess">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[2.5rem] p-8 max-w-xs w-full text-center shadow-2xl border-4 border-emerald-500">
                <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Berhasil!</h3>
                <p class="text-sm font-bold text-gray-500 leading-relaxed">{{ session('success') }}</p>
            </div>
        </div>
    </template>

    <template x-if="showError">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[2.5rem] p-8 max-w-xs w-full text-center shadow-2xl border-4 border-red-500">
                <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Gagal!</h3>
                <p class="text-sm font-bold text-gray-500 leading-relaxed">{{ session('error') }}</p>
            </div>
        </div>
    </template>

    <template x-if="showInfo">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[2.5rem] p-8 max-w-xs w-full text-center shadow-2xl border-4 border-blue-500">
                <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    <i class="fas fa-info-circle"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-2">Info</h3>
                <p class="text-sm font-bold text-gray-500 leading-relaxed">{{ session('info') }}</p>
            </div>
        </div>
    </template>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
