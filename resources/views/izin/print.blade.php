<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Ijin Masuk Kelas - {{ $izin->siswa->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            padding: 20px 40px;
        }

        /* Tombol aksi - hilang saat print */
        .no-print {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background: #f4f4f4;
            border-radius: 4px;
        }
        .no-print button {
            padding: 8px 20px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 14px;
        }

        /* Header surat */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 6px;
        }
        .header img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .header-text {
            text-align: center;
            flex: 1;
            padding: 0 10px;
        }
        .header-text p {
            font-size: 11px;
            line-height: 1.4;
        }
        .header-text .nama-sekolah {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.6;
        }

        /* Garis header */
        .garis-tebal {
            border: none;
            border-top: 4px solid #000;
            margin: 0;
        }
        .garis-tipis {
            border: none;
            border-top: 1.5px solid #000;
            margin: 2px 0 0 0;
        }

        /* Isi surat */
        .content {
            margin-top: 25px;
        }
        .judul-surat {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-bottom: 16px;
            letter-spacing: 1px;
        }
        .kalimat-pembuka {
            font-size: 12px;
            margin-bottom: 12px;
        }
        .info-table {
            width: 60%;
            margin-bottom: 30px;
        }
        .info-table td {
            font-size: 12px;
            padding: 3px 0;
            vertical-align: top;
        }
        .info-table .label { width: 100px; }
        .info-table .sep { width: 15px; }

        /* Footer TTD */
        .footer {
            margin-top: 40px;
            float: right;
            width: 220px;
            text-align: center;
            font-size: 12px;
        }
        .footer .ttd-space {
            height: 70px;
        }
        .footer .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Print settings */
        @media print {
            .no-print { display: none !important; }
            body { padding: 10px 20px; }
            @page {
                size: A4 landscape;
                margin: 15mm;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak</button>
        <button onclick="history.back()">← Kembali</button>
    </div>

    {{-- HEADER --}}
    <div class="header">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Lambang_Provinsi_Jawa_Tengah.svg/200px-Lambang_Provinsi_Jawa_Tengah.svg.png"
             alt="Logo Jateng"
             onerror="this.style.display='none'">

        <div class="header-text">
            <p>PEMERINTAH PROVINSI JAWA TENGAH</p>
            <p>DINAS PENDIDIKAN DAN KEBUDAYAAN</p>
            <p class="nama-sekolah">SEKOLAH MENENGAH KEJURUAN NEGERI 7 PURWOREJO</p>
            <p>Jalan Cangkrep - Bagelen Km 7 Desa Kemanukan, Kecamatan Bagelen, Kabupaten Purworejo Kode Pos 54174</p>
            <p>Telepon (0275) 2973748</p>
            <p>Laman: www.smkn7purworejo.sch.id, Pos-el smkn7pwr@ymail.com</p>
        </div>

        <img src="{{ asset('images/logo-smkn7.png') }}"
             alt="Logo SMKN7"
             onerror="this.style.visibility='hidden'">
    </div>

    <hr class="garis-tebal">
    <hr class="garis-tipis">

    {{-- ISI SURAT --}}
    @php
        $titles = [
            'Masuk Telat' => 'Surat Ijin Masuk Kelas',
            'Keluar Sekolah' => 'Surat Ijin Keluar Sekolah',
            'Sakit' => 'Surat Keterangan Sakit',
            'Izin' => 'Surat Keterangan Izin',
        ];
        $title = $titles[$izin->tipe] ?? 'Surat Keterangan Izin';

        $messages = [
            'Masuk Telat' => 'Diberitahukan dengan hormat, bahwa siswa di bawah ini diijinkan untuk mengikuti kegiatan belajar di kelas:',
            'Keluar Sekolah' => 'Diberitahukan dengan hormat, bahwa siswa di bawah ini diijinkan untuk meninggalkan lingkungan sekolah:',
            'Sakit' => 'Diberitahukan dengan hormat, bahwa siswa di bawah ini berhalangan mengikuti kegiatan belajar karena sakit:',
            'Izin' => 'Diberitahukan dengan hormat, bahwa siswa di bawah ini berhalangan mengikuti kegiatan belajar karena ada kepentingan/keperluan:',
        ];
        $message = $messages[$izin->tipe] ?? 'Diberitahukan dengan hormat, bahwa siswa di bawah ini:';
    @endphp

    <div class="content">
        <div class="judul-surat">{{ $title }}</div>

        <p class="kalimat-pembuka">
            {{ $message }}
        </p>

        <table class="info-table">
            <tr>
                <td class="label">Nama</td>
                <td class="sep">:</td>
                <td>{{ $izin->siswa->nama }}</td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="sep">:</td>
                <td>{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alasan</td>
                <td class="sep">:</td>
                <td>{{ $izin->alasan }}</td>
            </tr>
        </table>

        {{-- FOOTER TTD --}}
        <div class="footer">
            <p>Purworejo, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
            <p>Guru Piket,</p>
            <div class="ttd-space"></div>
            <p class="nama-ttd">{{ auth('web')->user()->fullname ?? '.........................' }}</p>
            <p>NIP. {{ auth('web')->user()->nip ?? '-' }}</p>
        </div>
    </div>

</body>
</html>