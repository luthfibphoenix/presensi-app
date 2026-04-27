@extends('layouts.ortu_mobile')

@section('content')
<div class="px-4 md:px-0 space-y-6 md:space-y-8">
    @if(session('success'))
    <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-fade-in">
        <i class="fas fa-check-circle"></i>
        <p class="text-xs font-bold">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-500 text-white p-4 rounded-2xl shadow-lg space-y-1 animate-fade-in">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle"></i>
            <p class="text-xs font-black uppercase tracking-widest">Gagal Mengirim:</p>
        </div>
        <ul class="list-disc list-inside text-[10px] font-bold opacity-90 pl-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Header Page -->
    <div class="bg-white p-5 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 flex items-center justify-between gap-6">
        <div>
            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Daftar Izin</h3>
            <h2 class="text-xl md:text-2xl font-black text-slate-900 leading-tight">Pengajuan Izin Siswa</h2>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-teal-500 bg-teal-50 px-4 py-2 rounded-2xl border border-teal-100">
            <i class="fas fa-file-signature"></i>
            <span class="text-xs font-black uppercase tracking-tighter">Status Monitoring</span>
        </div>
    </div>
    <!-- Form Pengajuan Izin Baru -->
    <div class="card-neo p-6 md:p-10 rounded-[3rem] animate-slide-up">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-teal-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-teal-100 rotate-3">
                <i class="fas fa-paper-plane text-lg"></i>
            </div>
            <div>
                <h4 class="text-base font-black text-slate-900 leading-none">Buat Pengajuan Baru</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Isi formulir dengan lengkap dan benar</p>
            </div>
        </div>

        <form action="{{ route('ortu.izin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                        <i class="fas fa-calendar-day text-teal-500"></i>
                        Tanggal Izin
                    </label>
                    <div class="relative">
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-base font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all appearance-none outline-none">
                    </div>
                </div>

                <!-- Tipe Izin -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                        <i class="fas fa-tag text-teal-500"></i>
                        Tipe Keterangan
                    </label>
                    <select name="tipe" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-base font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all appearance-none outline-none">
                        <option value="Izin">Izin (Keperluan Keluarga/Pribadi)</option>
                        <option value="Sakit">Sakit (Membutuhkan Istirahat)</option>
                    </select>
                </div>
            </div>

            <!-- Alasan -->
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                    <i class="fas fa-comment-dots text-teal-500"></i>
                    Alasan / Keterangan Lengkap
                </label>
                <textarea name="alasan" required rows="3" placeholder="Tuliskan alasan yang jelas agar mudah dipahami sekolah..."
                          class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-6 py-5 text-base font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all resize-none placeholder:text-slate-300 outline-none"></textarea>
            </div>

            <!-- Bukti -->
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                    <i class="fas fa-camera text-teal-500"></i>
                    Lampiran Bukti (Opsional)
                </label>
                <div class="group relative">
                    <input type="file" name="bukti" accept="image/*"
                           class="w-full bg-slate-50 border-2 border-dashed border-slate-200 hover:border-teal-300 rounded-[2rem] px-6 py-8 text-sm font-bold text-slate-500 focus:outline-none transition-all cursor-pointer file:hidden text-center">
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none opacity-60 group-hover:opacity-100 transition-opacity">
                        <i class="fas fa-cloud-upload-alt text-2xl text-teal-500 mb-2"></i>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Klik atau Taruh Foto Disini</p>
                    </div>
                </div>
                <p class="text-[9px] text-slate-400 mt-2 ml-4 italic font-medium">*Unggah surat dokter atau bukti pendukung lainnya (Maks. 5MB)</p>
            </div>
            
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black text-xs uppercase tracking-widest py-5 rounded-[2rem] shadow-xl shadow-teal-100 transition-all flex items-center justify-center gap-4 hover:scale-[1.02] active:scale-95">
                <i class="fas fa-check-double"></i>
                Kirim Pengajuan Izin
            </button>
        </form>
    </div>

    <!-- List of Permissions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($izins as $izin)
        <div class="bg-white p-6 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 group hover:border-teal-200 transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center text-lg md:text-xl border border-teal-100 shadow-inner group-hover:scale-105 transition-transform">
                        <i class="fas {{ $izin->tipe == 'Sakit' ? 'fa-hospital-user' : 'fa-envelope-open-text' }}"></i>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">{{ $izin->tipe }}</p>
                        <h4 class="text-sm md:text-base font-black text-slate-800">{{ Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d F Y') }}</h4>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2">
                    @php
                        $statusColor = $izin->status == 'approve' || $izin->status == 'Disetujui' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : ($izin->status == 'reject' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-amber-50 text-amber-600 border-amber-100');
                        $statusLabel = $izin->status == 'approve' || $izin->status == 'Disetujui' ? 'Disetujui' : ($izin->status == 'reject' ? 'Ditolak' : 'Menunggu');
                    @endphp
                    <span class="inline-flex items-center px-4 py-1.5 rounded-xl {{ $statusColor }} border text-[9px] font-black uppercase shadow-sm">
                        {{ $statusLabel }}
                    </span>
                    @if($izin->bukti)
                    <a href="{{ asset($izin->bukti) }}" target="_blank" class="text-[9px] font-black text-teal-600 hover:text-teal-700 bg-teal-50 px-2 py-1 rounded-lg border border-teal-100">
                        <i class="fas fa-image mr-1"></i> LIHAT BUKTI
                    </a>
                    @endif
                </div>
            </div>
            
            <div class="relative bg-slate-50 p-5 rounded-3xl border border-slate-100">
                <i class="fas fa-quote-left absolute top-4 left-4 text-teal-200 text-xs opacity-50"></i>
                <p class="text-[11px] md:text-xs font-medium text-slate-600 leading-relaxed italic pl-6 pr-4">
                    {{ $izin->alasan }}
                </p>
            </div>

            @if($izin->status == 'Disetujui')
            <div class="mt-4 flex items-center gap-2 text-[9px] font-bold text-slate-400 px-2 uppercase tracking-tighter">
                <i class="fas fa-user-check text-emerald-500"></i>
                <span>Disetujui oleh Petugas Sekolah</span>
            </div>
            @endif
        </div>
        @empty
        <div class="lg:col-span-2 bg-white p-20 rounded-[3rem] text-center border border-teal-50 shadow-sm flex flex-col items-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-slate-200">
                <i class="fas fa-file-invoice text-4xl"></i>
            </div>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest italic">Belum ada pengajuan izin terdaftar</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
