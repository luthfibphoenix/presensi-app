<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perjalanan Dinas - {{ $guru->fullname }}</title>
    <style>
        @page { size: portrait; margin: 25mm 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 25px; }
        .kop-surat h1 { margin: 0; font-size: 18pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { margin: 5px 0 0 0; font-size: 16pt; font-weight: bold; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 11pt; }
        .judul-surat { text-align: center; margin-bottom: 30px; }
        .judul-surat h3 { margin: 0; text-decoration: underline; text-transform: uppercase; font-size: 14pt; }
        .judul-surat p { margin: 0; }
        .content { text-align: justify; }
        .tabel-info { margin: 15px 0 15px 40px; width: 85%; }
        .tabel-info td { padding: 5px 10px; vertical-align: top; }
        .ttd-container { display: flex; justify-content: flex-end; margin-top: 60px; }
        .ttd { text-align: center; }
        .ttd-name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        @media print { button.print-btn { display: none; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()" style="padding: 10px; margin-bottom: 20px; cursor:pointer;">Cetak Surat Tugas</button>

    <div class="kop-surat">
        <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h1>SMK NEGERI 7 PURWOREJO</h1>
        <p>Jalan Cangkrep - Bagelen Km 7 Desa Kemanukan, Kecamatan Bagelen, Kabupaten Purworejo Kode Pos 54174<br>
        Telepon: (0275) 2973748</p>
    </div>

    <div class="judul-surat">
        <h3>SURAT TUGAS</h3>
        <p>Nomor: ....../....../2026</p>
    </div>

    <div class="content">
        <p>Kepala SMK Negeri 7 Purworejo dengan ini menugaskan kepada:</p>

        <table class="tabel-info">
            <tr><td width="30">1.</td><td width="150">Nama</td><td width="10">:</td><td><strong>{{ $guru->fullname }}</strong></td></tr>
            <tr><td>2.</td><td>NIP</td><td>:</td><td>{{ $guru->nip ?? '-' }}</td></tr>
            <tr><td>3.</td><td>Pangkat / Golongan</td><td>:</td><td>{{ $guru->pangkat ?? '-' }}</td></tr>
            <tr><td>4.</td><td>Jabatan</td><td>:</td><td>{{ $guru->jabatan ?? explode(',', $guru->position)[0] ?? '-' }}</td></tr>
        </table>

        <p>Untuk melaksanakan tugas perjalanan dinas dalam rangka:</p>
        <p style="margin-left: 40px; font-weight: bold; font-style: italic;">"{{ $keperluan }}"</p>

        <p>Yang dilaksanakan pada:</p>

        <table class="tabel-info">
            <tr><td width="120">Tanggal</td><td width="10">:</td><td>{{ \Carbon\Carbon::parse($tanggal_mulai)->translatedFormat('d F Y') }} @if($tanggal_mulai != $tanggal_selesai) s.d {{ \Carbon\Carbon::parse($tanggal_selesai)->translatedFormat('d F Y') }} @endif</td></tr>
            <tr><td>Tempat Tujuan</td><td>:</td><td><strong>{{ $tujuan }}</strong></td></tr>
        </table>

        <p>Demikian surat tugas ini dibuat untuk dapat dilaksanakan dengan penuh tanggung jawab, dan setelah selesai pelaksanaan tugas harap melaporkan hasilnya kepada Kepala Sekolah.</p>
    </div>

    <div class="ttd-container">
        <div class="ttd">
            <p>Purworejo, {{ date('d F Y') }}<br>Kepala Sekolah</p>
            <div class="ttd-name">KIMIN, S.Pd., M.Pd.</div>
            <div>NIP. 19700412 200501 1 005</div>
        </div>
    </div>
</body>
</html>
