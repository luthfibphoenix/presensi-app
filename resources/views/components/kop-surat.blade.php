@php
    $logoKiri = '';
    $logoKanan = '';
    try {
        $pathKiri = public_path('images/logo-kiri.png');
        $pathKanan = public_path('images/logo-kanan.png');
        
        if (file_exists($pathKiri)) {
            $dataKiri = file_get_contents($pathKiri);
            $logoKiri = 'data:image/png;base64,' . base64_encode($dataKiri);
        }
        
        if (file_exists($pathKanan)) {
            $dataKanan = file_get_contents($pathKanan);
            $logoKanan = 'data:image/png;base64,' . base64_encode($dataKanan);
        }
    } catch (\Exception $e) {
        // Fallback to asset for browser if base64 fails
        $logoKiri = asset('images/logo-kiri.png');
        $logoKanan = asset('images/logo-kanan.png');
    }
@endphp

<div style="width: 100%; border-bottom: 3px solid black; padding-bottom: 2px; margin-bottom: 20px; font-family: 'Times New Roman', Times, serif;">
    <table style="width: 100%; border-collapse: collapse; border: none;">
        <tr>
            <td style="width: 15%; text-align: left; vertical-align: middle; border: none;">
                @if($logoKiri)
                <img src="{{ $logoKiri }}" style="width: 75px; height: auto;">
                @endif
            </td>
            <td style="width: 70%; text-align: center; vertical-align: middle; border: none;">
                <p style="margin: 0; padding: 0; font-size: 14pt; font-weight: normal; text-transform: uppercase; line-height: 1.2;">PEMERINTAH PROVINSI JAWA TENGAH</p>
                <p style="margin: 0; padding: 0; font-size: 14pt; font-weight: normal; text-transform: uppercase; line-height: 1.2;">DINAS PENDIDIKAN DAN KEBUDAYAAN</p>
                <p style="margin: 2px 0; padding: 0; font-size: 18pt; font-weight: bold; text-transform: uppercase; line-height: 1.2;">SEKOLAH MENENGAH KEJURUAN NEGERI 7 PURWOREJO</p>
                <p style="margin: 5px 0 0 0; padding: 0; font-size: 9pt; font-weight: normal; line-height: 1.3;">
                    Jalan Cangkrep Bagelen Km 7 Desa Kemanukan Kecamatan Bagelen Kabupaten Purworejo Kode Pos 54174 Telepon 0275 2973748 website www.smkn7purworejo.sch.id
                </p>
            </td>
            <td style="width: 15%; text-align: right; vertical-align: middle; border: none;">
                @if($logoKanan)
                <img src="{{ $logoKanan }}" style="width: 75px; height: auto;">
                @endif
            </td>
        </tr>
    </table>
</div>
