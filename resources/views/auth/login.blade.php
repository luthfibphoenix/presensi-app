<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Presensi SMKN7</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .input-focus:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-slate-100 md:overflow-hidden">
    <div class="max-w-md w-full bg-white p-10 rounded-[3rem] shadow-2xl shadow-slate-200 border border-white">
        <!-- Fingerprint Icon -->
        <div class="mb-6 flex justify-center">
            <div class="w-20 h-20 bg-indigo-500 rounded-3xl flex items-center justify-center text-white text-4xl shadow-lg shadow-indigo-100">
                <i class="fas fa-fingerprint"></i>
            </div>
        </div>

        <!-- Titles -->
        <div class="text-center">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Selamat Datang</h1>
            <p class="text-slate-400 text-sm font-medium mb-10 leading-relaxed px-4">Silakan login untuk mengakses Sistem Presensi SMKN7</p>
        </div>

        <!-- Form -->
        <form action="{{ route('login.post') }}" method="POST" class="text-left space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Username / NIP</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-blue-500">
                        <i class="fas fa-user text-sm"></i>
                    </span>
                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan identitas Anda" class="w-full pl-12 pr-6 py-4 rounded-full border border-slate-200 bg-slate-50/50 input-focus transition-all text-sm font-medium text-slate-700" required>
                </div>
                @error('username')
                    <p class="text-red-500 text-[10px] mt-2 ml-4 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-blue-500">
                        <i class="fas fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" placeholder="Masukkan password" class="w-full pl-12 pr-6 py-4 rounded-full border border-slate-200 bg-slate-50/50 input-focus transition-all text-sm font-medium text-slate-700" required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-500 text-white font-bold rounded-full shadow-xl shadow-blue-100 hover:bg-blue-600 transition-all active:scale-[0.98]">
                    Masuk ke Sistem
                </button>
            </div>
        </form>

        <!-- Footer -->
        <p class="mt-12 text-center text-slate-300 text-[10px] font-bold uppercase tracking-widest">
            SMK Negeri 7 Purworejo &copy; 2026
        </p>
    </div>
</body>
</html>
