@extends('layout.app')

@php
    $aksen = 'blue-600';
    $user = auth()->user();
    
    // Taught classes and total students
    $taughtClasses = \App\Models\Jadwal::where('user_id', $user->id)->distinct()->pluck('kelas');
    $taughtKelasIds = \App\Models\Kelas::whereIn('nama_kelas', $taughtClasses)->pluck('id');
    $totalSiswa = \App\Models\Siswa::whereIn('kelas_id', $taughtKelasIds)->count();
    
    $hariMap = [
        'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu',
    ];
    $hariIni = $hariMap[date('l')];
    $jadwalHariIni = \App\Models\Jadwal::where('user_id', $user->id)->where('hari', $hariIni)->orderBy('jam_mulai', 'asc')->get();
    $kelasAktif = $jadwalHariIni->count();

    $taughtJadwalIds = \App\Models\Jadwal::where('user_id', $user->id)->pluck('id');

    $hadirHariIni = \App\Models\Presensi::whereDate('tanggal', today())
        ->where('status', 'Hadir')
        ->whereIn('jadwal_id', $taughtJadwalIds)
        ->count();
        
    $totalPresensiHariIni = \App\Models\Presensi::whereDate('tanggal', today())
        ->whereIn('jadwal_id', $taughtJadwalIds)
        ->count();
        
    $persentase = $totalPresensiHariIni > 0 ? round(($hadirHariIni / $totalPresensiHariIni) * 100) : 0;
    
    $subjectTaught = \App\Models\Jadwal::where('user_id', $user->id)->distinct()->pluck('mata_pelajaran')->first() ?? 'Teknik Kelistrikan';
    $kelasDiampuCount = $taughtClasses->count();
@endphp

@section('title', 'Dashboard Guru')

@section('content')
<div class="pb-10" x-data="{ 
    showQrModal: false, 
    showChoiceModal: false,
    loading: false,
    qrData: null,
    multipleJadwals: [],
    timer: '15:00',
    timerColor: 'text-emerald-500',
    interval: null,

    async generateQR(jadwalId = null) {
        this.loading = true;
        this.showChoiceModal = false;
        try {
            const response = await fetch('{{ route('dashboard.generate_qr') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ jadwal_id: jadwalId })
            });
            const data = await response.json();
            
            if (data.status === 'success') {
                if (data.redirect_url) {
                    window.location.href = data.redirect_url;
                    return;
                }
                this.qrData = data;
                this.showQrModal = true;
                this.startTimer(data.expired_at);
            } else if (data.status === 'multiple') {
                this.qrData = data;
                this.multipleJadwals = data.jadwals;
                this.showChoiceModal = true;
            } else {
                alert(data.message || 'Gagal generate QR Code');
            }
        } catch (e) {
            console.error(e);
            alert('Terjadi kesalahan sistem');
        } finally {
            this.loading = false;
        }
    },

    startTimer(expiryStr) {
        if (this.interval) clearInterval(this.interval);
        const expiry = new Date(expiryStr).getTime();
        
        this.interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = expiry - now;
            
            if (diff <= 0) {
                clearInterval(this.interval);
                this.timer = '00:00';
                this.generateQR(this.qrData.jadwal_id);
                return;
            }
            
            const minutes = Math.floor(diff / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            this.timer = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            
            if (minutes >= 5) {
                this.timerColor = 'text-emerald-500';
            } else if (minutes >= 2) {
                this.timerColor = 'text-amber-500';
            } else {
                this.timerColor = 'text-red-500';
            }
        }, 1000);
    }
}">

