@extends('layout.app')

@php
    $aksen = 'teal-600';
@endphp

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
    if($persentaseKehadiran >= 80) $progressBarColor = 'bg-gradient-to-r from-emerald-500 to-teal-500';
    elseif($persentaseKehadiran >= 60) $progressBarColor = 'bg-gradient-to-r from-amber-500 to-orange-500';
@endphp

{{-- Custom Style Block for Modern Effects --}}
<style>
    .glass-card-premium {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .neon-glow-teal {
        box-shadow: 0 0 20px rgba(13, 148, 136, 0.15);
    }
    .mesh-gradient-student {
        background: radial-gradient(at 0% 0%, rgba(20, 184, 166, 0.15) 0px, transparent 50%),
                    radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.08) 0px, transparent 50%),
                    #f8fafc;
    }
    .timeline-line::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 20px;
        width: 2px;
        background: #e2e8f0;
    }
</style>

<div class="pb-24 space-y-6 mesh-gradient-student min-h-screen -m-6 md:-m-8 p-6 md:p-8" x-data="{ 
    showSuccess: {{ session('success') ? 'true' : 'false' }},
    showError: {{ session('error') ? 'true' : 'false' }},
    showInfo: {{ session('info') ? 'true' : 'false' }},
    init() {
        if(this.showSuccess || this.showError || this.showInfo) {
            setTimeout(() => { this.showSuccess = false; this.showError = false; this.showInfo = false; }, 3000);
        }
    }
}">
    {{-- Welcome Card (Sleek Student ID Card style) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 text-white shadow-2xl transition-all duration-300 hover:shadow-teal-900/10"
         style="background: linear-gradient(135deg, #0f172a, #0f766e);">
        <!-- Decorative glowing orb -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-teal-400 rounded-full blur-3xl opacity-25"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-indigo-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-teal-200">
                    <span class="w-1.5 h-1.5 bg-teal-400 rounded-full animate-ping"></span>
                    Student Profile
                </span>
                <div>
                    <h1 class="text-2xl font-black tracking-tight">Halo, {{ explode(' ', $siswa->nama)[0] }}! 👋</h1>
                    <p class="text-xs text-teal-100/80 font-medium mt-1">SMK Negeri 7 Purworejo &bull; Kelas {{ $siswa->kelas->nama_kelas }}</p>
                </div>
                <div class="inline-block bg-white/5 border border-white/10 rounded-xl px-3.5 py-1.5 text-[11px] font-mono tracking-wider text-teal-200">
                    NIS: {{ $siswa->nis }}
                </div>
            </div>

            <!-- Avatar & Actions -->
            <div class="flex items-center gap-4">
                <div class="flex flex-col gap-2.5 w-full min-w-[160px]">
                    <a href="{{ route('presensi.scan') }}" class="px-5 py-3.5 bg-white text-slate-900 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95">
                        <i class="fas fa-qrcode text-teal-600"></i> SCAN PRESENSI
                    </a>
                    <a href="{{ route('siswa.riwayat') }}" class="px-4 py-3 bg-white/10 border border-white/20 text-white text-[11px] font-black rounded-2xl flex items-center justify-center gap-1.5 backdrop-blur-sm transition-all hover:bg-white/25 active:scale-95">
                        <i class="fas fa-history text-teal-300"></i> RIWAYAT PRESENSI
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Grid Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Column Left/Middle (Status, Live Class & Jadwal) --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Status & Current Class Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Status Kehadiran Hari Ini --}}
                <div class="glass-card-premium rounded-[2rem] p-5 shadow-sm flex items-center justify-between relative overflow-hidden group">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl border transition-transform duration-300 group-hover:scale-105 {{ $presensiHariIni ? 'bg-emerald-50 text-emerald-600 border-emerald-200' : 'bg-rose-50 text-rose-600 border-rose-200' }}">
                            <i class="fas {{ $presensiHariIni ? 'fa-circle-check' : 'fa-triangle-exclamation' }}"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Hari Ini</p>
                            <h3 class="text-base font-black tracking-tight {{ $presensiHariIni ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ $presensiHariIni ? 'Sudah Presensi' : 'Belum Presensi' }}
                            </h3>
                            <p class="text-[10px] text-slate-400 font-medium mt-0.5">{{ now()->translatedFormat('l, d F') }}</p>
                        </div>
                    </div>
                    <!-- Indicator dots -->
                    <div class="absolute right-4 top-4 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full {{ $presensiHariIni ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500 animate-pulse' }}"></span>
                    </div>
                </div>

                {{-- Pelajaran Saat Ini (Live Card) --}}
                <div class="glass-card-premium rounded-[2rem] p-5 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center justify-between mb-3.5">
                        <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                            Pelajaran Aktif
                        </h3>
                        @if($mapelSekarang)
                            <span class="text-[8px] font-black text-blue-600 bg-blue-50 border border-blue-200 px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse">Live</span>
                        @endif
                    </div>

                    @if($mapelSekarang)
                        <div class="space-y-3">
                            <div>
                                <h2 class="text-base font-black text-slate-800 tracking-tight line-clamp-1">{{ $mapelSekarang->mata_pelajaran }}</h2>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-0.5 line-clamp-1">{{ $mapelSekarang->user->fullname ?? 'Guru Pengampu' }}</p>
                            </div>
                            
                            <div class="flex items-center gap-2 text-xs">
                                <span class="bg-slate-100 text-slate-600 font-bold px-2.5 py-1 rounded-xl flex items-center gap-1">
                                    <i class="far fa-clock text-[10px]"></i> {{ $mapelSekarang->waktu_mulai }}
                                </span>
                                <span class="bg-amber-50 text-amber-700 border border-amber-200 font-bold px-2.5 py-1 rounded-xl flex items-center gap-1">
                                    <i class="fas fa-stopwatch text-[10px]"></i> Batas: {{ $mapelSekarang->batas_scan }}
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="py-3 flex flex-col items-center justify-center text-center opacity-70">
                            <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 mb-2">
                                <i class="fas fa-mug-hot text-sm"></i>
                            </div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Jam Istirahat / Kosong</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- Timeline Jadwal Hari Ini --}}
            <div class="glass-card-premium rounded-[2.5rem] p-6 shadow-sm space-y-4">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2 px-1">
                    <i class="fas fa-list-check text-teal-600"></i>
                    Agenda Pembelajaran Hari Ini
                </h3>

                <div class="relative {{ $jadwals->isNotEmpty() ? 'timeline-line' : '' }} space-y-6">
                    @forelse($jadwals as $j)
                        @php
                            $isNow = $mapelSekarang && $mapelSekarang->id === $j->id;
                            $statusAbsen = $presensis->get($j->id);
                        @endphp
                        
                        <div class="relative pl-10 flex items-center justify-between group">
                            <!-- Timeline node indicator -->
                            <div class="absolute left-1.5 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full flex items-center justify-center z-10 border-2 transition-all duration-300
                                 {{ $statusAbsen ? ($statusAbsen->status === 'Hadir' ? 'bg-emerald-50 border-emerald-500 text-emerald-600 shadow-sm' : ($statusAbsen->status === 'Terlambat' ? 'bg-amber-50 border-amber-500 text-amber-600 shadow-sm' : 'bg-rose-50 border-rose-500 text-rose-600 shadow-sm')) 
                                    : ($isNow ? 'bg-blue-50 border-blue-500 text-blue-600 animate-pulse shadow' : 'bg-white border-slate-200 text-slate-400') }}">
                                <i class="fas text-xs {{ $statusAbsen ? ($statusAbsen->status === 'Hadir' ? 'fa-check' : ($statusAbsen->status === 'Terlambat' ? 'fa-clock' : 'fa-xmark')) 
                                    : ($isNow ? 'fa-circle-dot' : 'fa-lock') }}"></i>
                            </div>

                            <div class="flex-1 bg-white/50 border border-slate-100 hover:border-teal-200 hover:bg-white rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 transition-all duration-300">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-mono font-black text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded uppercase">JP {{ $j->jam_mulai }}</span>
                                        <h4 class="text-sm font-black text-slate-800 tracking-tight">{{ $j->mata_pelajaran }}</h4>
                                    </div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 leading-none">{{ $j->user->fullname ?? 'Guru Pengampu' }}</p>
                                </div>

                                <div class="flex items-center gap-2 justify-between md:justify-end">
                                    <span class="text-[10px] font-mono text-slate-400 font-bold bg-slate-50 px-2 py-1 rounded-xl">
                                        {{ jamPelajaranToWaktu($j->jam_mulai) }}
                                    </span>
                                    @if($statusAbsen)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-[9px] font-black uppercase tracking-wider border
                                            {{ $statusAbsen->status === 'Hadir' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : ($statusAbsen->status === 'Terlambat' ? 'bg-amber-50 text-amber-700 border-amber-100' : 'bg-rose-50 text-rose-700 border-rose-100') }}">
                                            {{ $statusAbsen->status }}
                                        </span>
                                    @elseif($isNow)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-xl bg-blue-50 text-blue-700 border border-blue-100 text-[9px] font-black uppercase tracking-wider animate-pulse">
                                            Sedang Belajar
                                        </span>
                                    @else
                                        <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Belum Mulai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-slate-400">
                            <i class="fas fa-calendar-times text-3xl mb-3 opacity-30"></i>
                            <p class="text-xs font-black uppercase tracking-widest">Tidak ada jadwal pelajaran hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Column Right (Stats, Attendance Percentage Card) --}}
        <div class="space-y-6">
            
            {{-- Attendance Circular/Bar Percentage Card --}}
            <div class="glass-card-premium rounded-[2.5rem] p-6 shadow-sm space-y-5">
                <div class="flex items-center justify-between">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Statistik Kehadiran</h4>
                    <span class="text-xs font-black text-slate-700">Akumulasi Semester</span>
                </div>
                
                {{-- Dynamic Ring Info --}}
                <div class="flex flex-col items-center justify-center py-4 relative">
                    <div class="relative flex items-center justify-center">
                        {{-- Circular Progress SVG --}}
                        <svg class="w-36 h-36 transform -rotate-90">
                            <circle class="text-slate-100" stroke-width="10" stroke="currentColor" fill="transparent" r="58" cx="72" cy="72" />
                            @php
                                $offset = 364.4 - (364.4 * $persentaseKehadiran) / 100;
                            @endphp
                            <circle class="text-teal-500 transition-all duration-1000 ease-out" stroke-width="10" stroke-dasharray="364.4" stroke-dashoffset="{{ $offset }}" stroke-linecap="round" stroke="currentColor" fill="transparent" r="58" cx="72" cy="72" />
                        </svg>
                        <div class="absolute flex flex-col items-center justify-center">
                            <span class="text-3xl font-black text-slate-800 tracking-tighter">{{ $persentaseKehadiran }}%</span>
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-wider mt-0.5">Kehadiran</span>
                        </div>
                    </div>
                </div>

                {{-- Horizontal Glow Bar --}}
                <div class="space-y-2">
                    <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200/50">
                        <div class="h-full {{ $progressBarColor }} rounded-full transition-all duration-1000 shadow-md" style="width: {{ $persentaseKehadiran }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-400">
                        <span>Target Kelulusan: 80%</span>
                        <span class="text-teal-600 font-extrabold">{{ $persentaseKehadiran >= 80 ? 'Aman' : 'Tingkatkan' }}</span>
                    </div>
                </div>
            </div>

            {{-- Detailed Stats Grid --}}
            <div class="grid grid-cols-2 gap-4">
                
                <!-- Hadir Card -->
                <div class="glass-card-premium rounded-3xl p-4 shadow-sm border border-slate-100 transition-all hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-sm shadow-sm">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase tracking-wide font-black">Hadir</p>
                            <p class="text-lg font-black text-slate-800">{{ $totalHadir }}</p>
                        </div>
                    </div>
                </div>

                <!-- Terlambat Card -->
                <div class="glass-card-premium rounded-3xl p-4 shadow-sm border border-slate-100 transition-all hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-sm shadow-sm">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase tracking-wide font-black">Terlambat</p>
                            <p class="text-lg font-black text-slate-800">{{ $totalTerlambat }}</p>
                        </div>
                    </div>
                </div>

                <!-- Alfa Card -->
                <div class="glass-card-premium rounded-3xl p-4 shadow-sm border border-slate-100 transition-all hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center text-sm shadow-sm">
                            <i class="fas fa-user-xmark"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase tracking-wide font-black">Alfa</p>
                            <p class="text-lg font-black text-slate-800">{{ $totalAlfa }}</p>
                        </div>
                    </div>
                </div>

                <!-- Izin Card -->
                <div class="glass-card-premium rounded-3xl p-4 shadow-sm border border-slate-100 transition-all hover:-translate-y-1">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-sm shadow-sm">
                            <i class="fas fa-file-lines"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase tracking-wide font-black">Izin/Sakit</p>
                            <p class="text-lg font-black text-slate-800">{{ $totalIzinSakit }}</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- Feedback Modals --}}
    <template x-if="showSuccess">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-[2.5rem] p-8 max-w-xs w-full text-center shadow-2xl border-4 border-emerald-500 animate-fade-in">
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
            <div class="bg-white rounded-[2.5rem] p-8 max-w-xs w-full text-center shadow-2xl border-4 border-red-500 animate-fade-in">
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
            <div class="bg-white rounded-[2.5rem] p-8 max-w-xs w-full text-center shadow-2xl border-4 border-blue-500 animate-fade-in">
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
@push('scripts')
<script>
    // Auto-refresh dihapus sesuai permintaan
</script>
@endpush
@endsection

