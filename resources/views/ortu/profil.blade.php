@extends('layouts.ortu_mobile')

@section('content')
<div class="px-4 md:px-0 space-y-6 md:space-y-8" x-data="{ showModal: false }">
    <!-- Header Profil Ringkas -->
    <div class="bg-white p-6 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-cyan-50 flex flex-col md:flex-row items-center gap-6">
        <div class="w-20 h-20 bg-cyan-500 rounded-[2rem] flex items-center justify-center text-white text-3xl shadow-xl shadow-cyan-100 border-4 border-white shrink-0">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="text-center md:text-left flex-1">
            <h3 class="text-xl md:text-2xl font-black text-slate-900 leading-tight mb-1">Orang Tua {{ $siswa->nama }}</h3>
            <p class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Wali Murid Resmi</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="showModal = true" class="px-5 py-3 bg-cyan-50 text-cyan-600 font-bold rounded-2xl text-xs flex items-center gap-2 hover:bg-cyan-100 transition-colors">
                <i class="fas fa-key"></i> Ganti Password
            </button>
        </div>
    </div>

    <!-- Informasi Detail -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
        <!-- Akun Orang Tua -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-cyan-50 space-y-6">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-id-badge text-cyan-500"></i> Detail Akun
            </h4>
            <div class="space-y-4">
                <div class="pb-4 border-b border-slate-50">
                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Username</p>
                    <p class="text-sm font-black text-slate-800">{{ auth('orangtua')->user()->username }}</p>
                </div>
                <div>
                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Status Keamanan</p>
                    <div class="flex items-center gap-2 text-emerald-600">
                        <i class="fas fa-check-circle text-xs"></i>
                        <span class="text-xs font-bold">Akun Terlindungi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Siswa (Grid 2 Kolom pada Desktop) -->
        <div class="md:col-span-2 bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-cyan-50 space-y-6">
            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <i class="fas fa-graduation-cap text-cyan-500"></i> Informasi Siswa Terkait
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="pb-4 border-b border-slate-50">
                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap Siswa</p>
                    <p class="text-sm font-black text-slate-800">{{ $siswa->nama }}</p>
                </div>
                <div class="pb-4 border-b border-slate-50">
                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">NIS / NISN</p>
                    <p class="text-sm font-black text-slate-800">{{ $siswa->nis }} / {{ $siswa->nisn }}</p>
                </div>
                <div class="pb-4 border-b border-slate-50">
                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Kelas Saat Ini</p>
                    <p class="text-sm font-black text-slate-800">{{ $siswa->kelas->nama_kelas }}</p>
                </div>
                <div class="pb-4 border-b border-slate-50">
                    <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Tahun Lulus / Angkatan</p>
                    <p class="text-sm font-black text-slate-800">{{ $siswa->tahun_lulus ?? 'Siswa Aktif' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile-Only Logout (Secondary) -->
    <div class="md:hidden pt-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-4 bg-white text-rose-500 font-bold rounded-2xl border border-rose-50 flex items-center justify-center gap-3">
                <i class="fas fa-sign-out-alt"></i> Keluar dari Aplikasi
            </button>
        </form>
    </div>

    <!-- Modal Ganti Password -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-[40px] p-8 w-full max-w-md shadow-2xl relative" @click.away="showModal = false">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-cyan-100 text-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-lock"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-1">Ubah Password</h3>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Gunakan minimal 3 karakter</p>
            </div>

            <form action="{{ route('ortu.password.update') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid gap-4">
                    <input type="password" name="current_password" placeholder="Password Saat Ini" class="w-full px-6 py-4 rounded-2xl bg-slate-100 border border-slate-200 text-slate-400 font-bold outline-none cursor-not-allowed" disabled>
                    <input type="password" name="new_password" placeholder="Password Baru" class="w-full px-6 py-4 rounded-2xl bg-slate-100 border border-slate-200 text-slate-400 font-bold outline-none cursor-not-allowed" disabled>
                    <input type="password" name="new_password_confirmation" placeholder="Konfirmasi Password Baru" class="w-full px-6 py-4 rounded-2xl bg-slate-100 border border-slate-200 text-slate-400 font-bold outline-none cursor-not-allowed" disabled>
                </div>
                
                <div class="flex gap-3 pt-6">
                    <button type="button" @click="showModal = false" class="flex-1 py-4 bg-slate-100 text-slate-500 font-bold rounded-2xl text-[10px] uppercase tracking-widest">Batal</button>
                    <button type="button" class="flex-1 py-4 bg-slate-200 text-slate-400 font-bold rounded-2xl text-[10px] uppercase tracking-widest cursor-not-allowed" disabled>Fitur Dinonaktifkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
