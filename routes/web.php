<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiswaAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\IzinController;

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

// Photo proxy - fetch Google Drive images server-side to avoid CORS block
Route::get('/proxy/photo/{userId}', function ($userId) {
    $user = App\Models\User::findOrFail($userId);
    $rawUrl = $user->getRawOriginal('photo_url');
    if (empty($rawUrl)) {
        abort(404);
    }
    // Convert to direct download URL
    preg_match('/[-\w]{25,}/', $rawUrl, $match);
    $fileId = $match[0] ?? null;
    if (!$fileId) abort(404);
    $downloadUrl = "https://drive.google.com/uc?export=view&id={$fileId}";
    $client = new \Illuminate\Http\Client\Factory();
    $response = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->timeout(10)
        ->get($downloadUrl);
    if ($response->failed()) abort(404);
    return response($response->body(), 200)
        ->header('Content-Type', $response->header('Content-Type') ?? 'image/jpeg')
        ->header('Cache-Control', 'public, max-age=86400');
})->name('photo.proxy');

// Auth Guru/Admin
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Auth Siswa
Route::get('/siswa/login', [SiswaAuthController::class, 'showLoginForm'])->name('siswa.login');
Route::post('/siswa/login', [SiswaAuthController::class, 'login']);
Route::post('/siswa/logout', [SiswaAuthController::class, 'logout'])->name('siswa.logout');

// Web Guard (Admin, Guru, BK, Wali Kelas)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');

    // Admin & BK
    Route::middleware('role:Administrator,Guru BK')->group(function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/izin-guru', [IzinController::class, 'indexGuru'])->name('izin.guru');
        Route::post('/izin-guru/{id}/approve', [IzinController::class, 'approve'])->name('izin.approve');
        Route::post('/izin-guru/{id}/reject', [IzinController::class, 'reject'])->name('izin.reject');
    });

    // Guru & Wali Kelas & Admin — Jadwal & QR
    Route::middleware('role:Administrator,Guru,Wali Kelas')->group(function () {
        // Jadwal
        Route::get('/guru/jadwal',       [\App\Http\Controllers\QrController::class, 'jadwalHariIni'])->name('jadwal.hari.ini');
        Route::get('/guru/jadwal/semua', [\App\Http\Controllers\QrController::class, 'jadwalSemua'])->name('jadwal.semua');
        Route::get('/jadwal',            [JadwalController::class, 'index'])->name('jadwal.index');

        // Generate & Mulai Kelas
        Route::get('/guru/qr/generate',                     [\App\Http\Controllers\QrController::class, 'generateView'])->name('presensi.generate');
        Route::post('/guru/qr/generate',                    [\App\Http\Controllers\QrController::class, 'generate'])->name('guru.qr.generate');
        Route::get('/guru/mulai-kelas/{sessionId}',         [\App\Http\Controllers\QrController::class, 'mulaiKelas'])->name('guru.mulai.kelas');
        Route::post('/guru/qr/refresh/{sessionId}',         [\App\Http\Controllers\QrController::class, 'refresh'])->name('guru.qr.refresh');
        Route::post('/guru/qr/end/{sessionId}',             [\App\Http\Controllers\QrController::class, 'end'])->name('guru.qr.end');

        // Status
        Route::get('/guru/qr/status',                       [\App\Http\Controllers\QrController::class, 'statusIndex'])->name('guru.qr.status.index');
        Route::get('/guru/qr/status/{jadwalId}',            [\App\Http\Controllers\QrController::class, 'status'])->name('guru.qr.status');
        Route::get('/guru/qr/status-json/{jadwalId}',       [\App\Http\Controllers\QrController::class, 'statusJson'])->name('guru.qr.status.json');
    });
});

// Siswa Guard
Route::middleware('auth:siswa')->group(function () {
    Route::get('/siswa/dashboard',  [DashboardController::class, 'siswaDashboard'])->name('siswa.dashboard');
    Route::get('/siswa/scan',       [\App\Http\Controllers\QrController::class, 'scanner'])->name('presensi.scan');
    Route::get('/siswa/scan/{token}', [\App\Http\Controllers\QrController::class, 'scan'])->name('siswa.scan');
    Route::get('/siswa/riwayat',    [\App\Http\Controllers\PresensiController::class, 'riwayatSiswa'])->name('siswa.riwayat');
    Route::get('/siswa/izin',       [IzinController::class, 'indexSiswa'])->name('izin.index');
    Route::post('/siswa/izin',      [IzinController::class, 'storeSiswa'])->name('izin.store');
    Route::get('/siswa/profil', function () {
        return view('siswa.profil');
    })->name('siswa.profil');
});
