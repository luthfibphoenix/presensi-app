# Dokumen UAT (User Acceptance Test) Lengkap
## Sistem Presensi Sekolah Berbasis Multi-Role SMKN 7 Purworejo

Dokumen ini berisi instrumen 25 butir pertanyaan kuesioner UAT, indikator teori pendukung (TAM, ISO 25010, Nielsen Heuristics), skenario langkah pengujian per peran (*role*), serta panduan integrasi ke Google Forms dan draf pesan siaran (*broadcast*).

---

## 1. Instrumen Pertanyaan UAT & Indikator Teori

Berikut adalah 25 butir instrumen pertanyaan kuesioner UAT yang disebarkan kepada responden berdasarkan peran (*role*) masing-masing:

| No | Kode | Role | Butir Pernyataan | Indikator Teori (Referensi) |
| :---: | :---: | :--- | :--- | :--- |
| 1 | **GM01** | Guru Mengajar | Antarmuka Dashboard Guru Mengajar terstruktur dengan baik sehingga mudah dipelajari dan dioperasikan. | Perceived Ease of Use (TAM) |
| 2 | **GM02** | Guru Mengajar | Fitur pembukaan sesi dan pencatatan presensi siswa berfungsi sesuai dengan tujuannya tanpa kendala sistem (error). | Functional Suitability (ISO 25010) |
| 3 | **GM03** | Guru Mengajar | Sistem mampu menghasilkan QR Code dinamis secara akurat untuk memfasilitasi proses presensi. | Functional Suitability (ISO 25010) |
| 4 | **GM04** | Guru Mengajar | Sistem memberikan umpan balik dan menampilkan informasi jadwal mengajar serta riwayat presensi dengan sangat jelas. | Visibility of System Status (Nielsen) |
| 5 | **GM05** | Guru Mengajar | Penggunaan sistem ini membuat proses rekapitulasi dan pencatatan kehadiran siswa menjadi lebih cepat dan efisien. | Perceived Usefulness (TAM) |
| 6 | **GM06** | Guru Mengajar | Sistem memberikan konfirmasi pencegahan sebelum guru menutup sesi kelas agar tidak terjadi salah klik yang tidak disengaja. | Error Prevention (Nielsen) |
| 7 | **GM07** | Guru Mengajar | Saya merasa aman menggunakan sistem ini karena hak akses jurnal mengajar dan penilaian kelas dibatasi dengan baik. | Security / Confidentiality (ISO 25010) |
| 8 | **GP01** | Guru Piket | Antarmuka Dashboard Guru Piket intuitif dan tata letak menunya mudah dipahami. | Perceived Ease of Use (TAM) |
| 9 | **GP02** | Guru Piket | Proses verifikasi status izin dan sakit siswa dapat dieksekusi dengan baik oleh sistem sesuai dengan alur kerja. | Functional Suitability (ISO 25010) |
| 10 | **GP03** | Guru Piket | Fitur rekapitulasi kehadiran yang disediakan secara efektif membantu mempercepat proses administrasi sekolah. | Perceived Usefulness (TAM) |
| 11 | **GP04** | Guru Piket | Fitur pencarian (search) data kehadiran siswa berfungsi dengan baik dan mudah dioperasikan. | Usability (ISO 25010) & Ease of Use (TAM) |
| 12 | **GP05** | Guru Piket | Sistem meningkatkan produktivitas saya dalam memperoleh dan mengelola informasi kehadiran siswa secara keseluruhan. | Perceived Usefulness (TAM) |
| 13 | **GP06** | Guru Piket | Aplikasi dapat diakses dengan stabil dan responsif melalui perangkat komputer (PC/Laptop) maupun smartphone. | Portability & Compatibility (ISO 25010) |
| 14 | **S01** | Siswa | Antarmuka aplikasi presensi dari sisi pengguna siswa sangat mudah dipahami dan digunakan secara mandiri. | Perceived Ease of Use (TAM) |
| 15 | **S02** | Siswa | Sistem memproses pemindaian (scan) QR Code presensi dengan baik dan akurat. | Functional Suitability (ISO 25010) |
| 16 | **S03** | Siswa | Status kehadiran (Hadir/Izin/Sakit) divisualisasikan dengan jelas sehingga saya langsung mengetahui status absensi saya. | Visibility of System Status (Nielsen) |
| 17 | **S04** | Siswa | Informasi riwayat kehadiran ditampilkan secara informatif dan mudah dibaca pada layar perangkat saya. | Visibility of System Status (Nielsen) |
| 18 | **S05** | Siswa | Aplikasi ini sangat bermanfaat dalam membantu saya memantau kedisiplinan dan riwayat kehadiran di sekolah. | Perceived Usefulness (TAM) |
| 19 | **S06** | Siswa | Sistem memberikan instruksi/pesan yang jelas jika proses scan QR Code mengalami kegagalan (misalnya QR kedaluwarsa). | Help Users & Recover Errors (Nielsen) |
| 20 | **OT01** | Orang Tua | Menu dan navigasi pada aplikasi dapat digunakan dengan mudah oleh orang tua tanpa memerlukan panduan khusus. | Perceived Ease of Use (TAM) |
| 21 | **OT02** | Orang Tua | Fitur pengajuan dan pengiriman surat izin/sakit anak berfungsi dengan baik dan tersimpan ke dalam sistem secara tepat. | Functional Suitability (ISO 25010) |
| 22 | **OT03** | Orang Tua | Sistem memberikan informasi riwayat dan status kehadiran anak saat ini secara jelas dan real-time. | Visibility of System Status (Nielsen) |
| 23 | **OT04** | Orang Tua | Penggunaan aplikasi ini efektif dalam membantu orang tua melakukan pengawasan (monitoring) terhadap kehadiran anak di sekolah. | Perceived Usefulness (TAM) |
| 24 | **OT05** | Orang Tua | Sistem memberikan jaminan keamanan data yang baik terhadap kerahasiaan data pribadi anak saya. | Security & Trust (ISO 25010 / TAM) |
| 25 | **OT06** | Orang Tua | Secara keseluruhan, saya merasa sangat puas terhadap kinerja dan layanan yang disediakan oleh aplikasi presensi ini. | User Satisfaction (ISO 25010) |