<div class="flex flex-col gap-6">
    @if($activeSession)
    {{-- Active Session Banner --}}
    <div class="bg-white border-l-4 border-emerald-500 rounded-2xl shadow-sm p-4 flex flex-col md:flex-row items-center justify-between gap-4 border border-gray-100 flex-shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100">
                <i class="fas fa-broadcast-tower text-xl"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-gray-900 leading-tight uppercase tracking-tight">Sesi Presensi Aktif</h3>
                <p class="text-[11px] text-gray-500 font-bold mt-0.5">{{ $activeSession->jadwal->mata_pelajaran }} — <span class="text-emerald-600">Kelas {{ $activeSession->jadwal->kelas }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <button @click="generateQR({{ $activeSession->jadwal_id }})" class="flex-1 md:flex-none px-6 py-2.5 bg-emerald-600 text-white text-xs font-black rounded-xl hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-qrcode"></i> Tampilkan QR
            </button>
            <form action="{{ route('dashboard.end_session') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri kelas?')" class="flex-1 md:flex-none">
                @csrf
                <input type="hidden" name="session_id" value="{{ $activeSession->id }}">
                <button type="submit" class="w-full px-6 py-2.5 bg-red-50 text-red-600 text-xs font-black rounded-xl hover:bg-red-100 transition-colors flex items-center justify-center gap-2 border border-red-100">
                    <i class="fas fa-power-off"></i> Akhiri
                </button>
            </form>
        </div>
    </div>
    @endif
    
    {{-- Hero Card (Blue gradient matching mockup layout but with blue colors) --}}
    <div class="relative overflow-hidden rounded-[2.5rem] p-6 md:p-8 text-white shadow-2xl transition-all duration-300 hover:shadow-blue-900/10 animate-slide-up"
         style="background: linear-gradient(135deg, #0B1E30, #1d4ed8);">
        <!-- Decorative glowing orbs -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-blue-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-indigo-500 rounded-full blur-3xl opacity-15"></div>

        <div class="relative z-10 space-y-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-black uppercase tracking-widest text-blue-200">
                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-ping"></span>
                Teacher Portal
            </span>
            <div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Halo, {{ $user->fullname ?? $user->nama }}! 👋</h1>
                <p class="text-xs text-blue-100/90 font-medium mt-1">Kelola kelas dan presensi dengan satu sentuhan.</p>
            </div>
            <div class="flex gap-3 pt-1">
                <button @click="generateQR()" :disabled="loading" class="px-5 py-3 bg-white text-blue-950 text-xs font-black rounded-2xl flex items-center justify-center gap-2 shadow-lg transition-all hover:scale-105 active:scale-95 disabled:opacity-75">
                    <i class="fas fa-qrcode text-blue-600" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin text-blue-600" x-show="loading"></i> PRESENSI
                </button>
                <a href="{{ route('jadwal.hari.ini') }}" class="px-5 py-3 bg-white/10 border border-white/20 text-white text-xs font-black rounded-2xl flex items-center justify-center gap-1.5 backdrop-blur-sm transition-all hover:bg-white/25 active:scale-95">
                    <i class="fas fa-calendar-day text-blue-300"></i> JADWAL HARI INI
                </a>
            </div>
        </div>
    </div>

    {{-- Stats Grid (Matches mockup layout with blue accent theme) --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Siswa Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Siswa</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $totalSiswa }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-sm border border-blue-100">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Total siswa diampu</p>
        </div>

        <!-- Hadir Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Hadir</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $hadirHariIni }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm border border-emerald-100">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Hari ini</p>
        </div>

        <!-- Persen Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Persen</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $persentase }}%</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center text-sm border border-amber-100">
                    <i class="far fa-clock"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Kehadiran hari ini</p>
        </div>

        <!-- Jadwal Card -->
        <div class="bg-white rounded-[2rem] p-5 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col justify-between group transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[9px] text-slate-400 uppercase tracking-wider font-black">Jadwal</p>
                    <p class="text-2xl font-black text-slate-800 mt-2">{{ $kelasAktif }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm border border-indigo-100">
                    <i class="far fa-calendar-check"></i>
                </div>
            </div>
            <p class="text-[9px] text-slate-400 font-bold mt-4">Kelas hari ini</p>
        </div>
    </div>

    {{-- Middle Row: Kelas Belum Presensi & Rekap Tidak Masuk --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Kelas Belum Presensi --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kelas Belum Presensi</h3>
                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[8px] font-black uppercase rounded-lg border border-emerald-100">Status</span>
            </div>
            <div class="flex flex-wrap gap-2 max-h-24 overflow-y-auto pr-2">
                @forelse($kelasBelumPresensi as $kelas)
                    <div class="px-3 py-2 bg-slate-50 text-slate-700 text-[10px] font-black rounded-xl border border-slate-100 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                        Kelas {{ $kelas }}
                    </div>
                @empty
                    <div class="flex items-center gap-2 text-[10px] font-bold text-emerald-600 uppercase tracking-wide">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        Semua Kelas Sudah Mulai Presensi 🎉
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Rekap Siswa Tidak Masuk --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rekap Tidak Masuk Hari Ini</h3>
                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-[8px] font-black uppercase rounded-lg border border-blue-100">Info Siswa</span>
            </div>
            <div class="space-y-2 overflow-y-auto max-h-24 pr-2">
                @forelse($rekapAbsen as $kelas => $presensis)
                    <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-[10px] font-black text-slate-700">Kelas {{ $kelas }}</span>
                        <div class="flex gap-1.5">
                            @php
                                $counts = $presensis->groupBy('status')->map->count();
                            @endphp
                            @if($counts->has('Alfa')) <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[8px] font-black rounded-md border border-red-100">A: {{ $counts['Alfa'] }}</span> @endif
                            @if($counts->has('Izin')) <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[8px] font-black rounded-md border border-blue-100">I: {{ $counts['Izin'] }}</span> @endif
                            @if($counts->has('Sakit')) <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[8px] font-black rounded-md border border-amber-100">S: {{ $counts['Sakit'] }}</span> @endif
                        </div>
                    </div>
                @empty
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide italic">Belum ada data ketidakhadiran.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Lower Row Split Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Jadwal Hari Ini Timeline -->
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider">Jadwal Hari Ini</h2>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">
                            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <a href="{{ route('jadwal.hari.ini') }}" class="text-[10px] font-black text-blue-600 hover:text-blue-700 uppercase tracking-widest">
                        Lihat semua <i class="fas fa-chevron-right text-[8px]"></i>
                    </a>
                </div>
                
                <div class="space-y-4">
                    @forelse($jadwalHariIni as $jadwal)
                        @php
                            $waktuMulaiStr = jamPelajaranToWaktu($jadwal->jam_mulai);
                            $waktuSelesaiStr = jamPelajaranToWaktu($jadwal->jam_selesai);
                            
                            $waktuMulai = \Carbon\Carbon::createFromFormat('H:i', $waktuMulaiStr, 'Asia/Jakarta');
                            $waktuSelesai = \Carbon\Carbon::createFromFormat('H:i', $waktuSelesaiStr, 'Asia/Jakarta')->addMinutes(45);
                            
                            $now = \Carbon\Carbon::now('Asia/Jakarta');
                            
                            if ($now->greaterThan($waktuSelesai)) {
                                $statusBadge = 'Selesai';
                                $badgeStyle = 'bg-slate-100 text-slate-500 border-slate-200';
                            } elseif ($now->between($waktuMulai, $waktuSelesai)) {
                                $statusBadge = 'Sedang Berlangsung';
                                $badgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-100 animate-pulse font-black';
                            } else {
                                $statusBadge = 'Akan Datang';
                                $badgeStyle = 'bg-slate-50 text-slate-400 border-slate-200 font-bold';
                            }
                        @endphp
                        <div class="p-4 rounded-[1.5rem] border border-slate-100 hover:border-blue-100 hover:bg-slate-50/50 transition-all duration-300 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center shrink-0">
                                    <i class="fas fa-book-reader text-sm"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-black text-slate-800 text-xs truncate">{{ $jadwal->mata_pelajaran }}</h4>
                                    <div class="flex items-center gap-2 mt-1">
                                        <p class="text-[9px] font-black text-blue-600 uppercase tracking-widest">Kelas {{ $jadwal->kelas }}</p>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase flex items-center gap-1">
                                            <i class="far fa-clock"></i> {{ $waktuMulaiStr }} – {{ $waktuSelesai->format('H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1.5 shrink-0">
                                <span class="px-2.5 py-1 rounded-lg text-[8px] font-black uppercase border {{ $badgeStyle }}">
                                    {{ $statusBadge }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center text-slate-300 p-8 border border-slate-100 rounded-3xl bg-slate-50/30">
                            <i class="fas fa-mug-hot text-2xl mb-2 opacity-30"></i>
                            <p class="font-black uppercase tracking-widest text-[9px] opacity-50">Tidak ada jadwal hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-50 text-center">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Presensi Guru SMKN 7</p>
            </div>
        </div>

        <!-- Right: Profile Card & Quick Links -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col items-center text-center">
                <div class="relative w-20 h-20 rounded-full border-4 border-slate-50 overflow-hidden shadow-md mb-4">
                    <img src="{{ $user->photo_url }}" class="w-full h-full object-cover">
                    <span class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                </div>
                
                <h3 class="text-sm font-black text-slate-800 leading-tight">{{ $user->fullname ?? $user->nama }}</h3>
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $user->position ?? 'Guru Teknik Kelistrikan' }}</p>
                
                <div class="w-full space-y-2.5 mt-6 pt-6 border-t border-slate-50 text-left">
                    <div class="flex justify-between items-center text-[10px]">
                        <span class="font-bold text-slate-400 uppercase">NIP</span>
                        <span class="font-black text-slate-700">{{ $user->nip ?? '198604122014031001' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px]">
                        <span class="font-bold text-slate-400 uppercase">Mata Pelajaran</span>
                        <span class="font-black text-slate-700 truncate max-w-[150px]">{{ $subjectTaught }}</span>
                    </div>
                    <div class="flex justify-between items-center text-[10px]">
                        <span class="font-bold text-slate-400 uppercase">Kelas Diampu</span>
                        <span class="font-black text-slate-700">{{ $kelasDiampuCount }} Kelas</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-[2.5rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)]">
                <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-4">Akses Cepat</h3>
                <div class="space-y-2">
                    <a href="{{ route('guru.jurnal.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-slate-100 hover:border-blue-100 hover:bg-slate-50/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-book"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Jurnal Saya</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 group-hover:text-blue-500 group-hover:translate-x-0.5 transition-all"></i>
                    </a>
                    
                    <a href="{{ route('guru.penilaian.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-slate-100 hover:border-blue-100 hover:bg-slate-50/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Penilaian</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 group-hover:text-blue-500 group-hover:translate-x-0.5 transition-all"></i>
                    </a>

                    <a href="{{ route('guru.blangko.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-slate-100 hover:border-blue-100 hover:bg-slate-50/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-print"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Cetak Blangko</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 group-hover:text-blue-500 group-hover:translate-x-0.5 transition-all"></i>
                    </a>

                    <a href="{{ route('siswa.index') }}" class="flex items-center justify-between p-3 rounded-2xl border border-slate-100 hover:border-blue-100 hover:bg-slate-50/50 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                                <i class="fas fa-users-viewfinder"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Siswa Wall</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-slate-300 group-hover:text-blue-500 group-hover:translate-x-0.5 transition-all"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- QR Code modal generated by Alpine.js --}}
<div x-show="showQrModal" x-transition.opacity class="fixed inset-0 z-[60] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
    <div @click.outside="showQrModal = false" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden">
        <div class="p-6 text-center border-b border-slate-50 bg-slate-50/50">
            <h3 class="text-lg font-black text-slate-900 mb-1" x-text="qrData?.mapel"></h3>
            <div class="flex items-center justify-center gap-2 text-[9px] font-bold uppercase tracking-widest text-slate-400">
                <span class="text-blue-600" x-text="qrData?.kelas"></span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <span x-text="qrData?.hari"></span>
                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                <span x-text="qrData?.jam"></span>
            </div>
        </div>
        <div class="p-8 flex flex-col items-center">
            <div class="bg-white p-4 rounded-3xl shadow-inner border border-slate-100 mb-6" x-html="qrData?.qr_code">
            </div>
            
            <div class="flex items-center gap-2 bg-slate-50 px-6 py-3 rounded-2xl mb-6 font-black border border-slate-100 text-lg" :class="timerColor">
                <i class="far fa-clock"></i>
                <span class="text-2xl tracking-tighter font-mono" x-text="timer"></span>
            </div>

            <p class="text-[11px] text-slate-400 text-center leading-relaxed px-4 font-bold uppercase">
                Tunjukkan QR Code ini kepada siswa untuk melakukan scan presensi. Sesi berakhir saat waktu habis.
            </p>
        </div>
        <div class="p-6 bg-slate-50/50 flex justify-center border-t border-slate-50">
            <button @click="showQrModal = false" class="bg-white border border-slate-200 px-8 py-2.5 rounded-2xl font-bold text-xs hover:bg-slate-50 transition-all text-slate-700">TUTUP</button>
        </div>
    </div>
</div>

{{-- Multiple schedules selector --}}
<div x-show="showChoiceModal" x-transition.opacity class="fixed inset-0 z-[60] bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
    <div @click.outside="showChoiceModal = false" class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden">
        <div class="p-6 bg-blue-600 text-white">
            <h3 class="text-lg font-black uppercase tracking-wider">Pilih Jadwal Kelas</h3>
            <p class="text-xs text-blue-100 mt-1" x-text="qrData?.message || 'Pilih kelas untuk mulai presensi.'"></p>
        </div>
        <div class="p-4 space-y-3 max-h-96 overflow-y-auto no-scrollbar">
            <template x-for="jadwal in multipleJadwals" :key="jadwal.id">
                <button @click="generateQR(jadwal.id)" class="w-full text-left p-4 rounded-2xl border-2 border-slate-50 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="font-black text-slate-800 group-hover:text-blue-700 text-xs" x-text="jadwal.mata_pelajaran"></h4>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5" x-text="jadwal.kelas"></p>
                        </div>
                        <i class="fas fa-chevron-right text-slate-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all text-xs"></i>
                    </div>
                </button>
            </template>
        </div>
        <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
            <button @click="showChoiceModal = false" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-2xl text-xs font-bold hover:text-slate-900">BATAL</button>
        </div>
    </div>
</div>
</div>
@endsection
