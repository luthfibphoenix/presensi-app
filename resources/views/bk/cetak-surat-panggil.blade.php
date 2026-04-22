<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pemanggilan - {{ $siswa->nama }}</title>
    <style>
        @page { size: portrait; margin: 25mm 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .kop-surat { text-align: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 25px; }
        .kop-surat h1 { margin: 0; font-size: 18pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat h2 { margin: 5px 0 0 0; font-size: 16pt; font-weight: bold; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 11pt; }
        .nomor-surat { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .content { text-align: justify; }
        .tabel-info { margin: 15px 0 15px 40px; }
        .tabel-info td { padding: 3px 10px; vertical-align: top; }
        .ttd-container { display: flex; justify-content: flex-end; margin-top: 50px; }
        .ttd { text-align: center; }
        .ttd-name { margin-top: 80px; font-weight: bold; text-decoration: underline; }
        @media print { button.print-btn { display: none; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()" style="padding: 10px; margin-bottom: 20px; cursor:pointer;">Cetak Surat</button>

    <div class="kop-surat">
        <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
        <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
        <h1>SMK NEGERI 7 PURWOREJO</h1>
        <p>Jalan Cangkrep - Bagelen Km 7 Desa Kemanukan, Kecamatan Bagelen, Kabupaten Purworejo Kode Pos 54174<br>
        Telepon: (0275) 2973748</p>
    </div>

    <div class="nomor-surat">
        <div>
            <table style="width: 100%">
                <tr><td width="70">Nomor</td><td width="10">:</td><td>....../....../2026</td></tr>
                <tr><td>Lampiran</td><td>:</td><td>-</td></tr>
                <tr><td>Hal</td><td>:</td><td><strong>Pemanggilan Orang Tua / Wali Siswa</strong></td></tr>
            </table>
        </div>
        <div style="text-align: right;">
            Purworejo, {{ date('d F Y') }}
        </div>
    </div>

    <div class="content">
        <p>Yth. Bapak / Ibu Orang Tua / Wali Siswa dari:<br>
        Di Tempat</p>

        <p>Dengan hormat,</p>
        <p>Mengharap kehadiran Bapak / Ibu Orang Tua / Wali Siswa dari anak:</p>

        <table class="tabel-info">
            <tr><td width="120">Nama Siswa</td><td width="10">:</td><td><strong>{{ $siswa->nama }}</strong></td></tr>
            <tr><td>Kelas</td><td>:</td><td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td></tr>
        </table>

        <p>Pada pertemuan yang akan kami selenggarakan pada:</p>

        <table class="tabel-info">
            <tr><td width="120">Hari, Tanggal</td><td width="10">:</td><td><strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong></td></tr>
            <tr><td>Waktu</td><td>:</td><td>{{ \Carbon\Carbon::parse($waktu)->format('H:i') }} WIB s.d Selesai</td></tr>
            <tr><td>Tempat</td><td>:</td><td>Ruang Bimbingan Konseling (BK) SMKN 7 Purworejo</td></tr>
            <tr><td>Keperluan</td><td>:</td><td>{{ $alasan }}</td></tr>
        </table>

        <p>Mengingat pentingnya acara tersebut, kami mohon Bapak / Ibu dapat hadir tepat pada waktunya. Demikian undangan ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.</p>
    </div>

    <div class="ttd-container">
        <div class="ttd">
            <p>Mengetahui,<br>Guru Bimbingan Konseling</p>
            <div class="ttd-name">{{ auth()->user()->fullname }}</div>
            <div>NIP. {{ auth()->user()->nip ?? '-' }}</div>
        </div>
    </div>
</body>
</html>
