@extends('layout.app')

@section('title', 'Penilaian Siswa')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Daftar Nilai Siswa</h2>
        <a href="{{ route('guru.penilaian.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
            <i class="fas fa-plus mr-1"></i> Input Nilai Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kelas</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Siswa</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Komponen</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nilai</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($penilaians as $nilai)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 text-sm text-gray-800">{{ \Carbon\Carbon::parse($nilai->tanggal)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $nilai->mata_pelajaran }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $nilai->kelas }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800 font-medium">{{ $nilai->nama_siswa }}</td>
                    <td class="py-3 px-4 text-sm text-gray-800">{{ $nilai->komponen }}</td>
                    <td class="py-3 px-4 text-sm font-bold {{ $nilai->nilai < 75 ? 'text-red-600' : 'text-green-600' }}">{{ $nilai->nilai }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-6 px-4 text-center text-gray-500 text-sm">Belum ada data nilai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
