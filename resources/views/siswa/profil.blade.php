@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $siswa = Auth::guard('siswa')->user();
    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama ?? 'Siswa') . '&background=10B981&color=fff&bold=true&size=200';
@endphp

<div class="h-full overflow-y-auto no-scrollbar pb-20 max-w-4xl mx-auto space-y-6">
    {{-- Profile Header Card --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-teal-900/5 overflow-hidden border border-gray-100">
        {{-- Student Gradient Banner --}}
        <div class="h-40 bg-gradient-to-br from-green-500 via-teal-500 to-teal-600 relative">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.5),transparent)]"></div>
        </div>

        {{-- Profile Info Section --}}
        <div class="px-6 md:px-10 pb-10">
            <div class="flex flex-col md:flex-row items-center md:items-end gap-6 -mt-16 mb-8">
                <div class="relative">
                    <div class="w-36 h-36 rounded-3xl overflow-hidden border-4 border-white shadow-2xl bg-white">
                        <img src="{{ $fallbackUrl }}"
                             alt="Foto Profil"
                             class="w-full h-full object-cover">
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-teal-500 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
                </div>
                <div class="text-center md:text-left pb-2 flex-grow">
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ $siswa->nama }}</h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                        <span class="px-4 py-1.5 bg-teal-600 text-white text-xs font-black uppercase rounded-full shadow-md shadow-teal-200 tracking-wider">
                            Kelas {{ $siswa->kelas->nama_kelas ?? '-' }}
                        </span>
                        <span class="px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold uppercase rounded-full border border-gray-200">
                            Siswa Aktif
                        </span>
                    </div>
                </div>
            </div>

                @php
                    $fields = [
                        ['label' => 'NIS',          'icon' => 'fa-fingerprint', 'value' => $siswa->nis ?? '-', 'color' => 'blue'],
                        ['label' => 'NISN',         'icon' => 'fa-id-badge',    'value' => $siswa->nisn ?? '-', 'color' => 'indigo'],
                        ['label' => 'Nama Lengkap', 'icon' => 'fa-id-card',     'value' => $siswa->nama, 'color' => 'teal'],
                        ['label' => 'Kelas',        'icon' => 'fa-users',       'value' => $siswa->kelas->nama_kelas ?? '-', 'color' => 'green'],
                        ['label' => 'Username',     'icon' => 'fa-user',        'value' => $siswa->username, 'color' => 'teal'],
                        ['label' => 'Kode Kelas',   'icon' => 'fa-tag',         'value' => $siswa->kelas->kode_kelas ?? '-', 'color' => 'teal'],
                    ];
                @endphp

                @foreach($fields as $field)
                <div class="group p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-teal-200 hover:bg-white hover:shadow-md transition-all duration-300">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-{{ $field['color'] }}-100 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas {{ $field['icon'] }} text-{{ $field['color'] }}-600 text-xs"></i>
                        </div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">{{ $field['label'] }}</p>
                    </div>
                    <p class="text-gray-800 font-bold ml-11">{{ $field['value'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Security / Password Section --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-teal-900/5 overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
            <div>
                <h2 class="text-xl font-black text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 flex items-center justify-center text-white shadow-lg shadow-teal-200">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    Keamanan Akun
                </h2>
                <p class="text-sm text-gray-500 mt-1 ml-13">Ganti password secara berkala untuk menjaga keamanan akun Anda.</p>
            </div>
        </div>
        
        <div class="p-8 md:px-12">
            <form action="{{ route('siswa.profil.password') }}" method="POST" class="max-w-2xl mx-auto space-y-6" x-data="{ showCurrent: false, showNew: false, showConf: false }">
                @csrf
                
                {{-- Current Password --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-gray-700 ml-1">Password Saat Ini</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-teal-600 text-gray-400">
                            <i class="fas fa-key"></i>
                        </div>
                        <input :type="showCurrent ? 'text' : 'password'" 
                               name="current_password" 
                               placeholder="Masukkan password lama..."
                               required 
                               class="w-full pl-11 pr-12 py-3.5 bg-gray-100 border-2 border-gray-200 rounded-2xl cursor-not-allowed transition-all outline-none text-gray-400 font-medium placeholder:text-gray-400"
                               disabled>
                        <button type="button" 
                                @click="showCurrent = !showCurrent"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-teal-600 transition-colors">
                            <i class="fas" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- New Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-bold text-gray-700 ml-1">Password Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-teal-600">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input :type="showNew ? 'text' : 'password'" 
                                   name="new_password" 
                                   placeholder="Min. 3 karakter"
                                   required 
                                   minlength="3" 
                                   class="w-full pl-11 pr-12 py-3.5 bg-gray-100 border-2 border-gray-200 rounded-2xl cursor-not-allowed transition-all outline-none text-gray-400 font-medium placeholder:text-gray-400"
                                   disabled>
                            <button type="button" 
                                    @click="showNew = !showNew"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-teal-600">
                                <i class="fas" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-bold text-gray-700 ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-teal-600">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <input :type="showConf ? 'text' : 'password'" 
                                   name="new_password_confirmation" 
                                   placeholder="Ulangi password..."
                                   required 
                                   minlength="3" 
                                   class="w-full pl-11 pr-12 py-3.5 bg-gray-100 border-2 border-gray-200 rounded-2xl cursor-not-allowed transition-all outline-none text-gray-400 font-medium placeholder:text-gray-400"
                                   disabled>
                            <button type="button" 
                                    @click="showConf = !showConf"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-teal-600">
                                <i class="fas" :class="showConf ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end pt-4">
                    <button type="button" class="group relative w-full md:w-auto bg-gray-300 text-gray-500 px-10 py-4 rounded-2xl font-black text-lg cursor-not-allowed transition-all duration-300 flex items-center justify-center gap-3" disabled title="Fitur ini dinonaktifkan sementara">
                        <i class="fas fa-lock text-gray-400"></i>
                        Tombol sedang dalam perbaikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Logout Button for Mobile --}}
    <div class="mt-6 md:hidden px-4">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-4 bg-white text-red-600 font-bold rounded-2xl shadow-sm border border-red-50 flex items-center justify-center gap-2 hover:bg-red-50 transition-colors">
                <i class="fas fa-sign-out-alt"></i> Keluar dari Akun
            </button>
        </form>
    </div>
</div>
@endsection