---

## 2. Skenario Pengujian UAT per Role (Langkah Pengujian)

### SKENARIO 1: ROLE - GURU MENGAJAR
*   **Aktor**: Guru Mengajar / Pengampu Mata Pelajaran
*   **Username Uji Coba**: `Ardi` (Gunakan akun Guru yang ada di database)
*   **Password**: Password utama akun Guru Anda
*   **URL Login**: `/login` (Unified Login Portal)

*   **Langkah 1: Akses Dashboard Utama (Menguji GM01)**
    *   *Aksi*: Buka web browser, masuk ke URL Login, ketik username "Ardi" dan password utama Anda, lalu klik tombol "Masuk ke Sistem".
    *   *Hasil yang Diharapkan*: Sistem berhasil mengarahkan Guru ke halaman Dashboard Utama Guru. Seluruh komponen menu seperti sidebar navigasi, grafik kehadiran hari ini, dan profil pengguna tampil secara rapi, terstruktur, serta mudah dipahami tata letaknya.
*   **Langkah 2: Pembukaan Sesi Presensi & Jurnal (Menguji GM02)**
    *   *Aksi*: Di sidebar kiri, klik menu "Jadwal Hari Ini". Cari jadwal kelas mengajar yang aktif saat ini, lalu klik tombol "Mulai Kelas". Pada form jurnal mengajar yang muncul, isi bagian "Materi Pembelajaran" (contoh: KBM Bola Voli) dan isi kolom "Tautan Media", kemudian klik tombol "Simpan & Generate QR".
    *   *Hasil yang Diharapkan*: Sesi kelas berhasil dibuat, jurnal mengajar tersimpan ke database, dan sistem secara otomatis mengalihkan halaman ke tampilan presentasi QR Code untuk siswa.
*   **Langkah 3: Pemantauan QR Code Dinamis (Menguji GM03)**
    *   *Aksi*: Amati QR Code yang ditampilkan pada layar laptop/proyektor kelas. Biarkan layar terbuka beberapa saat untuk melihat perubahan token QR secara otomatis berdasarkan waktu hitung mundur (countdown), atau klik tombol "Refresh QR" untuk mengganti QR Code secara manual.
    *   *Hasil yang Diharapkan*: QR Code tampil dengan jelas dan berubah secara otomatis secara berkala (dinamis), mencegah siswa mendistribusikan tangkapan layar (screenshot) QR ke siswa lain di luar kelas.
