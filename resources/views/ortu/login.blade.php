<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Orang Tua - Presensi App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-orange-100">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Portal Orang Tua</h1>
            <p class="text-slate-500">Silakan masuk untuk memantau kehadiran anak Anda</p>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <form action="{{ route('ortu.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">NIS Siswa / Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan NIS Siswa atau Username" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-orange-500 transition-all" required>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Contoh: ayah123 / ibu123" class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-orange-500 transition-all" required>
                    <div class="mt-2 bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Petunjuk Login:</p>
                        <p class="text-[10px] text-slate-400 leading-relaxed">
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-orange-500 focus:ring-orange-500">
                        <span class="text-sm font-medium text-slate-600">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-4 bg-orange-500 text-white font-bold rounded-2xl shadow-lg shadow-orange-100 hover:bg-orange-600 transition-all">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>

        <p class="text-center mt-8 text-sm text-slate-400 font-medium">
            Copyright &copy; 2026 Presensi App
        </p>
    </div>
</body>
</html>
