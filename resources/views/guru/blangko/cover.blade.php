<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cover Administrasi - {{ $kelas }} - {{ $mapel }}</title>
    <style>
        @page { size: portrait; margin: 0; }
        body { 
            font-family: 'Times New Roman', Times, serif; 
            margin: 0; 
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .cover-page {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            box-sizing: border-box;
            border: 10px double #000;
            text-align: center;
            position: relative;
        }
        .header { margin-top: 40px; margin-bottom: 50px; }
        .header h1 { font-size: 24pt; margin: 0; font-weight: bold; }
        .header h2 { font-size: 20pt; margin: 5px 0 0 0; }
        .logo { margin: 60px 0; }
        .logo img { width: 180px; height: auto; }
        .title { margin: 50px 0; }
        .title h1 { font-size: 32pt; margin: 0; text-transform: uppercase; }
        .details { font-size: 16pt; margin: 40px 0; line-height: 1.8; text-align: center; }
        .teacher-info { margin-top: 80px; font-size: 16pt; }
        .teacher-info strong { display: block; font-size: 18pt; margin-top: 10px; text-decoration: underline; }
        @media print { button.print-btn { display: none; } }
    </style>
</head>
<body>
    <div style="position: absolute; top: 20px; left: 20px;">
        <button class="print-btn" onclick="window.print()" style="padding: 10px; cursor:pointer;">Cetak Cover</button>
    </div>

    <div class="cover-page">
        <div class="header">
            <h2>PEMERINTAH PROVINSI JAWA TENGAH</h2>
            <h2>DINAS PENDIDIKAN DAN KEBUDAYAAN</h2>
            <h1>SMK NEGERI 7 PURWOREJO</h1>
        </div>

        <div class="title">
            <h1>ADMINISTRASI GURU</h1>
            <h1>MATA PELAJARAN</h1>
        </div>

        <div class="details">
            <p><strong>Mata Pelajaran:</strong><br>{{ $mapel }}</p>
            <p><strong>Kelas:</strong><br>{{ $kelas }}</p>
            <p><strong>Semester:</strong><br>{{ $semester }}</p>
            <p><strong>Tahun Ajaran:</strong><br>{{ $tahun_ajaran }}</p>
        </div>

        <div class="teacher-info">
            <p>Disusun Oleh:</p>
            <strong>{{ auth()->user()->fullname }}</strong>
            <p>NIP. {{ auth()->user()->nip ?? '-' }}</p>
        </div>
    </div>
</body>
</html>
