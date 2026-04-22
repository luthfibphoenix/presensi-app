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

<div class="h-[calc(100vh-10rem)] md:h-[calc(100vh-8rem)] flex flex-col gap-6 overflow-hidden">
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
    
    {{-- Welcome Banner --}}
    <div class="bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 rounded-3xl shadow-lg p-6 md:p-8 text-white relative overflow-hidden border border-blue-700 flex-shrink-0">
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-[9px] font-black uppercase tracking-widest mb-4 border border-white/20">
                <i class="fas fa-chalkboard-teacher text-[8px]"></i>
                Teacher Portal
            </div>
            <h1 class="text-2xl md:text-3xl font-black mb-2 leading-tight tracking-tight">Halo, {{ auth()->user()->fullname }}! 📚</h1>
            <p class="text-blue-100 mb-6 max-w-xl text-[10px] md:text-xs leading-relaxed opacity-80 font-bold uppercase tracking-wide">Kelola kelas dan presensi siswa dengan satu sentuhan.</p>
            
            <div class="flex gap-3">
                <button @click="generateQR()" :disabled="loading" class="bg-white text-blue-900 font-black py-2.5 px-6 rounded-xl shadow-md flex items-center justify-center gap-2 text-xs disabled:opacity-70">
                    <i class="fas fa-qrcode" x-show="!loading"></i>
                    <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                    Presensi
                </button>
                <a href="{{ route('jadwal.semua') }}" class="bg-blue-600 text-white border border-blue-400 font-black py-2.5 px-6 rounded-xl flex items-center justify-center gap-2 text-xs">
                    <i class="fas fa-calendar-alt"></i>
                    Jadwal
                </a>
            </div>
        </div>
        <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-blue-500/10 rounded-full blur-[80px]"></div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 flex-shrink-0">
        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 flex-shrink-0">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Siswa</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $totalSiswa }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center border border-emerald-100 flex-shrink-0">
                <i class="fas fa-user-check"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Hadir</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $hadirHariIni }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-500 flex items-center justify-center border border-purple-100 flex-shrink-0">
                <i class="fas fa-chart-pie"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Persen</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $persentase }}%</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 border border-gray-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center border border-orange-100 flex-shrink-0">
                <i class="fas fa-chalkboard"></i>
            </div>
            <div>
                <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Kelas</p>
                <h3 class="text-lg font-black text-gray-800 leading-none">{{ $kelasAktif }}</h3>
            </div>
        </div>
    </div>

    {{-- Today's Schedule List - Scrollable part --}}
    <div class="flex flex-col flex-1 min-h-0">
        <div class="flex items-center justify-between mb-4 px-2 flex-shrink-0">
            <h2 class="text-xs font-black text-gray-800 uppercase tracking-wider">Jadwal Hari Ini</h2>
            <div class="flex items-center gap-2 text-[8px] font-black text-gray-400 bg-white px-3 py-1.5 rounded-xl uppercase tracking-widest border border-gray-200">
                <i class="far fa-calendar-check text-blue-600"></i>
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMM YYYY') }}
            </div>
        </div>
        
        <div class="flex-1 overflow-y-auto no-scrollbar space-y-4 pb-4">
            @forelse($jadwalHariIni as $jadwal)
                <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-blue-600"></div>
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-4 pl-1">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg border border-blue-100 flex-shrink-0">
                                <i class="fas fa-book-reader text-sm"></i>
                            </div>
                            <div>
                                <h3 class="font-black text-gray-800 leading-tight text-sm">{{ $jadwal->mata_pelajaran }}</h3>
                                <div class="flex items-center gap-3 mt-1">
                                    <p class="text-[9px] font-black text-blue-500 uppercase tracking-widest">Kelas {{ $jadwal->kelas }}</p>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase flex items-center gap-1">
                                        <i class="far fa-clock"></i>
                                        {{ jamPelajaranToWaktu($jadwal->jam_mulai) }} – {{ \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 py-1 bg-gray-50 rounded-lg text-[8px] font-black text-gray-400 uppercase tracking-widest border border-gray-100">
                            Jam {{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-gray-300 bg-white rounded-3xl border border-gray-100 p-10">
                    <i class="fas fa-mug-hot text-2xl mb-3 opacity-20"></i>
                    <p class="font-black uppercase tracking-widest text-[10px] opacity-50 text-center">Tidak ada jadwal hari ini</p>
                </div>
            @endforelse
        </div>
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
