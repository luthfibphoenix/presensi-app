<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Surat Izin - {{ $izin->siswa->nama }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            color: #000;
            page-break-after: avoid;
        }
        .container {
            width: 210mm;
            margin: 0 auto;
            position: relative;
        }
        
        /* Format 1: 1/3 A4 */
        .surat-box-sepertiga {
            width: 100%;
            height: 98.5mm; /* Reduced slightly from 99mm to be safe */
            padding: 5mm 12mm;
            box-sizing: border-box;
            position: relative;
            border-bottom: 1px dashed #999;
            page-break-after: avoid;
        }
        .surat-box-sepertiga:last-child {
            border-bottom: none;
        }

        /* Format 2: Full A4 */
        .surat-box-full {
            width: 100%;
            height: 296mm;
            padding: 15mm 20mm;
            box-sizing: border-box;
            page-break-after: avoid;
        }
        
        /* KOP SURAT */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1.5px solid #000;
            margin-bottom: 5px;
        }
        .kop-table td {
            vertical-align: middle;
        }
        .logo-box {
            width: 50px;
        }
        .logo-img {
            width: 45px;
            height: auto;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text h1 {
            font-size: 11pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .kop-text h2 {
            font-size: 9pt;
            margin: 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .kop-text p {
            font-size: 7pt;
            margin: 1px 0 0 0;
            font-style: italic;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 8px 0;
            text-transform: uppercase;
        }
        .judul-sepertiga { font-size: 10pt; }
        .judul-full { font-size: 16pt; margin: 30px 0; }

        .isi-surat {
            line-height: 1.3;
        }
        .isi-sepertiga { font-size: 9pt; }
        .isi-full { font-size: 12pt; }
        
        .data-table {
            width: 100%;
            margin: 8px 0;
        }
        .data-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .data-sepertiga { font-size: 9pt; }
        .data-full { font-size: 12pt; margin: 30px 0; }
        
        .label {
            width: 120px;
        }
        
        .footer-table {
            width: 100%;
            margin-top: 10px;
        }
        .footer-sepertiga { font-size: 9pt; }
        .footer-full { font-size: 12pt; margin-top: 50px; }
        
        .ttd-box {
            text-align: center;
            width: 45%;
        }
        .ttd-space {
            height: 35px;
        }
        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            .no-print { display: none !important; }
        }
        .no-print {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            margin: 0 5px;
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn" onclick="window.print()">🖨️ Cetak Sekarang</button>
        <button class="btn" onclick="history.back()" style="background: #6c757d;">Kembali</button>
    </div>

    @php
        $logoKiri = '';
        $logoKanan = '';
        try {
            $pathKiri = public_path('images/logo-kiri.png');
            $pathKanan = public_path('images/logo-kanan.png');
            if (file_exists($pathKiri)) {
                $logoKiri = 'data:image/png;base64,' . base64_encode(file_get_contents($pathKiri));
            }
            if (file_exists($pathKanan)) {
                $logoKanan = 'data:image/png;base64,' . base64_encode(file_get_contents($pathKanan));
            }
        } catch (\Exception $e) {}

        $tipe = $izin->tipe;
        $isFullPage = in_array($tipe, ['Sakit', 'Izin']);
        
        $judul = "SURAT KETERANGAN";
        if ($tipe == 'Masuk Telat') $judul = "SURAT IZIN MASUK";
        elseif ($tipe == 'Keluar Sekolah') $judul = "SURAT IZIN KELUAR";
        elseif ($isFullPage) $judul = "SURAT IZIN TIDAK MASUK SEKOLAH";
        
        $jam = \Carbon\Carbon::now()->format('H:i');
    @endphp

    <div class="container">
        @if(!$isFullPage)
            {{-- FORMAT 1: SEPERTIGA A4 (3 Copies) --}}
            @for($i = 0; $i < 3; $i++)
            <div class="surat-box-sepertiga">
                <table class="kop-table">
                    <tr>
                        <td class="logo-box">
                            @if($logoKiri) <img src="{{ $logoKiri }}" class="logo-img"> @endif
                        </td>
                        <td class="kop-text">
                            <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
                            <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
                            <h1>SMK NEGERI 7 PURWOREJO</h1>
                            <p>Jl. Cangkrep-Bagelen Km 7 Desa Kemanukan, Purworejo 54174 Telp: (0275) 2973748</p>
                        </td>
                        <td class="logo-box" style="text-align: right;">
                            @if($logoKanan) <img src="{{ $logoKanan }}" class="logo-img"> @endif
                        </td>
                    </tr>
                </table>

                <div class="judul-surat judul-sepertiga">{{ $judul }}</div>

                <div class="isi-surat isi-sepertiga">
                    <p>Memberikan izin kepada siswa di bawah ini:</p>
                    <table class="data-table data-sepertiga">
                        <tr>
                            <td class="label">Nama Siswa</td>
                            <td width="10">:</td>
                            <td><strong>{{ $izin->siswa->nama }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Kelas</td>
                            <td>:</td>
                            <td>{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Hari / Tanggal</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Jam / Pukul</td>
                            <td>:</td>
                            <td>{{ $jam }} WIB</td>
                        </tr>
                        <tr>
                            <td class="label">Alasan / Keperluan</td>
                            <td>:</td>
                            <td>{{ $izin->tipe }}</td>
                        </tr>
                    </table>
                </div>

                <table class="footer-table footer-sepertiga">
                    <tr>
                        <td width="55%"></td>
                        <td class="ttd-box">
                            <p>Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <p>Guru Piket,</p>
                            <div class="ttd-space"></div>
                            <p class="ttd-name">{{ auth('web')->user()->fullname }}</p>
                            <p>NIP. {{ auth('web')->user()->nip ?? '-' }}</p>
                        </td>
                    </tr>
                </table>
            </div>
            @endfor
        @else
            {{-- FORMAT 2: FULL A4 (1 Copy) --}}
            <div class="surat-box-full">
                <table class="kop-table" style="border-bottom: 3px solid #000; padding-bottom: 5px;">
                    <tr>
                        <td class="logo-box" style="width: 80px;">
                            @if($logoKiri) <img src="{{ $logoKiri }}" style="width: 75px;"> @endif
                        </td>
                        <td class="kop-text">
                            <h2 style="font-size: 14pt;">PEMERINTAH PROVINSI JAWA TENGAH</h2>
                            <h2 style="font-size: 14pt;">DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
                            <h1 style="font-size: 18pt;">SMK NEGERI 7 PURWOREJO</h1>
                            <p style="font-size: 10pt;">Jl. Cangkrep-Bagelen Km 7 Desa Kemanukan, Purworejo 54174 Telp: (0275) 2973748</p>
                            <p style="font-size: 9pt;">Laman: smkn7purworejo.sch.id | Email: smkn7purworejo@gmail.com</p>
                        </td>
                        <td class="logo-box" style="width: 80px; text-align: right;">
                            @if($logoKanan) <img src="{{ $logoKanan }}" style="width: 75px;"> @endif
                        </td>
                    </tr>
                </table>

                <div class="judul-surat judul-full">{{ $judul }}</div>

                <div class="isi-surat isi-full">
                    <p>Yang bertanda tangan di bawah ini, Guru Piket SMK Negeri 7 Purworejo memberikan keterangan bahwa siswa:</p>
                    
                    <table class="data-table data-full">
                        <tr>
                            <td class="label">Nama Lengkap</td>
                            <td width="20">:</td>
                            <td><strong>{{ $izin->siswa->nama }}</strong></td>
                        </tr>
                        <tr>
                            <td class="label">Nomor Induk Siswa</td>
                            <td>:</td>
                            <td>{{ $izin->siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Kelas / Jurusan</td>
                            <td>:</td>
                            <td>{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Tanggal Izin</td>
                            <td>:</td>
                            <td>{{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Alasan / Keperluan</td>
                            <td>:</td>
                            <td>{{ $izin->tipe }}</td>
                        </tr>
                        <tr>
                            <td class="label">Keterangan Tambahan</td>
                            <td>:</td>
                            <td>{{ $izin->alasan }}</td>
                        </tr>
                    </table>

                    <p style="text-indent: 40px; margin-top: 30px;">
                        Berdasarkan laporan yang diterima, siswa yang bersangkutan dinyatakan tidak dapat mengikuti kegiatan belajar mengajar (KBM) pada tanggal tersebut di atas. Demikian surat keterangan izin ini dibuat agar dapat dipergunakan sebagaimana mestinya dan menjadi maklum adanya.
                    </p>
                </div>

                <table class="footer-table footer-full">
                    <tr>
                        <td width="50%"></td>
                        <td class="ttd-box">
                            <p>Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                            <p>Guru Piket,</p>
                            <div class="ttd-space" style="height: 80px;"></div>
                            <p class="ttd-name">{{ auth('web')->user()->fullname }}</p>
                            <p>NIP. {{ auth('web')->user()->nip ?? '................................' }}</p>
                        </td>
                    </tr>
                </table>
            </div>
        @endif
    </div>

</body>
</html>