<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\BlangkoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BkController;
use App\Http\Controllers\TuController;
use App\Http\Controllers\OrangtuaAuthController;

// Public routes
Route::get('/', function () {
    if (auth('web')->check()) {
        return redirect()->route('dashboard');
    }
    if (auth('siswa')->check()) {
        return redirect()->route('siswa.dashboard');
    }
    return redirect()->route('login');
});

// Photo proxy
Route::get('/proxy/photo/{userId}', function ($userId) {
    $user = App\Models\User::findOrFail($userId);
    $rawUrl = $user->getRawOriginal('photo_url');
    if (empty($rawUrl)) {
        abort(404);
    }
    preg_match('/[-\w]{25,}/', $rawUrl, $match);
    $fileId = $match[0] ?? null;
    if (!$fileId) abort(404);
    $downloadUrl = "https://drive.google.com/uc?export=view&id={$fileId}";
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->timeout(10)
        ->get($downloadUrl);
    if ($response->failed()) abort(404);
    return response($response->body(), 200)
        ->header('Content-Type', $response->header('Content-Type') ?? 'image/jpeg')
        ->header('Cache-Control', 'public, max-age=86400');
})->name('photo.proxy');

// Auth Guru/Admin - pisah POST per role
// Auth Unified Login
Route::get('/login',        [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',       [AuthController::class, 'login'])->name('login.post');
Route::post('/logout',      [AuthController::class, 'logout'])->name('logout');
Route::get('/logout',       [AuthController::class, 'logout']);

// Redirect old login routes
Route::get('/login/guru',   function() { return redirect()->route('login'); });
Route::get('/login/piket',  function() { return redirect()->route('login'); });
Route::get('/login/admin',  function() { return redirect()->route('login'); });
Route::get('/login/bk',     function() { return redirect()->route('login'); });
Route::get('/siswa/login',  function() { return redirect()->route('login'); })->name('siswa.login');
// Orang Tua Login Routes
Route::get('/ortu/login',   [OrangtuaAuthController::class, 'showLoginForm'])->name('ortu.login');
Route::post('/ortu/login',  [OrangtuaAuthController::class, 'login'])->name('ortu.login.post');
Route::post('/ortu/logout', [OrangtuaAuthController::class, 'logout'])->name('ortu.logout');
Route::get('/ortu/logout',  [OrangtuaAuthController::class, 'logout']);

// Redirect old login routes
Route::get('/login/guru',   function() { return redirect()->route('login'); });
Route::get('/login/piket',  function() { return redirect()->route('login'); });
Route::get('/login/admin',  function() { return redirect()->route('login'); });
Route::get('/login/bk',     function() { return redirect()->route('login'); });
Route::get('/siswa/login',  function() { return redirect()->route('login'); })->name('siswa.login');
Route::post('/siswa/logout', function() { return redirect()->route('logout'); })->name('siswa.logout');

// Web Guard (Admin, Guru, BK, Wali Kelas)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
    Route::post('/profil/password', [AuthController::class, 'updatePassword'])->name('profil.password');

    // Kelas (Pindahkan ke luar group role agar terdefinisi global di auth)
    Route::get('/kelas', [\App\Http\Controllers\KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [\App\Http\Controllers\KelasController::class, 'store'])->name('kelas.store');
    Route::delete('/kelas/{id}', [\App\Http\Controllers\KelasController::class, 'destroy'])->name('kelas.destroy');

    // Admin, BK, Piket, Kakonli, Kurikulum, & TU
    Route::middleware('role:Administrator,Guru BK,Guru Piket,Kakonli,Kurikulum,TU')->group(function () {
        Route::get('/laporan',              [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/rekap-harian', [LaporanController::class, 'rekapHarian'])->name('laporan.rekap_harian');
        Route::get('/izin-guru',            [IzinController::class, 'indexGuru'])->name('izin.guru');
        Route::post('/izin-guru',           [IzinController::class, 'storeGuru'])->name('izin.store.guru');
        Route::post('/izin-guru/{id}/approve', [IzinController::class, 'approve'])->name('izin.approve');
        Route::post('/izin-guru/{id}/reject',  [IzinController::class, 'reject'])->name('izin.reject');
        
        // Database Siswa
        Route::get('/data-siswa',           [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswa.index');

        // Admin
        Route::get('/admin', [AdminController::class, 'index'])->name('guru.index');
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/jurnal', [AdminController::class, 'jurnal'])->name('admin.jurnal');
        Route::get('/admin/mapel', [AdminController::class, 'mapelIndex'])->name('admin.mapel.index');
        Route::post('/admin/mapel', [AdminController::class, 'mapelStore'])->name('admin.mapel.store');
        Route::delete('/admin/mapel/{id}', [AdminController::class, 'mapelDestroy'])->name('admin.mapel.destroy');
        Route::get('/admin/password', [AdminController::class, 'passwordIndex'])->name('admin.password.index');
        Route::post('/admin/password/reset', [AdminController::class, 'passwordReset'])->name('admin.password.reset');
        
        // BK
        Route::get('/bk/surat-panggil', [BkController::class, 'suratPanggil'])->name('bk.surat_panggil');
        
        // TU
        Route::get('/tu/surat-dinas', [TuController::class, 'suratDinas'])->name('tu.surat_dinas');
    });

    // Guru, Wali Kelas, Admin, & Piket — Jadwal & QR
    Route::middleware('role:Administrator,Guru,Wali Kelas,Guru Piket')->group(function () {
        Route::get('/guru/jadwal',              [\App\Http\Controllers\QrController::class, 'jadwalHariIni'])->name('jadwal.hari.ini');
        Route::get('/guru/jadwal/semua',        [\App\Http\Controllers\QrController::class, 'jadwalSemua'])->name('jadwal.semua');
        Route::get('/jadwal',                   [JadwalController::class, 'index'])->name('jadwal.index');

        Route::get('/guru/qr/auto-generate',    [\App\Http\Controllers\QrController::class, 'autoGenerate'])->name('presensi.auto_generate');
        Route::get('/guru/qr/generate',         [\App\Http\Controllers\QrController::class, 'generateView'])->name('presensi.generate.view');
        Route::post('/dashboard/generate-qr',   [DashboardController::class, 'generateQR'])->name('dashboard.generate_qr');
        Route::post('/dashboard/end-session',    [DashboardController::class, 'endSession'])->name('dashboard.end_session');
        Route::post('/guru/qr/generate',        [\App\Http\Controllers\QrController::class, 'generate'])->name('guru.qr.generate');
        Route::get('/guru/mulai-kelas/{sessionId}',  [\App\Http\Controllers\QrController::class, 'mulaiKelas'])->name('guru.mulai.kelas');
        Route::post('/guru/mulai-kelas/{sessionId}/jurnal', [\App\Http\Controllers\QrController::class, 'saveJurnal'])->name('guru.mulai.kelas.jurnal');
        Route::post('/guru/qr/refresh/{sessionId}',  [\App\Http\Controllers\QrController::class, 'refresh'])->name('guru.qr.refresh');
        Route::get('/guru/qr/refresh-json/{sessionId}', [\App\Http\Controllers\QrController::class, 'tokenRefreshJson'])->name('guru.qr.refresh_json');
        Route::post('/guru/qr/end/{sessionId}',      [\App\Http\Controllers\QrController::class, 'end'])->name('guru.qr.end');

        Route::get('/guru/qr/status',                [\App\Http\Controllers\QrController::class, 'statusIndex'])->name('guru.qr.status.index');
        Route::get('/guru/qr/status/{jadwalId}',     [\App\Http\Controllers\QrController::class, 'status'])->name('guru.qr.status');
        Route::get('/guru/qr/status-json/{jadwalId}',[\App\Http\Controllers\QrController::class, 'statusJson'])->name('guru.qr.status.json');

        // Jurnal Mengajar
        Route::get('/guru/jurnal', [JurnalController::class, 'index'])->name('guru.jurnal.index');
        Route::get('/guru/jurnal/create', [JurnalController::class, 'create'])->name('guru.jurnal.create');
        Route::post('/guru/jurnal', [JurnalController::class, 'store'])->name('guru.jurnal.store');
        Route::get('/guru/jurnal/cetak', [JurnalController::class, 'cetak'])->name('guru.jurnal.cetak');
        Route::get('/guru/jurnal/{jurnal}/edit', [JurnalController::class, 'edit'])->name('guru.jurnal.edit');
        Route::put('/guru/jurnal/{jurnal}', [JurnalController::class, 'update'])->name('guru.jurnal.update');
        Route::delete('/guru/jurnal/all', [JurnalController::class, 'deleteAll'])->name('guru.jurnal.deleteAll');
        Route::delete('/guru/jurnal/{jurnal}', [JurnalController::class, 'destroy'])->name('guru.jurnal.destroy');
        
        // Penilaian
        Route::get('/guru/penilaian', [PenilaianController::class, 'index'])->name('guru.penilaian.index');
        Route::get('/guru/penilaian/create', [PenilaianController::class, 'create'])->name('guru.penilaian.create');
        Route::post('/guru/penilaian', [PenilaianController::class, 'store'])->name('guru.penilaian.store');
        
        // Cetak Blangko
        Route::get('/guru/blangko', [BlangkoController::class, 'index'])->name('guru.blangko.index');
        Route::get('/guru/blangko/presensi', [BlangkoController::class, 'presensi'])->name('guru.blangko.presensi');
        Route::get('/guru/blangko/nilai', [BlangkoController::class, 'nilai'])->name('guru.blangko.nilai');
        Route::get('/guru/blangko/cover', [BlangkoController::class, 'cover'])->name('guru.blangko.cover');

        // Catatan Siswa
        Route::get('/guru/catatan', [\App\Http\Controllers\CatatanSiswaController::class, 'index'])->name('guru.catatan.index');
        Route::post('/guru/catatan', [\App\Http\Controllers\CatatanSiswaController::class, 'store'])->name('catatan.store');
        Route::delete('/guru/catatan/{id}', [\App\Http\Controllers\CatatanSiswaController::class, 'destroy'])->name('catatan.destroy');
    });
});

// Rute Cetak Izin (Bisa diakses Guru & Ortu)
Route::get('/izin/print/{id}', [IzinController::class, 'print'])->name('izin.print');


// Siswa Guard
Route::middleware(['auth:siswa', 'siswa.autologout'])->group(function () {
    Route::get('/siswa/dashboard',      [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard');
    Route::get('/siswa/scan',           [\App\Http\Controllers\QrController::class, 'scanner'])->name('presensi.scan');
    Route::get('/siswa/scan/{token}',   [\App\Http\Controllers\QrController::class, 'scan'])->name('siswa.scan');
    Route::get('/siswa/riwayat',        [PresensiController::class, 'riwayatSiswa'])->name('siswa.riwayat');
    Route::get('/siswa/izin',           [IzinController::class, 'indexSiswa'])->name('izin.index');
    Route::post('/siswa/izin',          [IzinController::class, 'storeSiswa'])->name('izin.store');
    Route::get('/siswa/profil', function () {
        return view('siswa.profil');
    })->name('siswa.profil');
    Route::post('/siswa/profil/password', [SiswaAuthController::class, 'updatePassword'])->name('siswa.profil.password');
});

// Orang Tua Routes
Route::prefix('ortu')->group(function () {
    Route::middleware('orangtua')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\OrtuDashboardController::class, 'index'])->name('ortu.dashboard');
        Route::get('/kehadiran', [\App\Http\Controllers\OrtuDashboardController::class, 'kehadiran'])->name('ortu.kehadiran');
        Route::get('/izin',      [\App\Http\Controllers\OrtuDashboardController::class, 'izin'])->name('ortu.izin');
        Route::post('/izin',     [\App\Http\Controllers\OrtuDashboardController::class, 'storeIzin'])->name('ortu.izin.store');
        Route::get('/profil',    [\App\Http\Controllers\OrtuDashboardController::class, 'profil'])->name('ortu.profil');
        Route::post('/profil/password', [\App\Http\Controllers\OrtuDashboardController::class, 'updatePassword'])->name('ortu.password.update');
    });
});