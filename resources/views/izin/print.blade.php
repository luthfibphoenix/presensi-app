<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Izin - {{ $izin->siswa->nama }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 40px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header p {
            margin: 0;
            font-size: 12px;
            font-style: italic;
        }
        .content {
            margin-top: 30px;
        }
        .title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .label {
            width: 150px;
        }
        .separator {
            width: 20px;
        }
        .footer {
            margin-top: 50px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .footer .signature-space {
            height: 80px;
        }
        .no-print {
            display: block;
            margin-bottom: 20px;
            background: #f4f4f4;
            padding: 10px;
            text-align: center;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print">
        <button onclick="window.print()" style="padding: 8px 16px; cursor: pointer;">Cetak Sekarang</button>
        <p style="font-size: 12px; color: #666;">Jika jendela cetak tidak muncul, klik tombol di atas.</p>
    </div>

    <div class="header">
        <h1>SMK NEGERI 7 KABUPATEN TANGERANG</h1>
        <h2>SISTEM INFORMASI PRESENSI SISWA</h2>
        <p>Jl. Raya Legok - Karawaci, Tangerang, Banten</p>
    </div>

    <div class="content">
        <div class="title">
            SURAT KETERANGAN {{ strtoupper($izin->tipe) }}
        </div>

        <p>Diberikan kepada siswa berikut ini:</p>

        <table class="info-table">
            <tr>
                <td class="label">Nama Siswa</td>
                <td class="separator">:</td>
                <td><strong>{{ $izin->siswa->nama }}</strong></td>
            </tr>
            <tr>
                <td class="label">Kelas</td>
                <td class="separator">:</td>
                <td>{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="separator">:</td>
                <td>{{ \Carbon\Carbon::parse($izin->tanggal)->isoFormat('dddd, D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td class="label">Keterangan</td>
                <td class="separator">:</td>
                <td>{{ $izin->tipe }}</td>
            </tr>
            <tr>
                <td class="label">Alasan</td>
                <td class="separator">:</td>
                <td>{{ $izin->alasan }}</td>
            </tr>
        </table>

        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="footer">
            <p>Purworejo, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
            <p>Guru Piket,</p>
            <div class="signature-space"></div>
            <p>( <strong>{{ $izin->petugas_piket ?? '..........................' }}</strong> )</p>
            <p>Petugas Piket SMKN 7</p>
        </div>
    </div>
</body>
</html>
