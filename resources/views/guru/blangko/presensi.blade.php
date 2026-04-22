<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blangko Presensi - {{ $kelas }} - {{ $mapel }}</title>
    <style>
        @page { size: portrait; margin: 20mm; }
        body { font-family: Arial, sans-serif; font-size: 11pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; font-size: 14pt; }
        .info-table { width: 100%; margin-bottom: 15px; }
        .info-table td { padding: 2px 5px; vertical-align: top; }
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 6px; }
        table.data-table th { text-align: center; background-color: #f0f0f0; }
        .center { text-align: center; }
        @media print { button.print-btn { display: none; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()" style="padding: 10px; margin-bottom: 20px; cursor:pointer;">Cetak PDF</button>

    <x-kop-surat />

    <table class="info-table">
        <tr>
            <td width="15%">Mata Pelajaran</td><td width="2%">:</td><td width="33%">{{ $mapel }}</td>
            <td width="15%">Kelas</td><td width="2%">:</td><td width="33%">{{ $kelas }}</td>
        </tr>
        <tr>
            <td>Guru Pengampu</td><td>:</td><td>{{ auth()->user()->fullname }}</td>
            <td>Semester</td><td>:</td><td>{{ $semester }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th rowspan="2" width="5%">No</th>
                <th rowspan="2" width="30%">Nama Siswa</th>
                <th colspan="16">Pertemuan Ke / Tanggal</th>
            </tr>
            <tr>
                @for($i = 1; $i <= 16; $i++)
                <th width="4%" style="height: 30px;"></th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $index => $siswa)
            <tr>
                <td class="center">{{ $index + 1 }}</td>
                <td>{{ $siswa->nama }}</td>
                @for($i = 1; $i <= 16; $i++)
                <td></td>
                @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