*   **Langkah 4: Memeriksa Jadwal & Riwayat (Menguji GM04)**
    *   *Aksi*: Klik menu "Semua Jadwal" di sidebar untuk melihat jadwal mengajar mingguan Anda. Kemudian klik menu "Jurnal Saya" untuk melihat daftar arsip jurnal mengajar yang pernah diisi sebelumnya.
    *   *Hasil yang Diharapkan*: Informasi jadwal mengajar (hari, jam, kelas, mata pelajaran) serta riwayat pengisian jurnal mengajar sebelumnya tersaji secara lengkap, urut, dan informatif.
*   **Langkah 5: Pencatatan Kehadiran Siswa Real-Time (Menguji GM05)**
    *   *Aksi*: Biarkan beberapa siswa melakukan scan QR Code dari ponsel mereka masing-masing. Perhatikan tabel "Status Kehadiran" di bagian bawah layar QR Code Guru.
    *   *Hasil yang Diharapkan*: Sistem mendeteksi pemindaian siswa secara real-time. Status kehadiran siswa langsung berubah menjadi "Hadir" di layar Guru secara otomatis tanpa perlu guru memanggil nama satu per satu, sehingga proses absensi berjalan sangat cepat dan efisien.
*   **Langkah 6: Konfirmasi Pencegahan Tutup Kelas (Menguji GM06)**
    *   *Aksi*: Setelah sesi kelas selesai, klik tombol "Akhiri Kelas" di dashboard atau menu navigasi.
    *   *Hasil yang Diharapkan*: Sistem tidak langsung menutup sesi secara sepihak, melainkan memunculkan pop-up konfirmasi ("Apakah Anda yakin ingin mengakhiri kelas?") untuk mencegah penutupan kelas akibat salah klik yang tidak disengaja.
*   **Langkah 7: Keamanan Hak Akses Data Jurnal & Nilai (Menguji GM07)**
    *   *Aksi*: Cobalah untuk membuka data jurnal atau penilaian milik guru lain, atau mencoba mengubah ID jurnal di URL browser secara acak.
    *   *Hasil yang Diharapkan*: Sistem menolak akses tersebut dan menampilkan halaman error (404 / 403 Forbidden) karena hak akses dibatasi dengan ketat hanya untuk guru yang bersangkutan.

---

### SKENARIO 2: ROLE - GURU PIKET
*   **Aktor**: Guru Piket Sekolah
*   **Username Uji Coba**: `Ardi` (Gunakan akun Guru yang ada di database)
*   **Password**: Password Piket Khusus
*   **URL Login**: `/login` (Unified Login Portal)

*   **Langkah 1: Akses Dashboard Guru Piket (Menguji GP01)**
    *   *Aksi*: Buka web browser, masuk ke URL Login, ketik username "Ardi" dan masukkan password piket khusus Anda, lalu klik "Masuk ke Sistem".
    *   *Hasil yang Diharapkan*: Sistem mendeteksi password piket dan mengarahkan Guru ke halaman "Dashboard Guru Piket" dengan aksen warna hijau hutan khas piket. Halaman menyajikan ringkasan statistik kehadiran siswa sekolah hari ini (Hadir, Izin, Sakit, Alfa) dengan antarmuka yang intuitif.
*   **Langkah 2: Verifikasi Surat Izin/Sakit Siswa (Menguji GP02)**
    *   *Aksi*: Klik menu "Surat Izin Siswa" di sidebar kiri. Temukan daftar pengajuan izin dari orang tua/siswa berstatus pending. Klik berkas lampiran untuk melihat foto surat bukti fisik dari orang tua, lalu klik tombol "Setujui" atau "Tolak".
    *   *Hasil yang Diharapkan*: Status izin siswa tersebut berubah di sistem piket, dan data presensi siswa yang bersangkutan secara otomatis di-update menjadi Izin/Sakit pada database kelas tanpa perlu input manual ke daftar hadir oleh piket.
