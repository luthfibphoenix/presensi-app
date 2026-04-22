<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas - {{ $guru->fullname }}</title>
    <style>
        @page { size: portrait; margin: 20mm 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; }
        .kop-surat h2 { margin: 0; font-size: 14pt; font-weight: normal; }
        .kop-surat h1 { margin: 5px 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat p { margin: 0; font-size: 10pt; font-style: italic; }
        
        .judul-surat { text-align: center; margin-bottom: 30px; }
        .judul-surat h3 { margin: 0; text-decoration: underline; text-transform: uppercase; font-size: 14pt; }
        .judul-surat p { margin: 0; font-weight: bold; }
        
        .content { text-align: justify; }
        .tabel-info { margin: 15px 0 15px 40px; width: 90%; border-collapse: collapse; }
        .tabel-info td { padding: 4px 8px; vertical-align: top; }
        
        .footer-container { margin-top: 50px; width: 100%; }
        .ttd-box { float: right; width: 300px; text-align: center; }
        .ttd-name { margin-top: 70px; font-weight: bold; text-decoration: underline; }
        
        .clear { clear: both; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="background: #f4f4f4; padding: 15px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ddd;">
        <button onclick="window.print()" style="padding: 10px 25px; background: #2563eb; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            <i class="fas fa-print"></i> CETAK SEKARANG
        </button>
        <p style="font-size: 10px; color: #666; margin-top: 10px;">*Gunakan browser Chrome/Edge untuk hasil cetak terbaik.</p>
    </div>

    <div class="kop-surat">
        <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h1>SMK NEGERI 7 PURWOREJO</h1>
        <p>Jalan Cangkrep - Bagelen Km 7 Desa Kemanukan, Kec. Bagelen, Kab. Purworejo 54174</p>
        <p>Laman: smkn7purworejo.sch.id | Email: smkn7purworejo@gmail.com</p>
    </div>

    <div class="judul-surat">
        <h3>SURAT TUGAS</h3>
        <p>Nomor: 800 / {{ rand(100, 999) }} / {{ date('Y') }}</p>
    </div>

    <div class="content">
        <p>Kepala SMK Negeri 7 Purworejo dengan ini memberikan tugas kepada:</p>

        <table class="tabel-info">
            <tr>
                <td width="30">1.</td>
                <td width="160">Nama</td>
                <td width="10">:</td>
                <td><strong>{{ $guru->fullname }}</strong></td>
            </tr>
            <tr>
                <td>2.</td>
                <td>NIP / NIY</td>
                <td>:</td>
                <td>{{ $guru->nip ?? '-' }}</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $guru->position ?? 'Guru / Staff' }}</td>
            </tr>
        </table>

        <p>Untuk melaksanakan tugas perjalanan dinas dengan rincian sebagai berikut:</p>

        <table class="tabel-info">
            <tr>
                <td width="170">Keperluan / Acara</td>
                <td width="10">:</td>
                <td><strong>{{ $keperluan }}</strong></td>
            </tr>
            <tr>
                <td>Lokasi Tujuan</td>
                <td>:</td>
                <td>
                    {{ $tujuan }}<br>
                    <span style="font-size: 11pt;">
                        {{ $kecamatan ? 'Kec. ' . ucwords(strtolower($kecamatan)) . ',' : '' }}
                        {{ $kabupaten ? ucwords(strtolower($kabupaten)) . ',' : '' }}
                        {{ $provinsi ? 'Prov. ' . ucwords(strtolower($provinsi)) : '' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Waktu Pelaksanaan</td>
                <td>:</td>
                <td>
                    {{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }}
                    @if($tanggal_mulai != $tanggal_selesai)
                        s.d {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }}
                    @endif
                </td>
            </tr>
        </table>

        <p>Demikian surat tugas ini dibuat untuk dapat dilaksanakan dengan penuh tanggung jawab, dan melaporkan hasilnya setelah selesai pelaksanaan tugas.</p>
    </div>

    <div class="footer-container">
        <div class="ttd-box">
            <p>Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Sekolah,</p>
            <div class="ttd-name">{{ $kepala->fullname ?? '................................' }}</div>
            <p>NIP. {{ $kepala->nip ?? '................................' }}</p>
        </div>
        <div class="clear"></div>
    </div>
</body>
</html>
