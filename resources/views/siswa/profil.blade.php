@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $siswa = Auth::guard('siswa')->user();
    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($siswa->nama ?? 'Siswa') . '&background=10B981&color=fff&bold=true&size=200';
@endphp
<div class="max-w-3xl mx-auto">

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        
        {{-- Header Banner --}}
        <div class="h-32 bg-gradient-to-r from-green-600 to-emerald-500"></div>

        {{-- Avatar + Info --}}
        <div class="px-8 pb-8">
            <div class="flex items-end gap-5 -mt-14 mb-5">
                <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-md bg-white">
                    <img src="{{ $fallbackUrl }}"
                         alt="Foto Profil"
                         class="w-full h-full object-cover">
                </div>
                <div class="pb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $siswa->nama }}</h1>
                    <p class="text-emerald-600 font-medium">Siswa · {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $fields = [
                        ['label' => 'Nama Lengkap', 'icon' => 'fa-id-card', 'value' => $siswa->nama],
                        ['label' => 'Kelas',        'icon' => 'fa-users',   'value' => $siswa->kelas->nama_kelas ?? '-'],
                        ['label' => 'Username',     'icon' => 'fa-user',    'value' => $siswa->username],
                        ['label' => 'Kode Kelas',   'icon' => 'fa-tag',     'value' => $siswa->kelas->kode_kelas ?? '-'],
                    ];
                @endphp

                @foreach($fields as $field)
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $field['icon'] }} text-emerald-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">{{ $field['label'] }}</p>
                        <p class="text-gray-800 font-semibold mt-0.5">{{ $field['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Logout Button for Mobile --}}
    <div class="mt-6 md:hidden">
        <form action="{{ route('siswa.logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-4 bg-white text-red-600 font-bold rounded-2xl shadow-sm border border-red-50 flex items-center justify-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Keluar dari Akun
            </button>
        </form>
    </div>
</div>
@endsection