*   **Langkah 3: Membuat Rekapitulasi Kehadiran Harian (Menguji GP03)**
    *   *Aksi*: Klik menu "Rekap Harian" di sidebar. Tentukan filter tanggal yang ingin dicari, lalu tekan tombol proses/cari.
    *   *Hasil yang Diharapkan*: Sistem memproses rekapitulasi data kehadiran siswa per kelas secara otomatis dan menyajikan persentase kehadiran lengkap yang siap dibagikan ke pihak administrasi sekolah untuk mempercepat pekerjaan.
*   **Langkah 4: Pencarian & Penyaringan Data Kehadiran Siswa (Menguji GP04)**
    *   *Aksi*: Buka menu "Laporan Kehadiran" (atau menu Database Siswa). Pada kolom search filter, ketik nama siswa (contoh: "Aspasia") atau pilih filter kelas tertentu, lalu tekan enter.
    *   *Hasil yang Diharapkan*: Baris data log kehadiran siswa yang dicari langsung tersaring dan muncul secara akurat di tabel hasil pencarian.
*   **Langkah 5: Akses Informasi Cepat Status Kelas (Menguji GP05)**
    *   *Aksi*: Perhatikan bagian grafik monitoring kelas yang sedang aktif atau status kehadiran real-time di halaman utama dashboard piket.
    *   *Hasil yang Diharapkan*: Guru Piket dapat langsung memantau kelas mana saja yang belum mulai belajar atau melihat daftar siswa yang tidak hadir hari ini secara instan, akurat, dan real-time guna meningkatkan produktivitas.
*   **Langkah 6: Pengujian Responsifitas Multi-Device (Menguji GP06)**
    *   *Aksi*: Akses dashboard piket menggunakan perangkat komputer (PC/Laptop) di meja piket, kemudian coba akses kembali menggunakan browser smartphone.
    *   *Hasil yang Diharapkan*: Tampilan halaman piket dapat menyesuaikan ukuran layar dengan stabil, responsif, dan tidak ada tata letak menu yang rusak saat dibuka di kedua perangkat tersebut.

---

### SKENARIO 3: ROLE - SISWA
*   **Aktor**: Siswa SMKN 7 Purworejo
*   **Username Uji Coba**: `aspasia.benita` (Format: namadepan.namabelakang)
*   **Password**: `3869` (Password default menggunakan NIS siswa)
*   **URL Login**: `/login` (Unified Login Portal)

*   **Langkah 1: Akses Dashboard Siswa (Menguji S01)**
    *   *Aksi*: Akses URL login menggunakan smartphone. Ketik username "aspasia.benita" dan password "3869", lalu klik "Masuk ke Sistem".
    *   *Hasil yang Diharapkan*: Aplikasi terbuka dengan antarmuka berdesain mobile-friendly. Menu navigasi bawah dan ringkasan kehadiran siswa hari ini tampil rapi serta mudah digunakan.
*   **Langkah 2: Melakukan Presensi dengan Scan QR Code (Menguji S02)**
    *   *Aksi*: Pada halaman beranda siswa, ketuk tombol menu "Scan QR Absen". Izinkan aplikasi mengakses kamera jika diminta browser. Arahkan kamera smartphone ke QR Code dinamis yang diproyeksikan oleh Guru Mengajar di depan kelas.
    *   *Hasil yang Diharapkan*: Kamera dengan cepat membaca QR Code, sistem memproses data koordinat/token, dan menampilkan notifikasi sukses "Presensi Berhasil Direkam".
*   **Langkah 3: Memeriksa Status Kehadiran Hari Ini (Menguji S03)**
    *   *Aksi*: Setelah melakukan scan QR Code, kembali ke halaman utama dashboard siswa. Perhatikan status kehadiran pada jam pelajaran yang baru saja diikuti.
    *   *Hasil yang Diharapkan*: Status kehadiran pada jam pelajaran tersebut berubah menjadi "Hadir". Siswa juga bisa melihat status "Izin" atau "Sakit" jika perizinannya telah dikonfirmasi oleh guru piket.
*   **Langkah 4: Memantau Riwayat Kehadiran (Menguji S04)**
    *   *Aksi*: Ketuk menu "Riwayat Kehadiran" di bagian navigasi bawah.
    *   *Hasil yang Diharapkan*: Sistem menampilkan log riwayat presensi harian siswa secara urut waktu beserta info tanggal, jam scan, nama guru, mata pelajaran, dan status kehadirannya.
