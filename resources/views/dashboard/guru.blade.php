@extends('layout.app')

@section('title', 'Dashboard Guru')

@section('content')
@php
    $taughtClasses = \App\Models\Jadwal::where('user_id', auth()->id())->distinct()->pluck('kelas');
    $taughtKelasIds = \App\Models\Kelas::whereIn('nama_kelas', $taughtClasses)->pluck('id');
    $totalSiswa = \App\Models\Siswa::whereIn('kelas_id', $taughtKelasIds)->count();
    
    $hariMap = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
    ];
    $hariIni = $hariMap[date('l')];
    $jadwalHariIni = \App\Models\Jadwal::where('user_id', auth()->id())->where('hari', $hariIni)->orderBy('jam_mulai', 'asc')->get();
    $kelasAktif = $jadwalHariIni->count();

    $taughtJadwalIds = \App\Models\Jadwal::where('user_id', auth()->id())->pluck('id');

    $hadirHariIni = \App\Models\Presensi::whereDate('tanggal', today())
        ->where('status', 'Hadir')
        ->whereIn('jadwal_id', $taughtJadwalIds)
        ->count();
        
    $totalPresensiHariIni = \App\Models\Presensi::whereDate('tanggal', today())
        ->whereIn('jadwal_id', $taughtJadwalIds)
        ->count();
        
    $persentase = $totalPresensiHariIni > 0 ? round(($hadirHariIni / $totalPresensiHariIni) * 100) : 0;
@endphp

