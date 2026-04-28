@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $user = Auth::user();
    $loginRole = session('login_role', 'guru');
    $pos = strtolower($user->position ?? '');
    
    $theme = 'blue';
    $role = session('login_role', 'guru');
    
    if ($role === 'siswa') {
        $theme = 'teal';
    } elseif ($role === 'piket') {
        $theme = 'green';
    } elseif ($role === 'tu') {
        $theme = 'violet';
    } elseif ($role === 'admin' || str_contains($pos, 'administrator')) {
        $theme = 'purple';
    }

    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname ?? 'User') . '&background=f1f5f9&color=334155&bold=true&size=200';
@endphp

<div class="h-full overflow-y-auto no-scrollbar pb-20 max-w-4xl mx-auto space-y-6">
    {{-- Profile Header Card --}}
    <div class="bg-white rounded-3xl shadow-xl shadow-{{ $theme }}-900/5 overflow-hidden border border-gray-100">
        {{-- Elegant Gradient Banner --}}
        @php
            $gradients = [
                'blue'   => 'from-blue-700 via-blue-600 to-indigo-600',
                'green'  => 'from-green-700 via-green-600 to-emerald-600',
                'teal'   => 'from-teal-700 via-teal-600 to-emerald-600',
                'violet' => 'from-violet-700 via-violet-600 to-purple-600',
                'purple' => 'from-purple-700 via-purple-600 to-fuchsia-600',
                'cyan'   => 'from-cyan-700 via-cyan-600 to-blue-600',
            ];
            $currentGradient = $gradients[$theme] ?? $gradients['blue'];
        @endphp
        <div class="h-40 bg-gradient-to-br {{ $currentGradient }} relative">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_50%_120%,rgba(255,255,255,0.5),transparent)]"></div>
        </div>

        {{-- Profile Info Section --}}
        <div class="px-6 md:px-10 pb-10">
            <div class="flex flex-col md:flex-row items-center md:items-end gap-6 -mt-16 mb-8">
                <div class="relative">
                    <img src="{{ $user->photo_url }}"
                         alt="Foto Profil"
                         onerror="this.onerror=null; this.src='{{ $fallbackUrl }}';"
                         class="w-36 h-36 rounded-3xl object-cover border-4 border-white shadow-2xl bg-white">
                    <div class="absolute -bottom-2 -right-2 bg-green-500 w-6 h-6 rounded-full border-4 border-white shadow-sm"></div>
                </div>
                <div class="text-center md:text-left pb-2 flex-grow">
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ $user->fullname }}</h1>
                    <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                        <span class="px-3 py-1 bg-{{ $theme }}-50 text-{{ $theme }}-700 text-xs font-bold uppercase rounded-full border border-{{ $theme }}-100">
                            {{ $user->position }}
                        </span>
                        @if($user->is_wali)
                        <span class="px-3 py-1 bg-purple-50 text-purple-700 text-xs font-bold uppercase rounded-full border border-purple-100">
                            Wali Kelas
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info Details Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $fields = [
                        ['label' => 'Username',    'icon' => 'fa-user',           'value' => $user->username, 'color' => $theme],
                        ['label' => 'NIP / ID',    'icon' => 'fa-id-badge',       'value' => $user->nip ?? '-', 'color' => $theme],
                        ['label' => 'Pangkat',     'icon' => 'fa-layer-group',    'value' => $user->pangkat ?? '-', 'color' => $theme],
                        ['label' => 'Jabatan',     'icon' => 'fa-briefcase',      'value' => $user->jabatan ?? '-', 'color' => $theme],
                        ['label' => 'Fungsional',  'icon' => 'fa-sitemap',        'value' => $user->position, 'color' => $theme],
                        ['label' => 'Status Wali', 'icon' => 'fa-chalkboard-teacher', 'value' => $user->is_wali ? 'Aktif' : 'Tidak', 'color' => $user->is_wali ? 'purple' : 'gray'],
                    ];
                @endphp

                @foreach($fields as $field)
                <div class="group p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-{{ $theme }}-200 hover:bg-white hover:shadow-md transition-all duration-300">
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
    <div class="bg-white rounded-3xl shadow-xl shadow-{{ $theme }}-900/5 overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
            <div>
                <h2 class="text-xl font-black text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-{{ $theme }}-600 flex items-center justify-center text-white shadow-lg shadow-{{ $theme }}-200">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    Keamanan Akun
                </h2>
                <p class="text-sm text-gray-500 mt-1 ml-13">Perbarui password Anda secara berkala untuk menjaga keamanan.</p>
            </div>
        </div>
        
        <div class="p-8 md:px-12">
            <form action="{{ route('profil.password') }}" method="POST" class="max-w-2xl mx-auto space-y-6" x-data="{ showCurrent: false, showNew: false, showConf: false }">
                @csrf
                
                {{-- Current Password --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-bold text-gray-700 ml-1">Password Saat Ini</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-{{ $theme }}-600 text-gray-400">
                            <i class="fas fa-key"></i>
                        </div>
                        <input :type="showCurrent ? 'text' : 'password'" 
                               name="current_password" 
                               placeholder="Masukkan password lama..."
                               required 
                               class="w-full pl-11 pr-12 py-3.5 bg-gray-100 border-2 border-gray-200 rounded-2xl cursor-not-allowed transition-all outline-none text-gray-400 font-medium placeholder:text-gray-400 placeholder:font-normal"
                               disabled>
                        <button type="button" 
                                @click="showCurrent = !showCurrent"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-{{ $theme }}-600 transition-colors">
                            <i class="fas" :class="showCurrent ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- New Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-bold text-gray-700 ml-1">Password Baru</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-{{ $theme }}-600">
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
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-{{ $theme }}-600">
                                <i class="fas" :class="showNew ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Confirm New Password --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-bold text-gray-700 ml-1">Konfirmasi Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-{{ $theme }}-600">
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
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-{{ $theme }}-600">
                                <i class="fas" :class="showConf ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end pt-4">
                    <button type="button" class="group relative w-full md:w-auto bg-gray-300 text-gray-500 px-10 py-4 rounded-2xl font-black text-lg cursor-not-allowed transition-all duration-300 flex items-center justify-center gap-3" disabled title="Fitur ini dinonaktifkan sementara">
                        <i class="fas fa-lock text-gray-400"></i>
                        Fitur Dinonaktifkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
