<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pemanggilan - {{ $siswa->nama }}</title>
    <style>
        @page { size: portrait; margin: 15mm 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000; margin: 0; padding: 0; }
        
        .content { margin-top: 10px; }
        .nomor-info { width: 100%; margin-bottom: 30px; }
        .nomor-info td { vertical-align: top; padding: 1px 0; }
        
        .isi-surat { text-align: justify; }
        .identitas-siswa { margin: 20px 0 20px 40px; border-collapse: collapse; }
        .identitas-siswa td { padding: 4px 10px; vertical-align: top; }
        
        .jadwal-pertemuan { margin: 20px 0 20px 40px; border-collapse: collapse; background: #fdfdfd; }
        .jadwal-pertemuan td { padding: 6px 10px; vertical-align: top; }
        
        .penutup { margin-top: 30px; }
        
        .ttd-section { margin-top: 50px; width: 100%; }
        .ttd-box { float: right; width: 280px; text-align: center; }
        .ttd-name { margin-top: 70px; font-weight: bold; text-decoration: underline; }
        
        .clear { clear: both; }
        
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
        
        .btn-print {
            position: fixed; top: 20px; right: 20px;
            padding: 12px 25px; background: #059669; color: white;
            border: none; border-radius: 8px; font-weight: bold;
            cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            z-index: 100;
        }
    </style>
</head>
<body>
    <button class="no-print btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> CETAK SURAT
    </button>

    <x-kop-surat />

    <div class="content">
        <table class="nomor-info">
            <tr>
                <td width="80">Nomor</td>
                <td width="10">:</td>
                <td width="300">421.5 / {{ rand(100, 999) }} / {{ date('Y') }}</td>
                <td style="text-align: right;">Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td>-</td>
                <td></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td><strong>Pemanggilan Orang Tua / Wali Siswa</strong></td>
                <td></td>
            </tr>
        </table>

        <div class="isi-surat">
            <p>Yth. Bapak / Ibu Orang Tua / Wali Siswa dari:<br>
            <strong>{{ $siswa->nama }}</strong><br>
            Di Tempat</p>

            <p style="margin-top: 25px;"><i>Assalamu'alaikum Warahmatullahi Wabarakatuh,</i></p>
            <p>Dengan hormat, kami mengharap kehadiran Bapak / Ibu Orang Tua / Wali Siswa dari:</p>

            <table class="identitas-siswa">
                <tr>
                    <td width="130">Nama Siswa</td>
                    <td width="10">:</td>
                    <td><strong>{{ $siswa->nama }}</strong></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
            </table>

            <p>Untuk hadir di sekolah guna membicarakan hal-hal yang berkaitan dengan perkembangan pendidikan putra/putri Bapak/Ibu, yang akan dilaksanakan pada:</p>

            <table class="jadwal-pertemuan">
                <tr>
                    <td width="130">Hari, Tanggal</td>
                    <td width="10">:</td>
                    <td><strong>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</strong></td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td>:</td>
                    <td>Pukul {{ \Carbon\Carbon::parse($waktu)->format('H:i') }} WIB s.d Selesai</td>
                </tr>
                <tr>
                    <td>Tempat</td>
                    <td>:</td>
                    <td>Ruang Bimbingan Konseling (BK) SMKN 7 Purworejo</td>
                </tr>
                <tr>
                    <td>Keperluan</td>
                    <td>:</td>
                    <td>{{ $alasan }}</td>
                </tr>
            </table>

            <p class="penutup">Demikian surat undangan ini kami sampaikan. Mengingat pentingnya acara tersebut, kami mohon Bapak / Ibu dapat hadir tepat pada waktunya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
            <p><i>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</i></p>
        </div>

        <div class="ttd-section">
            <div class="ttd-box">
                <p>Guru Bimbingan Konseling,</p>
                <div class="ttd-name">{{ auth()->user()->fullname }}</div>
                <p>NIP. {{ auth()->user()->nip ?? '................................' }}</p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>
