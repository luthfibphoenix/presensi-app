@extends('layouts.ortu_mobile')

@section('content')
<div class="px-4 md:px-0 space-y-6 md:space-y-8">
    @if(session('success'))
    <div class="bg-emerald-500 text-white p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-fade-in">
        <i class="fas fa-check-circle"></i>
        <p class="text-xs font-bold">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-500 text-white p-4 rounded-2xl shadow-lg space-y-1 animate-fade-in">
        <div class="flex items-center gap-3">
            <i class="fas fa-exclamation-triangle"></i>
            <p class="text-xs font-black uppercase tracking-widest">Gagal Mengirim:</p>
        </div>
        <ul class="list-disc list-inside text-[10px] font-bold opacity-90 pl-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Header Page -->
    <div class="bg-white p-5 md:p-8 rounded-3xl md:rounded-[40px] shadow-sm border border-teal-50 flex items-center justify-between gap-6">
        <div>
            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Daftar Izin</h3>
            <h2 class="text-xl md:text-2xl font-black text-slate-900 leading-tight">Pengajuan Izin Siswa</h2>
        </div>
        <div class="hidden sm:flex items-center gap-2 text-teal-500 bg-teal-50 px-4 py-2 rounded-2xl border border-teal-100">
            <i class="fas fa-file-signature"></i>
            <span class="text-xs font-black uppercase tracking-tighter">Status Monitoring</span>
        </div>
    </div>
    <!-- Form Pengajuan Izin Baru -->
    <div class="card-neo p-6 md:p-10 rounded-[3rem] animate-slide-up">
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 bg-teal-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-teal-100 rotate-3">
                <i class="fas fa-paper-plane text-lg"></i>
            </div>
            <div>
                <h4 class="text-base font-black text-slate-900 leading-none">Buat Pengajuan Baru</h4>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1.5">Isi formulir dengan lengkap dan benar</p>
            </div>
        </div>

        <form action="{{ route('ortu.izin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="form-izin">
            @csrf
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="bukti_compressed" id="bukti-compressed">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tanggal -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                        <i class="fas fa-calendar-day text-teal-500"></i>
                        Tanggal Izin
                    </label>
                    <div class="relative">
                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}"
                               class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-base font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all appearance-none outline-none">
                    </div>
                </div>

                <!-- Tipe Izin -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                        <i class="fas fa-tag text-teal-500"></i>
                        Tipe Keterangan
                    </label>
                    <select name="tipe" required
                            class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-5 py-4 text-base font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all appearance-none outline-none">
                        <option value="Izin">Izin (Keperluan Keluarga/Pribadi)</option>
                        <option value="Sakit">Sakit (Membutuhkan Istirahat)</option>
                    </select>
                </div>
            </div>

            <!-- Alasan -->
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                    <i class="fas fa-comment-dots text-teal-500"></i>
                    Alasan / Keterangan Lengkap
                </label>
                <textarea name="alasan" required rows="3" placeholder="Tuliskan alasan yang jelas agar mudah dipahami sekolah..."
                          class="w-full bg-slate-50 border border-slate-100 rounded-3xl px-6 py-5 text-base font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-teal-500/10 focus:border-teal-500 transition-all resize-none placeholder:text-slate-300 outline-none"></textarea>
            </div>

            <!-- Bukti -->
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                    <i class="fas fa-camera text-teal-500"></i>
                    Lampiran Bukti (Wajib Foto)
                </label>
                <div class="relative h-48 group">
                    <!-- Input file transparan di lapisan atas -->
                    <input type="file" name="bukti" id="bukti-input" accept="image/*" capture="environment" required
                           class="absolute inset-0 w-full h-full opacity-0 z-20 cursor-pointer">
                    
                    <!-- Wadah Preview & Desain -->
                    <div id="preview-container" class="absolute inset-0 bg-slate-50 border-2 border-dashed border-slate-200 group-hover:border-teal-300 rounded-[2rem] flex flex-col items-center justify-center transition-all z-10 overflow-hidden">
                        <!-- Tampilan Awal (Kosong) -->
                        <div id="preview-placeholder" class="flex flex-col items-center justify-center text-center p-4">
                            <i class="fas fa-cloud-upload-alt text-2xl text-teal-500 mb-2"></i>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Klik untuk Ambil Foto Bukti</p>
                        </div>
                        <!-- Tampilan Setelah Ada Foto -->
                        <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        <div id="preview-overlay" class="hidden absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-white backdrop-blur-[2px]">
                            <i class="fas fa-camera-rotate text-xl mb-2"></i>
                            <p class="text-[10px] font-black uppercase tracking-widest">Klik untuk Ganti Foto</p>
                        </div>
                    </div>
                </div>
                <p class="text-[9px] text-slate-400 mt-2 ml-4 italic font-medium">*Ambil foto surat dokter atau bukti pendukung lainnya (Wajib, Maks. 10MB)</p>
            </div>

            <!-- Location Status Indicator -->
            <div id="location-status" class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center gap-3">
                <div id="location-icon" class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center animate-pulse">
                    <i class="fas fa-location-dot"></i>
                </div>
                <div class="flex-1">
                    <p id="location-text" class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Mendeteksi Lokasi...</p>
                    <p id="location-detail" class="text-[9px] font-bold text-slate-400">Mohon izinkan akses lokasi untuk keamanan data</p>
                </div>
            </div>
            
            <button type="submit" id="btn-submit" disabled
                    class="w-full bg-slate-400 text-white font-black text-xs uppercase tracking-widest py-5 rounded-[2rem] shadow-xl transition-all flex items-center justify-center gap-4 cursor-not-allowed">
                <i class="fas fa-lock"></i>
                Menunggu Lokasi...
            </button>
        </form>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const statusText = document.getElementById('location-text');
            const statusDetail = document.getElementById('location-detail');
            const statusIcon = document.getElementById('location-icon');
            const submitBtn = document.getElementById('btn-submit');
            const form = document.getElementById('form-izin');
            const buktiInput = document.getElementById('bukti-input');
            const buktiCompressed = document.getElementById('bukti-compressed');
            const imagePreview = document.getElementById('image-preview');
            const previewPlaceholder = document.getElementById('preview-placeholder');
            const previewOverlay = document.getElementById('preview-overlay');

            // Handle Image Preview & Compression
            buktiInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // 1. Tampilkan Preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        previewPlaceholder.classList.add('hidden');
                        previewOverlay.classList.remove('hidden');
                        
                        // 2. Kompres Gambar
                        const img = new Image();
                        img.src = e.target.result;
                        img.onload = function() {
                            const canvas = document.createElement('canvas');
                            let width = img.width;
                            let height = img.height;
                            const max_size = 1024; // Maksimal resolusi 1024px

                            if (width > height) {
                                if (width > max_size) {
                                    height *= max_size / width;
                                    width = max_size;
                                }
                            } else {
                                if (height > max_size) {
                                    width *= max_size / height;
                                    height = max_size;
                                }
                            }
                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);
                            
                            // Simpan sebagai Base64 dengan kualitas 70%
                            buktiCompressed.value = canvas.toDataURL('image/jpeg', 0.7);
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    });
                } else {
                    statusText.innerText = "Geolocation Tidak Didukung";
                    statusDetail.innerText = "Browser Anda tidak mendukung fitur lokasi.";
                }
            }

            function showPosition(position) {
                latInput.value = position.coords.latitude;
                lngInput.value = position.coords.longitude;
                
                // Update UI
                statusText.innerText = "Lokasi Berhasil Terkunci";
                statusText.classList.remove('text-slate-500');
                statusText.classList.add('text-emerald-600');
                
                statusDetail.innerText = "Koordinat: " + position.coords.latitude.toFixed(6) + ", " + position.coords.longitude.toFixed(6);
                
                statusIcon.classList.remove('bg-amber-100', 'text-amber-600', 'animate-pulse');
                statusIcon.classList.add('bg-emerald-100', 'text-emerald-600');
                
                // Enable Submit Button
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-slate-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-teal-600', 'hover:bg-teal-700', 'shadow-teal-100', 'hover:scale-[1.02]', 'active:scale-95');
                submitBtn.innerHTML = '<i class="fas fa-check-double"></i> KIRIM PENGAJUAN IZIN';
            }

            function showError(error) {
                let msg = "";
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        msg = "Akses lokasi ditolak. Mohon aktifkan di pengaturan browser.";
                        break;
                    case error.POSITION_UNAVAILABLE:
                        msg = "Informasi lokasi tidak tersedia.";
                        break;
                    case error.TIMEOUT:
                        msg = "Waktu permintaan lokasi habis.";
                        break;
                    case error.UNKNOWN_ERROR:
                        msg = "Terjadi kesalahan yang tidak diketahui.";
                        break;
                }
                statusText.innerText = "Gagal Mendapatkan Lokasi";
                statusText.classList.add('text-red-600');
                statusDetail.innerText = msg;
                statusIcon.classList.remove('bg-amber-100', 'text-amber-600', 'animate-pulse');
                statusIcon.classList.add('bg-red-100', 'text-red-600');
                
                submitBtn.innerHTML = '<i class="fas fa-redo"></i> Coba Lagi Dapatkan Lokasi';
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-slate-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-slate-800');
                
                submitBtn.onclick = function(e) {
                    if (submitBtn.innerText.includes('Coba Lagi')) {
                        e.preventDefault();
                        location.reload();
                    }
                };
            }

            getLocation();
        });
    </script>
    @endpush

</div>
@endsection
