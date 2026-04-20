@extends('layout.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $user = Auth::user();
    $fallbackUrl = 'https://ui-avatars.com/api/?name=' . urlencode($user->fullname ?? 'User') . '&background=3B82F6&color=fff&bold=true&size=200';
@endphp
<div class="max-w-3xl mx-auto">

    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        
        {{-- Header Banner --}}
        <div class="h-32 bg-gradient-to-r from-blue-700 to-blue-500"></div>

        {{-- Avatar + Info --}}
        <div class="px-8 pb-8">
            <div class="flex items-end gap-5 -mt-14 mb-5">
                <img src="{{ $user->photo_url }}"
                     alt="Foto Profil"
                     onerror="this.onerror=null; this.src='{{ $fallbackUrl }}';"
                     class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md">
                <div class="pb-2">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->fullname }}</h1>
                    <p class="text-blue-600 font-medium">{{ $user->position }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $fields = [
                        ['label' => 'Username',    'icon' => 'fa-user',           'value' => $user->username],
                        ['label' => 'NIP',         'icon' => 'fa-id-badge',       'value' => $user->nip       ?? '-'],
                        ['label' => 'Pangkat',     'icon' => 'fa-layer-group',    'value' => $user->pangkat   ?? '-'],
                        ['label' => 'Jabatan',     'icon' => 'fa-briefcase',      'value' => $user->jabatan   ?? '-'],
                        ['label' => 'Jabatan Fungsional', 'icon' => 'fa-sitemap', 'value' => $user->position],
                        ['label' => 'Wali Kelas',  'icon' => 'fa-chalkboard-teacher', 'value' => $user->is_wali ? 'Ya' : 'Tidak'],
                    ];
                @endphp

                @foreach($fields as $field)
                <div class="flex items-start gap-3 p-4 bg-gray-50 rounded-xl">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas {{ $field['icon'] }} text-blue-600 text-sm"></i>
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
</div>
@endsection
