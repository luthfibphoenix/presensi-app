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

    $hadirHariIni = \App\Models\Presensi::whereDate('tanggal', today())
        ->where('status', 'Hadir')
        ->whereIn('kelas', $taughtClasses)
        ->count();
        
    $totalPresensiHariIni = \App\Models\Presensi::whereDate('tanggal', today())
        ->whereIn('kelas', $taughtClasses)
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

    @if($activeSession)
    {{-- Active Session Banner --}}
    <div class="bg-white border-l-4 border-emerald-500 rounded-2xl shadow-sm p-5 flex flex-col md:flex-row items-center justify-between gap-4 animate-pulse-subtle">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <i class="fas fa-broadcast-tower text-xl"></i>
            </div>
            <div>
                <h3 class="font-black text-gray-900 leading-tight">Sesi Presensi Aktif</h3>
                <p class="text-sm text-gray-500">{{ $activeSession->jadwal->mata_pelajaran }} — <span class="font-bold text-emerald-600">Kelas {{ $activeSession->jadwal->kelas }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button @click="generateQR({{ $activeSession->jadwal_id }})" class="px-4 py-2 bg-emerald-50 text-emerald-700 font-bold rounded-xl hover:bg-emerald-100 transition flex items-center gap-2">
                <i class="fas fa-qrcode"></i> Tampilkan QR
            </button>
            <form action="{{ route('dashboard.end_session') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengakhiri kelas? Siswa yang belum absen akan otomatis dicatat ALFA.')">
                @csrf
                <input type="hidden" name="session_id" value="{{ $activeSession->id }}">
                <button type="submit" class="px-4 py-2 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 shadow-lg shadow-red-200 transition flex items-center gap-2">
                    <i class="fas fa-power-off"></i> Akhiri Kelas
                </button>
            </form>
        </div>
    </div>
    @endif
    
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-r from-[#2563eb] to-[#3b82f6] rounded-2xl shadow-lg p-10 text-white flex flex-col md:flex-row items-center justify-between relative overflow-hidden mb-8">
        <div class="relative z-10">
            <h1 class="text-4xl font-bold mb-3">Selamat Datang, {{ auth()->user()->fullname }}!</h1>
            <p class="text-blue-100 mb-8 max-w-xl text-sm leading-relaxed opacity-90">Kelola kelas, jadwal, dan presensi siswa dengan mudah. Ciptakan pengalaman belajar yang efisien dan terstruktur hari ini.</p>
            
            <div class="flex flex-wrap gap-4">
                <button @click="generateQR()" :disabled="loading" class="bg-white text-blue-700 hover:bg-gray-50 font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center gap-3 disabled:opacity-70">
                    <i class="fas fa-th-large" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                    Generate QR Code
                </button>
                <a href="{{ route('jadwal.semua') }}" class="bg-transparent hover:bg-white/10 text-white border-2 border-white/50 font-bold py-3 px-8 rounded-xl transition-all flex items-center gap-3">
                    <i class="fas fa-calendar-alt"></i> Lihat Semua Jadwal
                </a>
            </div>
        </div>
        <div class="hidden lg:block relative z-10 opacity-20">
            <i class="fas fa-chalkboard-teacher text-[180px]"></i>
        </div>
        
        <!-- Decorative subtle pattern -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-white/5 skew-x-12 transform origin-right"></div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Siswa -->
        <div class="bg-white rounded-2xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Siswa</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $totalSiswa }}</h3>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="bg-white rounded-2xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500">
                <i class="fas fa-user-check text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Hadir Hari Ini</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $hadirHariIni }}</h3>
            </div>
        </div>

        <!-- Persentase -->
        <div class="bg-white rounded-2xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                <i class="fas fa-chart-pie text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Persentase</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $persentase }}%</h3>
            </div>
        </div>

        <!-- Kelas Aktif -->
        <div class="bg-white rounded-2xl shadow-sm p-7 flex items-center gap-6 border border-gray-100">
            <div class="w-14 h-14 rounded-full bg-orange-50 flex items-center justify-center text-orange-500">
                <i class="fas fa-desktop text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Kelas Aktif (Hari Ini)</p>
                <h3 class="text-3xl font-black text-gray-800">{{ $kelasAktif }}</h3>
            </div>
        </div>
    </div>

    {{-- Today's Schedule List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 flex justify-between items-center border-b border-gray-50">
            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                <i class="fas fa-clock text-blue-600"></i> Jadwal Mengajar Hari Ini ({{ $hariIni }})
            </h2>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-1.5 rounded-full uppercase tracking-wider">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMM YYYY') }}
            </span>
        </div>
        
        <div class="p-8">
            @if($jadwalHariIni->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jadwalHariIni as $jadwal)
                        <div class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-lg transition-all group relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-blue-500"></div>
                            <div class="flex justify-between items-start mb-4 pl-2">
                                <div>
                                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest block mb-1">{{ $jadwal->mata_pelajaran }}</span>
                                    <h3 class="text-2xl font-black text-gray-900 leading-tight">{{ $jadwal->kelas }}</h3>
                                </div>
                                <div class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg text-[11px] font-black flex items-center gap-2">
                                    <i class="fas fa-hourglass-half opacity-40"></i> Jam {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 font-bold flex items-center gap-2 pl-2">
                                <i class="fas fa-layer-group opacity-30 text-base"></i> Semester {{ $jadwal->semester }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-gray-50/50 rounded-3xl">
                    <i class="fas fa-mug-hot text-5xl text-gray-200 mb-4 block"></i>
                    <h3 class="text-xl font-bold text-gray-400">Tidak ada jadwal hari ini</h3>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal QR Code --}}
    <div x-show="showQrModal" x-transition.opacity class="fixed inset-0 z-[60] bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4" x-cloak>
        <div @click.outside="showQrModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="p-6 text-center border-b border-gray-50 bg-gray-50/50">
                <h3 class="text-xl font-black text-gray-900" x-text="qrData?.mapel"></h3>
                <p class="text-sm font-bold text-blue-600" x-text="qrData?.kelas"></p>
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
