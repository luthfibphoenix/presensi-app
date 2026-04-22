@extends('layout.app')

@section('title', 'Rekap Jurnal Mengajar')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-sm">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Rekap Jurnal Mengajar Guru</h2>
    </div>

    <form method="GET" action="{{ route('admin.jurnal') }}" class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Guru</label>
                <select name="guru_id" class="w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Guru</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" {{ request('guru_id') == $guru->id ? 'selected' : '' }}>{{ $guru->fullname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 w-full">
                    <i class="fas fa-filter mr-1"></i> Filter Data
                </button>
                <a href="{{ route('admin.jurnal') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-500 text-center w-full">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-300">
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Guru</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Mata Pelajaran</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kelas / Jam</th>
                    <th class="py-3 px-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Materi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($jurnals as $jurnal)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $jurnal->user->fullname ?? 'Unknown' }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $jurnal->mata_pelajaran }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $jurnal->kelas }} ({{ $jurnal->jam_mulai }}-{{ $jurnal->jam_selesai }})</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ Str::limit($jurnal->ringkasan_materi, 50) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-6 px-4 text-center text-gray-500 text-sm">Belum ada jurnal yang sesuai kriteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
