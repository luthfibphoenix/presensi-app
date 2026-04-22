<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas - {{ $guru->fullname }}</title>
    <style>
        @page { size: portrait; margin: 15mm 20mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; margin: 0; padding: 0; }
        
        .content { margin-top: 10px; }
        .judul-surat { text-align: center; margin-bottom: 30px; }
        .judul-surat h3 { margin: 0; text-decoration: underline; text-transform: uppercase; font-size: 14pt; }
        .judul-surat p { margin: 0; font-weight: bold; }
        
        .isi-surat { text-align: justify; }
        .tabel-identitas { margin: 15px 0 15px 40px; border-collapse: collapse; }
        .tabel-identitas td { padding: 4px 8px; vertical-align: top; }
        
        .tabel-tugas { margin: 20px 0 20px 0; width: 100%; border-collapse: collapse; }
        .tabel-tugas td { padding: 6px 0; vertical-align: top; }
        
        .ttd-container { margin-top: 50px; width: 100%; }
        .ttd-box { float: right; width: 300px; text-align: center; }
        .ttd-name { margin-top: 70px; font-weight: bold; text-decoration: underline; }
        
        .clear { clear: both; }
        
        @media print {
            .no-print { display: none; }
            body { -webkit-print-color-adjust: exact; }
        }
        
        .btn-print {
            position: fixed; top: 20px; right: 20px;
            padding: 12px 25px; background: #2563eb; color: white;
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
        <div class="judul-surat">
            <h3>SURAT TUGAS</h3>
            <p>Nomor: 800 / {{ rand(100, 999) }} / {{ date('Y') }}</p>
        </div>

        <div class="isi-surat">
            <p>Kepala Sekolah Menengah Kejuruan Negeri 7 Purworejo dengan ini memberikan tugas kepada:</p>

            <table class="tabel-identitas">
                <tr>
                    <td width="30">1.</td>
                    <td width="160">Nama</td>
                    <td width="10">:</td>
                    <td><strong>{{ $guru->fullname }}</strong></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $guru->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Pangkat / Golongan</td>
                    <td>:</td>
                    <td>{{ $guru->pangkat ?? '-' }}</td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $guru->position ?? 'Guru / Staff' }}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">Untuk melaksanakan tugas perjalanan dinas dengan rincian sebagai berikut:</p>

            <table class="tabel-tugas">
                <tr>
                    <td width="180">Dasar / Keperluan</td>
                    <td width="15">:</td>
                    <td><strong>{{ $keperluan }}</strong></td>
                </tr>
                <tr>
                    <td>Tempat Tujuan</td>
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

            <p style="margin-top: 20px;">Demikian surat tugas ini dibuat untuk dapat dilaksanakan dengan penuh tanggung jawab, dan melaporkan hasilnya setelah selesai pelaksanaan tugas.</p>
        </div>

        <div class="ttd-container">
            <div class="ttd-box">
                <p>Purworejo, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p>Kepala Sekolah,</p>
                <div class="ttd-name">{{ $kepala->fullname ?? '................................' }}</div>
                <p>NIP. {{ $kepala->nip ?? '................................' }}</p>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</body>
</html>
