@extends('layout.app')
@section('title', 'Semua Jadwal')

@section('content')
{{-- Tab navigasi --}}
<div class="flex gap-2 mb-6">
    <a href="{{ route('jadwal.hari.ini') }}"
       class="px-4 py-2 rounded-lg font-medium text-sm {{ request()->routeIs('jadwal.hari.ini') ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        <i class="fas fa-calendar-day mr-1"></i> Jadwal Hari Ini
    </a>
    <a href="{{ route('jadwal.semua') }}"
       class="px-4 py-2 rounded-lg font-medium text-sm {{ request()->routeIs('jadwal.semua') ? 'bg-blue-600 text-white shadow' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
        <i class="fas fa-calendar-week mr-1"></i> Semua Jadwal
    </a>
</div>

@if($jadwals->isEmpty())
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    <i class="fas fa-calendar-times text-gray-300 text-4xl mb-3"></i>
    <p class="text-gray-500">Tidak ada jadwal mengajar.</p>
</div>
@else
@php
    $grouped = $jadwals->groupBy('hari');
    $hariOrder = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
@endphp
<div class="space-y-6">
    @foreach($hariOrder as $hari)
    @if($grouped->has($hari))
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-3 border-b border-gray-100 flex items-center gap-2 {{ $hari === $hariIni ? 'bg-blue-50' : 'bg-gray-50' }}">
            <i class="fas fa-calendar text-blue-400 text-sm"></i>
            <span class="font-semibold text-gray-700">{{ $hari }}</span>
            @if($hari === $hariIni)
            <span class="ml-1 px-2 py-0.5 text-xs font-bold bg-blue-500 text-white rounded-full">Hari Ini</span>
            @endif
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($grouped[$hari] as $jadwal)
            @php
                $jamMulaiStr   = $jamMap[$jadwal->jam_mulai]  ?? sprintf('%02d:00', 6 + $jadwal->jam_mulai);
                $jamSelesaiStr = $jamMap[$jadwal->jam_selesai] ?? sprintf('%02d:00', 6 + $jadwal->jam_selesai);
                $isHariIni  = ($jadwal->hari === $hariIni);
                $isWaktunya = $isHariIni && ($nowTime >= $jamMulaiStr && $nowTime <= $jamSelesaiStr);
                $isAkanMulai= $isHariIni && ($nowTime >= date('H:i', strtotime($jamMulaiStr . ' -15 minutes')) && $nowTime < $jamMulaiStr);
                $bolehMulai = $isWaktunya || $isAkanMulai;
            @endphp
            <div class="flex items-center justify-between px-6 py-4 gap-4 {{ $isWaktunya ? 'bg-green-50' : '' }}">
                <div class="flex items-center gap-4">
                    <div class="w-16 text-center">
                        <p class="text-xs text-gray-400">Jam ke</p>
                        <p class="font-bold text-blue-700 text-lg leading-tight">{{ $jadwal->jam_mulai }}–{{ $jadwal->jam_selesai }}</p>
                        <p class="text-[10px] text-gray-400 font-mono">{{ $jamMulaiStr }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $jadwal->mata_pelajaran }}</p>
                        <p class="text-sm text-gray-500">Kelas {{ $jadwal->kelas }} · Semester {{ $jadwal->semester }}</p>
                    </div>
                </div>
                @if($bolehMulai)
                <form action="{{ route('guru.qr.generate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow transition">
                        <i class="fas fa-play-circle"></i> Mulai Kelas
                    </button>
                </form>
                @elseif($isHariIni)
                <span class="text-xs text-gray-400 italic">Jam {{ $jamMulaiStr }}</span>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endforeach
</div>
@endif
@endsection
