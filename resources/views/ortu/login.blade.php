<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#0d9488">
    <title>Login Orang Tua - SmartPresensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #f8fafc; 
            -webkit-tap-highlight-color: transparent;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .bg-gradient-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(13, 148, 136, 0.1) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(13, 148, 136, 0.1) 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-gradient-mesh min-h-[100dvh] flex flex-col items-center justify-center p-6">
    <div class="max-w-[420px] w-full space-y-8 my-auto">
        <div class="text-center animate-fade-in">
            <div class="w-20 h-20 bg-white rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 shadow-2xl shadow-slate-100 p-2 border border-slate-100 rotate-3 transition-transform hover:rotate-0">
                <img src="{{ asset('images/logo-kanan.png') }}" alt="Logo SMKN7" class="w-full h-full object-contain">
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-none">Smart<span class="text-teal-600">Presensi</span></h1>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-3">Portal Orang Tua</p>
        </div>

        <div class="glass-card p-8 md:p-10 rounded-[3rem] shadow-2xl shadow-slate-200/50">
            <form action="{{ route('ortu.login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Username / NIS</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <i class="fa-solid fa-user-circle"></i>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}" placeholder="Contoh: rizka.3398" 
                            class="w-full pl-12 pr-6 py-4 rounded-2xl bg-white border border-slate-100 focus:border-teal-500 focus:ring-4 focus:ring-teal-50 transition-all text-base font-bold placeholder:text-slate-300 placeholder:font-medium outline-none" required>
                    </div>
                    @error('username')
                        <p class="text-rose-500 text-[10px] font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Password Keamanan</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-teal-500 transition-colors">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" id="password" name="password" placeholder="Default: ortu123" 
                            class="w-full pl-12 pr-12 py-4 rounded-2xl bg-white border border-slate-100 focus:border-teal-500 focus:ring-4 focus:ring-teal-50 transition-all text-base font-bold placeholder:text-slate-300 placeholder:font-medium outline-none" required>
                        <button type="button" onclick="togglePassword('password', 'eye-icon')" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-400 hover:text-teal-500 transition-colors focus:outline-none">
                            <i id="eye-icon" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-slate-200 text-teal-600 focus:ring-teal-500 transition-all">
                        <span class="text-[11px] font-bold text-slate-500 group-hover:text-teal-600 transition-colors">Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-5 bg-teal-600 hover:bg-teal-700 text-white font-black rounded-2xl shadow-xl shadow-teal-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3 uppercase tracking-widest text-xs">
                    Masuk Sekarang
                    <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-50">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-teal-50 text-teal-600 rounded-lg flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-circle-info text-xs"></i>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium leading-relaxed">
                        Gunakan username yang terdiri dari <span class="font-bold text-slate-600">nama depan anak dan NIS</span>. Jika belum memiliki akun, hubungi admin sekolah.
                    </p>
                </div>
            </div>
        </div>

        <p class="text-center text-[10px] font-bold text-slate-300 uppercase tracking-widest">
            &copy; 2026 SmartPresensi SMKN 7 Purworejo
        </p>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