<div class="max-w-7xl mx-auto space-y-6" x-data="{ 
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
                this.qrData = data;
                this.showQrModal = true;
                this.startTimer(data.expired_at);
            } else if (data.status === 'multiple') {
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
        // Expiry string should be ISO format for reliable parsing
        const expiry = new Date(expiryStr).getTime();
        
        this.interval = setInterval(() => {
            const now = new Date().getTime();
            const diff = expiry - now;
            
            if (diff <= 0) {
                clearInterval(this.interval);
                this.timer = '00:00';
                // Auto refresh QR without reload
                this.generateQR(this.qrData.jadwal_id);
                return;
            }
            
            const minutes = Math.floor(diff / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            this.timer = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            
            // Color coding
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

<div class="h-full flex flex-col gap-4">
    @if($activeSession)
    {{-- Active Session Banner --}}
    <div class="bg-white border-l-4 border-emerald-500 rounded-xl shadow-sm p-3 flex flex-col md:flex-row items-center justify-between gap-3 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                <i class="fas fa-broadcast-tower"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-gray-900 leading-tight">Sesi Presensi Aktif</h3>
                <p class="text-[10px] text-gray-500">{{ $activeSession->jadwal->mata_pelajaran }} — <span class="font-bold text-emerald-600">Kelas {{ $activeSession->jadwal->kelas }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button @click="generateQR({{ $activeSession->jadwal_id }})" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-lg hover:bg-emerald-100 transition flex items-center gap-2">
                <i class="fas fa-qrcode"></i> Tampilkan QR
            </button>
            <form action="{{ route('dashboard.end_session') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri kelas?')">
                @csrf
                <input type="hidden" name="session_id" value="{{ $activeSession->id }}">
                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white text-xs font-bold rounded-lg hover:bg-red-600 shadow-sm transition flex items-center gap-2">
                    <i class="fas fa-power-off"></i> Akhiri
                </button>
            </form>
        </div>
    </div>
    @endif
    
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-3xl shadow-lg py-8 px-10 text-white flex items-center justify-between relative overflow-hidden flex-shrink-0 my-4">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold mb-1 tracking-tight">Selamat Datang, {{ auth()->user()->fullname }}!</h1>
            <p class="text-blue-100 mb-6 max-w-xl text-sm opacity-80 leading-relaxed font-medium">Kelola kelas, jadwal, dan presensi siswa dengan mudah.</p>
            
            <div class="flex gap-3">
                <button @click="generateQR()" :disabled="loading" class="bg-white text-blue-900 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl shadow-sm text-sm transition-all flex items-center gap-2 disabled:opacity-70">
                    <i class="fas fa-qrcode" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                    Generate QR
                </button>
                <a href="{{ route('jadwal.semua') }}" class="bg-blue-600/30 hover:bg-blue-600/50 text-white border border-white/20 font-bold py-3 px-8 rounded-xl text-sm transition-all flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> Semua Jadwal
                </a>
            </div>
        </div>
        <div class="hidden lg:block relative z-10 opacity-10">
            <i class="fas fa-chalkboard-teacher text-8xl"></i>
        </div>
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-12 transform origin-right"></div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 flex-shrink-0 my-4">
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                <i class="fas fa-users text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest truncate">Total Siswa</p>
                <h3 class="text-3xl font-black text-gray-800 leading-none">{{ $totalSiswa }}</h3>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 flex-shrink-0">
                <i class="fas fa-user-check text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest truncate">Hadir</p>
                <h3 class="text-3xl font-black text-gray-800 leading-none">{{ $hadirHariIni }}</h3>
            </div>
        </div>

        <!-- Persentase -->
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500 flex-shrink-0">
                <i class="fas fa-chart-pie text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest truncate">Persentase</p>
                <h3 class="text-3xl font-black text-gray-800 leading-none">{{ $persentase }}%</h3>
            </div>
        </div>

        <!-- Kelas Aktif -->
        <div class="bg-white rounded-2xl shadow-sm p-5 flex items-center gap-4 border border-gray-100">
            <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                <i class="fas fa-desktop text-lg"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest truncate">Kelas Aktif</p>
                <h3 class="text-3xl font-black text-gray-800 leading-none">{{ $kelasAktif }}</h3>
            </div>
        </div>
    </div>

    {{-- Today's Schedule List --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex-1 flex flex-col min-h-0 my-4">
        <div class="px-8 py-4 flex justify-between items-center border-b border-gray-50 flex-shrink-0">
            <h2 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-clock text-blue-600"></i> Jadwal Mengajar Hari Ini
            </h2>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full uppercase tracking-wider">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}
            </span>
        </div>
        
        <div class="p-6 overflow-y-auto flex-1 no-scrollbar">
            @if($jadwalHariIni->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($jadwalHariIni as $jadwal)
                        <div class="bg-gray-50/50 border border-gray-100 rounded-2xl p-5 hover:border-blue-200 transition-all group relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                            <div class="flex justify-between items-start mb-3 pl-2">
                                <div class="min-w-0">
                                    <span class="text-xs font-bold text-blue-500 uppercase tracking-widest block truncate">{{ $jadwal->mata_pelajaran }}</span>
                                    <h3 class="text-base font-black text-gray-900 leading-tight truncate">{{ $jadwal->kelas }}</h3>
                                </div>
                                <div class="bg-white border border-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-black flex items-center gap-1 flex-shrink-0">
                                    {{ jamPelajaranToWaktu($jadwal->jam_mulai) }} – {{ \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i') }}
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 font-bold flex items-center gap-2 pl-2">
                                <i class="fas fa-layer-group opacity-30"></i> Semester {{ $jadwal->semester }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-full flex flex-col items-center justify-center opacity-40 py-10">
                    <i class="fas fa-mug-hot text-4xl mb-4"></i>
                    <p class="text-lg font-bold">Tidak ada jadwal hari ini</p>
                </div>
            @endif
        </div>
    </div>
</div>

    {{-- Modal QR Code --}}
    <div x-show="showQrModal" x-transition.opacity class="fixed inset-0 z-[60] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div @click.outside="showQrModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="p-6 text-center border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-xl font-black text-gray-900 mb-1" x-text="qrData?.mapel"></h3>
                <div class="flex items-center justify-center gap-2 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                    <span class="text-blue-600" x-text="qrData?.kelas"></span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span x-text="qrData?.hari"></span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span x-text="qrData?.jam"></span>
                </div>
            </div>
            <div class="p-8 flex flex-col items-center">
                <div class="bg-white p-4 rounded-3xl shadow-inner border border-gray-100 mb-6 group transition-all duration-500 hover:shadow-xl overflow-hidden" x-html="qrData?.qr_code">
                </div>
                
                <div class="flex items-center gap-2 bg-gray-50 px-6 py-3 rounded-2xl mb-6 font-black border-2 border-gray-100" :class="timerColor">
                    <i class="fas fa-clock"></i>
                    <span class="text-2xl tracking-tighter font-mono" x-text="timer"></span>
                </div>

                <p class="text-xs text-gray-400 text-center leading-relaxed px-4">
                    Tunjukkan QR Code ini kepada siswa untuk melakukan scan presensi. Sesi akan berakhir secara otomatis saat waktu habis.
                </p>
            </div>
            <div class="p-6 bg-gray-50 flex justify-center">
                <button @click="showQrModal = false" class="bg-white text-gray-800 border border-gray-200 px-8 py-2.5 rounded-xl font-bold hover:bg-gray-100 transition-all">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Modal Pilihan Jadwal --}}
    <div x-show="showChoiceModal" x-transition.opacity class="fixed inset-0 z-[60] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div @click.outside="showChoiceModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="p-6 bg-blue-600 text-white">
                <h3 class="text-xl font-black">Pilih Jadwal Aktif</h3>
                <p class="text-sm text-blue-100 mt-1">Ditemukan lebih dari satu kelas pada jam ini.</p>
            </div>
            <div class="p-4 space-y-3 max-h-96 overflow-y-auto no-scrollbar">
                <template x-for="jadwal in multipleJadwals" :key="jadwal.id">
                    <button @click="generateQR(jadwal.id)" class="w-full text-left p-4 rounded-2xl border-2 border-gray-50 hover:border-blue-500 hover:bg-blue-50 transition-all group">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-black text-gray-800 group-hover:text-blue-700" x-text="jadwal.mata_pelajaran"></h4>
                                <p class="text-xs font-bold text-gray-400" x-text="jadwal.kelas"></p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all"></i>
                        </div>
                    </button>
                </template>
            </div>
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                <button @click="showChoiceModal = false" class="w-full py-3 text-gray-600 font-bold hover:text-gray-900">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection
