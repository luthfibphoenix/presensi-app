<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jurnal Mengajar - {{ auth()->user()->fullname }}</title>
    <style>
        @page { size: landscape; margin: 15mm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #000; padding-bottom: 10px; }
        .header h1, .header h2, .header h3 { margin: 0; padding: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .footer { margin-top: 50px; text-align: right; }
        @media print {
            body { font-size: 11pt; }
            button.print-btn { display: none; }
        }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()" style="padding: 10px 20px; font-size: 14px; margin-bottom: 20px; cursor:pointer;">Cetak PDF / Print</button>
    
    <x-kop-surat />

    <h3 style="text-align: center; margin-bottom: 5px;">JURNAL MENGAJAR GURU</h3>
    <p style="text-align: center; margin-top: 0;">Nama Guru: <strong>{{ auth()->user()->fullname }}</strong></p>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Mata Pelajaran</th>
                <th width="10%">Kelas</th>
                <th width="8%">Jam Ke-</th>
                <th width="30%">Ringkasan Materi</th>
                <th width="24%">Presensi Siswa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnals as $index => $jurnal)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($jurnal->tanggal)->format('d-m-Y') }}</td>
                <td>{{ $jurnal->mata_pelajaran }}</td>
                <td class="text-center">{{ $jurnal->kelas }}</td>
                <td class="text-center">{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</td>
                <td>{{ $jurnal->ringkasan_materi }}</td>
                <td>
                    @php
                        $hadir = $jurnal->presensi->where('status', 'Hadir')->count();
                        $sakit = $jurnal->presensi->where('status', 'Sakit')->count();
                        $izin = $jurnal->presensi->where('status', 'Izin')->count();
                        $alfa = $jurnal->presensi->where('status', 'Alfa')->count();
                        
                        $tidakHadir = $jurnal->presensi->whereIn('status', ['Sakit', 'Izin', 'Alfa']);
                    @endphp
                    H: {{ $hadir }}, S: {{ $sakit }}, I: {{ $izin }}, A: {{ $alfa }}<br>
                    @if($tidakHadir->count() > 0)
                        <span style="font-size: 10pt;">Keterangan:</span><br>
                        <ul style="margin: 0; padding-left: 15px; font-size: 10pt;">
                            @foreach($tidakHadir as $p)
                                <li>{{ $p->nama_siswa }} ({{ $p->status }})</li>
                            @endforeach
                        </ul>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data jurnal mengajar kosong.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Purworejo, {{ date('d F Y') }}</p>
        <p style="margin-top: 60px;"><strong>{{ auth()->user()->fullname }}</strong></p>
        <p>NIP. {{ auth()->user()->nip ?? '-' }}</p>
    </div>

    <script>
        document.title = "Jurnal-{{ str_replace(' ', '_', auth()->user()->fullname) }}-{{ request('semester', 'Semua') }}-{{ date('d_m_Y') }}";
    </script>
</body>
</html>
