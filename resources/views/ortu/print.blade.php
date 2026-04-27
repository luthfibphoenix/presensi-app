<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Ortu - {{ $izin->siswa->nama }}</title>
    <style>
        @page { size: A4 portrait; margin: 0; }
        body { font-family: 'Times New Roman', Times, serif; margin: 0; padding: 20mm; color: #000; }
        .kop-table { width: 100%; border-collapse: collapse; border-bottom: 3px solid #000; margin-bottom: 20px; }
        .kop-text { text-align: center; }
        .kop-text h1 { font-size: 18pt; margin: 0; text-transform: uppercase; }
        .kop-text h2 { font-size: 14pt; margin: 0; text-transform: uppercase; }
        .kop-text p { font-size: 10pt; margin: 2px 0; }
        
        .judul { text-align: center; font-weight: bold; text-decoration: underline; font-size: 14pt; margin: 30px 0; text-transform: uppercase; }
        .isi { font-size: 12pt; line-height: 1.6; text-align: justify; }
        .data-table { width: 100%; margin: 20px 0; border-collapse: collapse; }
        .data-table td { padding: 5px; vertical-align: top; }
        .label { width: 180px; }

        .footer-table { width: 100%; margin-top: 50px; }
        .ttd-box { text-align: center; width: 40%; }
        .ttd-space { height: 70px; }
        .ttd-name { font-weight: bold; text-decoration: underline; }

        @media print { .no-print { display: none; } }
        .no-print { background: #f8f9fa; padding: 15px; text-align: center; border-bottom: 1px solid #dee2e6; margin: -20mm -20mm 20mm -20mm; }
        .btn { padding: 10px 20px; background: #0d9488; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn" onclick="window.print()">🖨️ Cetak Surat Pernyataan</button>
        <button class="btn" onclick="history.back()" style="background: #64748b; margin-left: 10px;">Kembali</button>
    </div>

    @php
        $logoKiri = '';
        $logoKanan = '';
        try {
            $pathKiri = public_path('images/logo-kiri.png');
            $pathKanan = public_path('images/logo-kanan.png');
            if (file_exists($pathKiri)) $logoKiri = 'data:image/png;base64,' . base64_encode(file_get_contents($pathKiri));
            if (file_exists($pathKanan)) $logoKanan = 'data:image/png;base64,' . base64_encode(file_get_contents($pathKanan));
        } catch (\Exception $e) {}
    @endphp

    <table class="kop-table">
        <tr>
            <td width="80">@if($logoKiri) <img src="{{ $logoKiri }}" width="75"> @endif</td>
            <td class="kop-text">
                <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
                <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
                <h1>SMK NEGERI 7 PURWOREJO</h1>
                <p>Jl. Cangkrep-Bagelen Km 7 Desa Kemanukan, Purworejo 54174 Telp: (0275) 2973748</p>
                <p>Laman: smkn7purworejo.sch.id | Email: smkn7purworejo@gmail.com</p>
            </td>
            <td width="80">@if($logoKanan) <img src="{{ $logoKanan }}" width="75"> @endif</td>
        </tr>
    </table>

    <div class="judul">SURAT PERNYATAAN IZIN ORANG TUA</div>

    <div class="isi">
        <p>Saya yang bertanda tangan di bawah ini, adalah orang tua/wali dari siswa:</p>
        
        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap Siswa</td>
                <td width="10">:</td>
                <td><strong>{{ $izin->siswa->nama }}</strong></td>
            </tr>
            <tr>
                <td class="label">Nomor Induk (NIS)</td>
                <td>:</td>
                <td>{{ $izin->siswa->nis ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kelas / Jurusan</td>
                <td>:</td>
                <td>{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
        </table>

        <p>Dengan ini memberitahukan dan memohon izin bahwa anak kami tersebut di atas **tidak dapat mengikuti kegiatan belajar mengajar (KBM)** di sekolah pada:</p>
        
        <table class="data-table">
            <tr>
                <td class="label">Hari / Tanggal</td>
                <td width="10">:</td>
                <td>{{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Alasan / Keperluan</td>
                <td>:</td>
                <td>{{ $izin->tipe }} ({{ str_replace(' (Input oleh Ortu)', '', $izin->alasan) }})</td>
            </tr>
        </table>

        <p style="text-indent: 40px;">
            Demikian surat pernyataan izin ini kami sampaikan dengan sebenarnya. Kami selaku orang tua bertanggung jawab penuh atas kebenaran informasi ini. Atas perhatian dan izin yang diberikan, kami ucapkan terima kasih.
        </p>
    </div>

    <table class="footer-table">
        <tr>
            <td class="ttd-box">
                <p>Mengetahui,</p>
                <p>Guru Piket Sekolah</p>
                <div class="ttd-space"></div>
                <p class="ttd-name">{{ $izin->petugas_piket ?? '................................' }}</p>
                <p>NIP. {{ $izin->approvedBy->nip ?? '................................' }}</p>
            </td>
            <td></td>
            <td class="ttd-box">
                <p>Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Hormat Saya, Orang Tua Siswa</p>
                <div class="ttd-space"></div>
                <p class="ttd-name">{{ $ortu->nama }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
