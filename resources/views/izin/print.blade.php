<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Surat Izin - {{ $izin->siswa->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; color: #000; background: #fff; }
        
        .no-print { text-align: center; padding: 15px; background: #f4f4f4; border-bottom: 1px solid #ddd; }
        .no-print button { padding: 8px 20px; cursor: pointer; border-radius: 6px; border: 1px solid #ccc; font-weight: bold; }

        .page-wrapper { width: 210mm; margin: 0 auto; }
        .surat-izin-copy { height: 99mm; padding: 8mm 15mm; overflow: hidden; position: relative; }
        .divider-dashed { border: none; border-top: 1px dashed #000; width: 100%; margin: 0; }

        .header { display: flex; align-items: center; margin-bottom: 8px; }
        .header img { width: 45px; height: 45px; }
        .header-text { flex: 1; text-align: center; }
        .header-text h2 { font-size: 11pt; text-transform: uppercase; margin: 0; font-weight: bold; }
        .header-text p { font-size: 7pt; margin: 0; }

        .judul-surat { text-align: center; font-size: 10pt; font-weight: bold; text-decoration: underline; margin-bottom: 8px; text-transform: uppercase; }
        .kalimat { font-size: 9pt; margin-bottom: 5px; }
        
        .info-table { width: 100%; font-size: 9pt; margin-bottom: 10px; }
        .info-table td { padding: 1px 0; }
        .info-table .label { width: 70px; }
        
        .footer { float: right; width: 180px; text-align: center; font-size: 9pt; }
        .ttd-space { height: 35px; }
        .nama-ttd { font-weight: bold; text-decoration: underline; }

        @media print {
            .no-print { display: none !important; }
            @page { size: A4 portrait; margin: 0; }
            .page-wrapper { width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print">
        <button onclick="window.print()">🖨️ Cetak (3 Salinan per Lembar)</button>
        <button onclick="history.back()" style="margin-left: 10px;">← Kembali</button>
    </div>

    <div class="page-wrapper">
        @for($i = 0; $i < 3; $i++)
        <div class="surat-izin-copy">
            {{-- KOP --}}
            <div class="header">
                <img src="https://ui-avatars.com/api/?name=SMK&size=128&background=000&color=fff" alt="Logo">
                <div class="header-text">
                    <h2>SMK NEGERI 7 PURWOREJO</h2>
                    <p>Jl. Cangkrep-Bagelen Km 7 Desa Kemanukan, Purworejo</p>
                    <p>Telp: (0275) 2973748 | Email: smkn7purworejo@gmail.com</p>
                </div>
            </div>
            <div style="border-bottom: 1.5px solid #000; margin-bottom: 8px;"></div>

            @php
                $titles = [
                    'Masuk Telat' => 'Surat Ijin Masuk Kelas',
                    'Keluar Sekolah' => 'Surat Ijin Keluar Sekolah',
                    'Sakit' => 'Surat Keterangan Sakit',
                    'Izin' => 'Surat Keterangan Izin',
                ];
                $title = $titles[$izin->tipe] ?? 'Surat Keterangan Izin';

                $messages = [
                    'Masuk Telat' => 'Diberikan ijin kepada siswa di bawah ini untuk mengikuti KBM karena terlambat:',
                    'Keluar Sekolah' => 'Diberikan ijin kepada siswa di bawah ini untuk meninggalkan sekolah karena:',
                    'Sakit' => 'Siswa di bawah ini berhalangan mengikuti KBM karena sakit:',
                    'Izin' => 'Siswa di bawah ini berhalangan mengikuti KBM karena kepentingan keluarga:',
                ];
                $message = $messages[$izin->tipe] ?? 'Diberikan ijin kepada siswa:';
            @endphp

            <div class="judul-surat">{{ $title }}</div>
            <p class="kalimat">{{ $message }}</p>

            <table class="info-table">
                <tr>
                    <td class="label">Nama</td>
                    <td width="10">:</td>
                    <td><strong>{{ $izin->siswa->nama }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Kelas</td>
                    <td>:</td>
                    <td>{{ $izin->siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Alasan</td>
                    <td>:</td>
                    <td>{{ $izin->alasan }}</td>
                </tr>
            </table>

            <div class="footer">
                <p>Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Petugas Piket,</p>
                <div class="ttd-space"></div>
                <p class="nama-ttd">{{ $izin->petugas_piket ?? auth('web')->user()->fullname }}</p>
                <p>NIP. {{ $izin->approvedBy->nip ?? auth('web')->user()->nip ?? '-' }}</p>
            </div>
        </div>
        @if($i < 2)
            <div class="divider-dashed"></div>
        @endif
        @endfor
    </div>

</body>
</html>