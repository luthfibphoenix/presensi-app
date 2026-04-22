@extends('layout.app')

@section('title', 'Reset Password Pengguna')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Lengkap</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jabatan</th>
                <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($users as $u)
            <tr>
                <td class="px-6 py-4">
                    <p class="text-sm font-black text-gray-800">{{ $u->fullname }}</p>
                    <p class="text-[10px] text-gray-400 font-bold tracking-tight">{{ $u->username }}</p>
                </td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black uppercase rounded-lg">
                        {{ $u->position ?? 'Staff' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('admin.password.reset') }}" method="POST" class="flex items-center justify-end gap-2">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $u->id }}">
                        <input type="text" name="password" placeholder="Password Baru" class="bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-1 focus:ring-purple-500 w-32" required>
                        <button type="submit" class="bg-purple-600 text-white font-black px-4 py-1.5 rounded-lg text-[10px] hover:bg-purple-700 transition uppercase">
                            Reset
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