*   **Langkah 5: Kemanfaatan Pemantauan Mandiri (Menguji S05)**
    *   *Aksi*: Periksa persentase total kehadiran kumulatif Anda yang terletak di bagian atas halaman riwayat presensi.
    *   *Hasil yang Diharapkan*: Siswa dapat dengan mudah memantau total persentase kehadiran mereka secara berkala untuk memastikan kedisiplinan dan memenuhi batas minimal absensi sekolah tanpa harus menanyakan data manual ke guru BK/Wali Kelas.
*   **Langkah 6: Penanganan Kegagalan Scan QR (Menguji S06)**
    *   *Aksi*: Coba lakukan scan pada QR Code kelas yang sudah diakhiri (expired) atau coba lakukan scan QR Code milik kelas lain yang bukan jadwal Anda.
    *   *Hasil yang Diharapkan*: Sistem memblokir proses absensi dan menampilkan pesan kesalahan yang sangat jelas di layar ponsel Anda (contoh: "QR Code sudah kadaluarsa. Minta guru untuk melakukan Refresh QR" atau "Maaf, QR Code ini ditujukan untuk kelas X").

---

### SKENARIO 4: ROLE - ORANG TUA
*   **Aktor**: Orang Tua Wali Siswa
*   **Username Uji Coba**: `aspasia.3869` (Format: namadepansiswa.NIS)
*   **Password**: `ortu123` (Password default orang tua)
*   **URL Login**: `/ortu/login` (Portal khusus orang tua)

*   **Langkah 1: Akses Dashboard Orang Tua (Menguji OT01)**
    *   *Aksi*: Buka web browser di ponsel, masuk ke URL portal orang tua (/ortu/login), ketik username "aspasia.3869" dan password "ortu123", lalu klik "Masuk Sekarang".
    *   *Hasil yang Diharapkan*: Orang tua berhasil masuk ke dashboard khusus. Nama anak, kelas, dan ringkasan status kehadiran anak hari ini langsung tampil di halaman utama secara jelas tanpa memerlukan panduan khusus.
*   **Langkah 2: Mengirim Surat Pengajuan Izin/Sakit (Menguji OT02)**
    *   *Aksi*: Masuk ke menu "Pengajuan Izin" di navigasi bawah. Klik tombol "Buat Pengajuan Baru". Pilih tanggal awal & akhir izin, tentukan tipe keterangan (Izin atau Sakit), ketik alasan lengkap pada kolom teks (contoh: "Sakit demam tinggi"), lalu ketuk kolom lampiran untuk mengambil foto surat dokter/surat izin fisik dari kamera ponsel Anda. Klik tombol "Kirim Izin".
    *   *Hasil yang Diharapkan*: Pengajuan izin berhasil dikirim ke guru piket, muncul notifikasi sukses, dan data pengajuan masuk ke daftar riwayat dengan status "Menunggu Konfirmasi".
*   **Langkah 3: Membaca Laporan Kehadiran Anak (Menguji OT03)**
    *   *Aksi*: Masuk ke menu "Laporan Kehadiran" di bagian menu bawah.
    *   *Hasil yang Diharapkan*: Halaman menyajikan rekap log presensi harian anak dalam bentuk tabel bulanan secara detail (tanggal, jam masuk, nama guru, mata pelajaran, dan status kehadiran anak) dengan tampilan yang sederhana dan real-time.
*   **Langkah 4: Keefektifan Pemantauan Kehadiran Anak (Menguji OT04)**
    *   *Aksi*: Buka halaman beranda orang tua saat anak disimulasikan melakukan scan QR presensi di kelas.
    *   *Hasil yang Diharapkan*: Status kehadiran anak langsung berubah menjadi "Hadir" secara real-time pada dashboard orang tua, memberikan kemudahan bagi orang tua untuk memantau kehadiran anak di sekolah secara efektif meskipun dari jarak jauh.
*   **Langkah 5: Pengujian Kerahasiaan Keamanan Data Anak (Menguji OT05)**
    *   *Aksi*: Periksa apakah ada celah menu yang memungkinkan Anda melihat data presensi anak orang lain, atau mencoba mengakses halaman profil siswa lain.
    *   *Hasil yang Diharapkan*: Sistem memberikan jaminan keamanan data yang baik. Data kehadiran yang ditampilkan dikunci rapat hanya untuk anak kandung Anda sendiri (siswa_id terikat dengan user orang tua).
