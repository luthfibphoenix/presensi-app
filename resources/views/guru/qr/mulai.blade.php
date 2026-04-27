@extends('layout.app')
@section('title', 'Mulai Kelas — ' . $jadwal->mata_pelajaran)

@section('content')
@php
    $jamMulaiStr   = jamPelajaranToWaktu($jadwal->jam_mulai);
    $jamSelesaiStr = \Carbon\Carbon::createFromFormat('H:i', jamPelajaranToWaktu($jadwal->jam_selesai), 'Asia/Jakarta')->addMinutes(45)->format('H:i');
    $isExpired     = \Carbon\Carbon::now('Asia/Jakarta')->greaterThan($expiredAt);
    $secontsLeft   = max(0, \Carbon\Carbon::now('Asia/Jakarta')->diffInSeconds($expiredAt, false));
    $user = auth()->user();
@endphp

<style>
    body { background-color: #f1f5f9 !important; color: #1e293b; }
    .light-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 1.25rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); }
    .light-input { background-color: #f8fafc; border: 1px solid #cbd5e1; color: #334155; }
    .light-input:focus { border-color: #3b82f6; ring: 2px solid #bfdbfe; background-color: #ffffff; }
    .btn-light-action { background-color: #ffffff; border: 1px solid #e2e8f0; color: #64748b; transition: all 0.2s; }
    .btn-light-action:hover { background-color: #f8fafc; color: #1e293b; border-color: #cbd5e1; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="min-h-screen pb-12 px-4 md:px-0 max-w-5xl mx-auto">

    <div class="space-y-6">
        
        {{-- Card 1: Sesi Pelajaran Aktif --}}
        <div class="light-card p-6">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">SESI PELAJARAN AKTIF</p>
                    <h2 class="text-2xl font-black text-slate-800">{{ $jadwal->mata_pelajaran }}</h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600">
                            <i class="far fa-calendar-alt text-blue-500"></i> {{ $jadwal->hari }}
                        </span>
                        <span class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600">
                            <i class="far fa-clock text-blue-500"></i> {{ $jamMulaiStr }} – {{ $jamSelesaiStr }}
                        </span>
                        <span class="inline-flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg text-xs font-bold text-slate-600">
                            <i class="far fa-folder text-blue-500"></i> {{ $jadwal->kelas }}
                        </span>
                    </div>
                </div>
                <div class="bg-emerald-50 border border-emerald-100 rounded-full px-4 py-1.5 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)] animate-pulse"></span>
                    <span class="text-xs font-bold text-emerald-600">QR Aktif</span>
                </div>
            </div>
        </div>

        {{-- Card 2: Jurnal Mengajar --}}
        <div class="light-card p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-edit text-slate-400"></i> Jurnal Mengajar
                </h3>
                @if($jurnal && $jurnal->id)
                <a href="{{ route('guru.jurnal.cetak', ['jurnal_id' => $jurnal->id]) }}" target="_blank" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1.5 transition underline underline-offset-4 decoration-2">
                    <i class="fas fa-print"></i> Cetak jurnal
                </a>
                @endif
            </div>
            
            <form action="{{ route('guru.mulai.kelas.jurnal', $qrSession->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">MATERI HARI INI</label>
                        <textarea id="jurnal-textarea" name="ringkasan_materi" rows="4" 
                                  class="w-full light-input rounded-xl p-4 text-sm font-medium resize-none focus:outline-none transition-all"
                                  placeholder="Tuliskan ringkasan materi yang diajarkan hari ini...">{{ $jurnal->ringkasan_materi ?? '' }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-3.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl shadow-lg shadow-slate-200 transition flex items-center justify-center gap-2 uppercase tracking-wide">
                        <i class="fas fa-save opacity-60"></i> Simpan jurnal & sync absensi
                    </button>
                    
                    <p id="jurnal-status" class="text-[10px] text-slate-400 text-center font-bold uppercase tracking-tighter italic">
                        @if($jurnal && $jurnal->updated_at)
                            Tersimpan {{ $jurnal->updated_at->format('H:i') }} WIB
                        @endif
                    </p>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Card 3: QR Code --}}
            <div class="light-card p-6 flex flex-col items-center">
                <p class="text-[10px] font-bold text-amber-500 uppercase tracking-widest mb-6">QR CODE PRESENSI</p>
                
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-inner mb-6">
                    <div id="qrcode"></div>
                </div>
                
                <div class="text-center space-y-1.5 mb-8">
                    <p class="text-sm font-bold text-slate-700">Tunjukkan ke siswa untuk absensi.</p>
                    <p class="text-xs text-slate-400 font-medium">Berlaku selama sesi pelajaran berlangsung.</p>
                </div>

                <div class="w-full space-y-3">
                    <div class="flex items-center justify-between px-5 py-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-sync-alt text-blue-500 text-[10px] animate-spin-slow"></i>
                            <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Auto-refresh</span>
                        </div>
                        <span id="countdown" class="font-mono font-bold text-blue-600 text-base">15:00</span>
                    </div>
                    
                    <form action="{{ route('guru.qr.refresh', $qrSession->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 btn-light-action text-xs font-bold rounded-xl flex items-center justify-center gap-2 uppercase tracking-widest">
                            <i class="fas fa-redo opacity-60"></i> Manual refresh QR
                        </button>
                    </form>
                </div>
            </div>

            {{-- Card 4: Kehadiran --}}
            <div class="light-card p-6 flex flex-col">
                <div class="flex justify-between items-center mb-1">
                    <h3 class="font-bold text-slate-800">Kehadiran Siswa</h3>
                    <span class="text-blue-600 font-black text-xl" id="jumlah-hadir-badge">
                        {{ $presensis->whereIn('status', ['Hadir', 'Terlambat'])->count() }} / {{ $allStudents->count() }}
                    </span>
                </div>
                <p class="text-[10px] text-slate-400 font-bold mb-5" id="last-update-text">Terakhir update: {{ now()->format('H:i') }} WIB</p>

                <div class="flex-1 overflow-y-auto no-scrollbar max-h-[320px]">
                    <table id="daftar-hadir" class="w-full">
                        @foreach($allStudents as $i => $student)
                        @php
                            $p = $presensis->get($student->id);
                            $status = $p ? $p->status : 'Belum Absen';
                            
                            $statusClass = match($status) {
                                'Hadir' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'Terlambat' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'Izin', 'Sakit' => 'bg-blue-50 text-blue-600 border-blue-100',
                                default => 'bg-slate-50 text-slate-400 border-slate-100'
                            };

                            $isIzin = in_array($status, ['Sakit', 'Izin']);
                            
                            // Escape single quotes for JS
                            $safeNama = str_replace("'", "\\'", $student->nama);
                            $safeKet = str_replace("'", "\\'", $p->keterangan ?? '-');
                            $safeBukti = $p && $p->bukti ? asset($p->bukti) : '';
                            
                            $clickHandler = $isIzin ? "onclick=\"showIzinDetail('{$safeNama}', '{$status}', '{$safeKet}', '{$safeBukti}')\"" : "";
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                            <td class="py-3 px-4">
                                <p class="text-xs font-black text-slate-700">{{ $student->nama }}</p>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span {!! $clickHandler !!} class="inline-flex items-center px-3 py-1 rounded-xl border text-[10px] font-black uppercase tracking-tighter {{ $statusClass }} {{ $isIzin ? 'cursor-pointer hover:scale-105 transition-transform' : '' }}">
                                    {{ $status }}
                                    @if($isIzin) <i class="fas fa-info-circle ml-1.5 opacity-50"></i> @endif
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                
                <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                        Refresh: <span id="last-refresh-time">{{ now()->format('H:i:s') }}</span> 
                        <span class="mx-2 text-slate-200">|</span> 
                        <a href="#" class="text-blue-500 hover:text-blue-700">Lihat semua siswa <i class="fas fa-chevron-right ml-1 text-[8px]"></i></a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    // ── Generate QR ──
    let qrGenerator = null;
    function renderQRCode(url) {
        const qrContainer = document.getElementById("qrcode");
        qrContainer.innerHTML = ""; // Clear existing
        qrGenerator = new QRCode(qrContainer, {
            text: url,
            width: 180, height: 180,
            colorDark: "#1e293b", colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    @if(!$isExpired)
    renderQRCode("{{ $qrUrl }}");

    // ── Dynamic QR Refresh Logic ──
    let secondsLeft = 15; // Reset ke 15 detik untuk setiap token
    const countdownEl = document.getElementById('countdown');

    function updateCountdown() {
        if (secondsLeft <= 0) {
            refreshQRCode();
            return;
        }
        countdownEl.textContent = '00:' + String(secondsLeft).padStart(2, '0');
        secondsLeft--;
    }

    function refreshQRCode() {
        countdownEl.textContent = '--:--';
        fetch("{{ route('guru.qr.refresh_json', $qrSession->id) }}")
            .then(r => r.json())
            .then(data => {
                if(data.url) {
                    renderQRCode(data.url);
                    secondsLeft = 15; // Reset timer
                }
            })
            .catch(err => console.error("Gagal refresh QR:", err));
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
    @endif

    // ── Auto-refresh Logic ──
    function refreshHadir() {
        fetch("{{ route('guru.qr.status.json', $jadwal->id) }}")
            .then(r => r.json())
            .then(data => {
                document.getElementById('jumlah-hadir-badge').textContent = data.hadir_count + ' / ' + data.total_count;
                document.getElementById('last-update-text').textContent = 'Terakhir update: ' + new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'}) + ' WIB';
                document.getElementById('last-refresh-time').textContent = new Date().toLocaleTimeString('id-ID');

                const list = document.getElementById('daftar-hadir');
                list.innerHTML = data.students.map((s, i) => {
                    let statusClass = 'bg-slate-50 text-slate-400 border-slate-100';
                    if(s.status == 'Hadir') statusClass = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                    else if(s.status == 'Terlambat') statusClass = 'bg-orange-50 text-orange-600 border-orange-100';
                    else if(s.status == 'Izin' || s.status == 'Sakit') statusClass = 'bg-blue-50 text-blue-600 border-blue-100';

                    let isIzin = s.status === 'Sakit' || s.status === 'Izin';
                    let clickable = isIzin ? 'cursor-pointer hover:scale-105 transition-transform' : '';
                    
                    // Escape quotes for JS
                    let safeNama = s.nama.replace(/'/g, "\\'");
                    let safeKet = (s.keterangan || '-').replace(/'/g, "\\'");
                    let safeBukti = s.bukti || '';

                    let clickHandler = isIzin ? `onclick="showIzinDetail('${safeNama}', '${s.status}', '${safeKet}', '${safeBukti}')"` : '';

                    return `
                        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-50 last:border-0">
                            <td class="py-3 px-4">
                                <p class="text-xs font-black text-slate-700">${s.nama}</p>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span ${clickHandler} class="inline-flex items-center px-3 py-1 rounded-xl border text-[10px] font-black uppercase tracking-tighter ${statusClass} ${clickable}">
                                    ${s.status}
                                    ${isIzin ? '<i class="fas fa-info-circle ml-1.5 opacity-50"></i>' : ''}
                                </span>
                            </td>
                        </tr>`;
                }).join('');
            });
    }

    setInterval(refreshHadir, 5000);
    refreshHadir();

    // ── Auto-save Jurnal Logic (DIMATIKAN SEMENTARA UNTUK DEBUG) ──
    /*
    const journalTextarea = document.getElementById('jurnal-textarea');
    ...
    */

    // Modal Detail Izin (Global Scope)
    function showIzinDetail(nama, tipe, alasan, bukti) {
        console.log('Opening modal for:', nama); // Debugging
        document.getElementById('modal-nama').textContent = nama;
        document.getElementById('modal-tipe').textContent = tipe;
        document.getElementById('modal-alasan').textContent = alasan;
        
        const buktiLink = document.getElementById('modal-bukti');
        if (bukti && bukti !== 'null' && bukti !== '' && bukti !== 'undefined') {
            buktiLink.href = bukti;
            buktiLink.classList.remove('hidden');
        } else {
            buktiLink.classList.add('hidden');
        }

        const modal = document.getElementById('izin-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeIzinModal() {
        const modal = document.getElementById('izin-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endpush

<!-- Modal Detail Izin -->
<div id="izin-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">
    <div onclick="closeIzinModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity"></div>
    
    <div class="relative bg-white w-full max-w-sm rounded-[3rem] shadow-2xl overflow-hidden animate-fade-in-up">
        <!-- Header Pop-up -->
        <div class="bg-slate-50/50 p-8 pb-4 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-3xl flex items-center justify-center text-2xl mb-4 shadow-inner">
                <i class="fas fa-file-signature"></i>
            </div>
            <h3 id="modal-nama" class="text-xl font-black text-slate-900 leading-tight"></h3>
            <div id="modal-tipe" class="mt-2 px-4 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-widest border border-blue-100"></div>
        </div>

        <!-- Konten Pop-up -->
        <div class="p-8 pt-4 space-y-6">
            <div class="space-y-2">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Keterangan / Alasan</p>
                <div class="bg-slate-50 p-5 rounded-[2rem] border border-slate-100 relative">
                    <p id="modal-alasan" class="text-xs font-bold text-slate-600 leading-relaxed italic text-center"></p>
                    <i class="fas fa-quote-left absolute top-3 left-4 text-slate-200 text-lg opacity-30"></i>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <a id="modal-bukti" href="#" target="_blank" class="flex items-center justify-center gap-3 w-full bg-emerald-500 hover:bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest py-4 rounded-2xl shadow-lg shadow-emerald-100 transition-all hover:scale-[1.02] active:scale-95">
                    <i class="fas fa-camera"></i>
                    Lihat Lampiran Foto
                </a>
                <button onclick="closeIzinModal()" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-500 font-black text-[10px] uppercase tracking-widest py-4 rounded-2xl transition-all">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