*   **Langkah 6: Penilaian Kepuasan Pengguna (Menguji OT06)**
    *   *Aksi*: Refleksikan seluruh pengalaman Anda setelah menggunakan aplikasi presensi ini (kemudahan, kecepatan, akurasi, dan desain antarmuka).
    *   *Hasil yang Diharapkan*: Orang tua merasa puas terhadap kinerja, stabilitas, dan manfaat layanan yang disediakan oleh aplikasi presensi ini untuk memantau kehadiran anak mereka di sekolah.

---

## 3. Struktur Pengaturan Google Forms (Percabangan)

Untuk menyusun instrumen kuesioner ini secara digital di Google Forms agar berjalan sesuai alur uji coba, ikuti panduan berikut:

### Bagian 1: Identitas Responden (Halaman Utama)
*   **Pertanyaan 1 (Teks Jawaban Singkat)**: `Nama Lengkap` (Wajib diisi)
*   **Pertanyaan 2 (Pilihan Ganda)**: `Peran Responden dalam Pengujian Sistem` (Wajib diisi)
    *   *Opsi 1*: `Guru Mengajar`
    *   *Opsi 2*: `Guru Piket`
    *   *Opsi 3*: `Siswa`
    *   *Opsi 4*: `Orang Tua`
*   *Pengaturan Percabangan*: Klik ikon titik tiga di kanan bawah Pertanyaan 2, aktifkan **"Buka bagian berdasarkan jawaban"**. Arahkan tiap opsi ke Bagian (Section) yang relevan (Bagian 2 s.d 5).
*   **Pertanyaan 3 (Teks Jawaban Singkat)**: `Kelas / Jabatan / Hubungan Wali (Contoh: XI PPLG / Guru Produktif / Orang Tua dari Rizka)` (Wajib diisi)

### Bagian 2: Kuesioner UAT - Guru Mengajar
*   *Tipe Pertanyaan*: **Kisi Pilihan Ganda** (Multiple Choice Grid)
*   *Pertanyaan*: `Silakan berikan penilaian Anda terhadap pernyataan di bawah ini dengan memilih skala 1 s.d 5 (Sangat Tidak Setuju hingga Sangat Setuju).`
*   *Baris (Rows)*: Isi dengan butir **GM01** sampai **GM07**.
*   *Kolom (Columns)*: 
    *   `1 (Sangat Tidak Setuju)`
    *   `2 (Tidak Setuju)`
    *   `3 (Netral / Ragu-ragu)`
    *   `4 (Setuju)`
    *   `5 (Sangat Setuju)`
*   *Pengaturan Bagian*: Di bawah Bagian 2, ubah *"Lanjutkan ke bagian berikutnya"* menjadi **"Kirim formulir"**.

### Bagian 3: Kuesioner UAT - Guru Piket
*   *Tipe Pertanyaan*: Kisi Pilihan Ganda.
*   *Baris (Rows)*: Isi dengan butir **GP01** sampai **GP06**.
*   *Kolom (Columns)*: Pilihan skor 1 s.d 5.
*   *Pengaturan Bagian*: Di bawah Bagian 3, ubah *"Lanjutkan ke bagian berikutnya"* menjadi **"Kirim formulir"**.

### Bagian 4: Kuesioner UAT - Siswa
*   *Tipe Pertanyaan*: Kisi Pilihan Ganda.
*   *Deskripsi*:
    `Silakan berikan penilaianmu terhadap butir pernyataan di bawah ini dengan memilih skala 1 s.d 5 (Sangat Tidak Setuju hingga Sangat Setuju).`
    
    `Skor 5 : Sangat Setuju (SS)`
    `Skor 4 : Setuju (S)`
    `Skor 3 : Netral / Ragu-ragu (N)`
    `Skor 2 : Tidak Setuju (TS)`
    `Skor 1 : Sangat Tidak Setuju (STS)`
    
    `Panduan Uji Coba: Pastikan kamu telah mencoba login sebagai Siswa menggunakan username (namadepan.namabelakang, Contoh: aspasia.benita), melakukan pemindaian (scan) QR Code pada menu "Scan QR Absen", serta memeriksa status presensi hari ini dan menu "Riwayat Kehadiran".`
*   *Baris (Rows)*: Isi dengan butir **S01** sampai **S06**.
*   *Kolom (Columns)*: Pilihan skor 1 s.d 5.
*   *Pengaturan Bagian*: Di bawah Bagian 4, ubah *"Lanjutkan ke bagian berikutnya"* menjadi **"Kirim formulir"**.

### Bagian 5: Kuesioner UAT - Orang Tua
*   *Tipe Pertanyaan*: Kisi Pilihan Ganda.
*   *Baris (Rows)*: Isi dengan butir **OT01** sampai **OT06**.
*   *Kolom (Columns)*: Pilihan skor 1 s.d 5.

---

## 4. Draf Pesan Siaran WhatsApp (Broadcast)

### Versi Formal (Untuk Guru & Orang Tua)
```text
Assalamu'alaikum Warahmatullahi Wabarakatuh,
Selamat pagi/siang Bapak, Ibu, dan Teman-teman semua. 🙏

Perkenalkan, saya Luthfi Bachtiar Riyanto. Saat ini saya sedang menyelesaikan Tugas Akhir dengan judul "Aplikasi Presensi Sekolah Berbasis Multi-Role Menggunakan QR Code Dinamis di SMK Negeri 7 Purworejo".

Saat ini saya sedang melakukan tahap pengujian sistem menggunakan metode User Acceptance Test (UAT). Sehubungan dengan hal tersebut, saya memohon bantuan Bapak/Ibu dan Teman-teman sekalian untuk meluangkan waktu sejenak guna mencoba aplikasi yang telah dibuat dan mengisi kuesioner penilaian singkat.

Sebelum mengisi kuesioner, mohon agar dapat mencoba aplikasi terlebih dahulu dengan mengikuti langkah-langkah panduan uji coba yang telah disediakan.

Aplikasi dan kuesioner dapat diakses melalui tautan berikut:
🌐 Link Website Aplikasi: [Masukkan Link Aplikasi Presensi]
📖 Link Panduan Skenario UAT: [Masukkan Link Google Docs/Drive Panduan Uji Coba]
📝 Link Kuesioner UAT: https://forms.gle/7sQp35ojwGKJ8GFY7

Tidak ada jawaban benar atau salah dalam kuesioner ini. Bapak/Ibu dan Teman-teman cukup memberikan penilaian jujur sesuai dengan pengalaman interaksi saat menggunakan aplikasi.

Terima kasih banyak atas bantuan, waktu, dan partisipasinya. Semoga segala kebaikan Bapak/Ibu dan Teman-teman semua dibalas dengan kelimpahan kebaikan pula. Aamiin ya Rabbal 'Alamin. 🙏✨
```

### Versi Santai (Untuk Teman-teman & Siswa)
```text
Halo teman-teman semua! 👋✨

Perkenalkan, aku Luthfi Bachtiar Riyanto. Saat ini aku sedang menyelesaikan Tugas Akhir tentang "Aplikasi Presensi Sekolah Berbasis Multi-Role Menggunakan QR Code Dinamis di SMKN 7 Purworejo".

Sekarang aku lagi ada di tahap pengujian aplikasi dengan metode User Acceptance Test (UAT). Buat mendukung kelancaran penelitian ini, aku minta tolong banget bantuan teman-teman untuk mencoba aplikasi presensi yang sudah aku buat dan mengisi kuesioner penilaian singkatnya.

Sebelum mengisi kuesioner, harap cobain aplikasinya dulu ya dengan mengikuti langkah-langkah panduan uji coba yang sudah disediakan.

Aplikasi dan kuesionernya bisa diakses lewat link di bawah ini ya:
🌐 Link Website Aplikasi: [Masukkan Link Aplikasi Presensi]
📖 Link Panduan Skenario UAT: [Masukkan Link Google Docs/Drive Panduan Uji Coba]
📝 Link Kuesioner UAT: https://forms.gle/7sQp35ojwGKJ8GFY7

Di kuesioner ini ga ada jawaban benar atau salah, jadi silakan diisi dengan santai sesuai dengan apa yang teman-teman rasakan pas nyoba aplikasinya.

Terima kasih banyak atas waktu dan bantuannya ya! Semoga urusan teman-teman semua juga dilancarkan. Thank you!
```
