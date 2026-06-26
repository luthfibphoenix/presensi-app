# Dokumen Instrumen UAT dan Kuesioner

Dokumen ini berisi draf teks, tabel skala Likert, rumus perhitungan, dan instrumen 19 pertanyaan kuesioner UAT yang siap disalin ke dalam laporan Tugas Akhir (TA) Anda.

---

## 4.2 User Acceptance Test (UAT)

*User Acceptance Testing* (UAT) dilakukan untuk mengukur tingkat penerimaan sistem dari perspektif pengguna akhir. Pengujian melibatkan 12 responden yang menjawab 19 pertanyaan untuk role *Guru Mengajar*, *Guru Piket*, *Siswa*, dan *Orang Tua*. Responden mencoba sistem secara mandiri kemudian mengisi kuesioner menggunakan skala Likert dengan ketentuan sebagai berikut:

Sebelum instrumen kuesioner didistribusikan kepada responden, butir-butir pernyataan telah melalui tahap *Face Validity* (Validitas Muka) dan penyesuaian konstruk berdasarkan kerangka *System Usability Scale* (SUS) yang dimodifikasi. Setiap butir pernyataan dirancang menggunakan kalimat netral untuk menghindari penggiringan opini (*leading questions*), sehingga responden dapat menilai aspek Kemudahan Penggunaan, Kesesuaian Fungsi, Kualitas Informasi, serta Efisiensi dan Kemanfaatan secara objektif sesuai dengan pengalaman interaksi riil mereka terhadap Aplikasi Presensi Sekolah Berbasis *Multi-Role*.


| Skor | Keterangan |
| :---: | :--- |
| **5** | Sangat Setuju (SS) |
| **4** | Setuju (S) |
| **3** | Netral (N) |
| **2** | Tidak Setuju (TS) |
| **1** | Sangat Tidak Setuju (STS) |

<p align="center"><b>Tabel 4. 2 Skala Likert (Dr. Arif Rachman, 2024)</b></p>

Hasil UAT dihitung dengan menggunakan rumus:

$$\text{Persentase Kelayakan (\%)} = \frac{\text{Total Skor Aktual}}{\text{Total Skor Maksimum}} \times 100\%$$

Di mana:
- **Total Skor Aktual**: Jumlah dari seluruh nilai jawaban yang diberikan oleh responden untuk seluruh pertanyaan.
- **Total Skor Maksimum**: Jumlah responden $\times$ Jumlah pertanyaan $\times$ Bobot skor tertinggi (5).
  - *Perhitungan*: $12 \text{ responden} \times 19 \text{ pertanyaan} \times 5 = 1.140$ (skor maksimum keseluruhan).

Interval kriteria interpretasi skor untuk menentukan tingkat kelayakan/penerimaan sistem adalah sebagai berikut:

| Interval Persentase | Kategori Kelayakan / Penerimaan |
| :---: | :--- |
| **81% - 100%** | Sangat Layak (Sangat Diterima) |
| **61% - 80%** | Layak (Diterima) |
| **41% - 60%** | Cukup Layak |
| **21% - 40%** | Tidak Layak |
| **0% - 20%** | Sangat Tidak Layak |

<p align="center"><b>Tabel 4. 3 Interval Kriteria Kelayakan UAT</b></p>

### Aspek Penilaian UAT

Kuesioner evaluasi ini dirancang berdasarkan **4 aspek utama** untuk menilai kelayakan dan penerimaan sistem oleh pengguna akhir:

1. **Usability (Kemudahan Penggunaan & Antarmuka)**: Mengukur kemudahan navigasi, kejelasan struktur menu, dan kenyamanan tampilan antarmuka sistem bagi semua kalangan pengguna. *(Korelasi Pertanyaan: GM01, GP01, S01, S05, OT03)*
2. **Functionality (Kesesuaian Fungsi Sistem)**: Mengukur apakah seluruh fitur utama (pencatatan presensi, persetujuan izin, unggah bukti surat) berfungsi dengan benar, cepat, dan tanpa kendala teknis. *(Korelasi Pertanyaan: GM02, GM05, GP02, GP04, S03, OT02)*
3. **Information Quality (Kualitas & Transparansi Informasi)**: Mengukur keakuratan, kejelasan, dan kebaruan penyajian data presensi serta rekapitulasi kehadiran secara langsung (*real-time*). *(Korelasi Pertanyaan: GM03, GP05, S02, S04, OT01)*
4. **Efficiency & Utility (Efisiensi & Kemanfaatan)**: Mengukur dampak positif sistem dalam menunjang efisiensi waktu perekapan data kehadiran serta keefektifan pemantauan kedisiplinan siswa. *(Korelasi Pertanyaan: GM04, GP03, S05, OT04)*

---

Berikut adalah instrumen butir pertanyaan kuesioner yang disebarkan kepada para responden berdasarkan peran (*role*) masing-masing:

| No | Kode | Role | Butir Pertanyaan |
| :---: | :---: | :--- | :--- |
| 1 | **GM01** | Guru Mengajar | Antarmuka halaman Dashboard Guru Mengajar mudah dipahami dan digunakan. |
| 2 | **GM02** | Guru Mengajar | Fitur pembukaan sesi presensi dan pencatatan kehadiran siswa berjalan sesuai kebutuhan. |
| 3 | **GM03** | Guru Mengajar | QR Code dinamis yang dihasilkan sistem memudahkan proses presensi siswa. |
| 4 | **GM04** | Guru Mengajar | Informasi jadwal mengajar dan riwayat presensi ditampilkan dengan jelas. |
| 5 | **GM05** | Guru Mengajar | Secara keseluruhan, sistem membantu proses pencatatan kehadiran siswa menjadi lebih efektif. |
| 6 | **GP01** | Guru Piket | Antarmuka halaman Dashboard Guru Piket memudahkan pemantauan kehadiran siswa secara keseluruhan. |
| 7 | **GP02** | Guru Piket | Proses verifikasi izin dan sakit siswa mudah dilakukan melalui sistem. |
| 8 | **GP03** | Guru Piket | Rekapitulasi kehadiran siswa membantu proses administrasi sekolah secara lebih efisien. |
| 9 | **GP04** | Guru Piket | Fitur pencarian data kehadiran siswa bekerja dengan baik dan mudah digunakan. |
| 10 | **GP05** | Guru Piket | Sistem membantu Guru Piket memperoleh informasi kehadiran siswa secara cepat dan akurat. |
| 11 | **S01** | Siswa | Antarmuka aplikasi presensi mudah dipahami dan digunakan. |
| 12 | **S02** | Siswa | Proses melakukan presensi menggunakan QR Code mudah dilakukan. |
| 13 | **S03** | Siswa | Status kehadiran dan perizinan (izin/sakit) yang telah dikonfirmasi sekolah dapat dipantau siswa secara langsung. |
| 14 | **S04** | Siswa | Informasi riwayat kehadiran ditampilkan dengan jelas dan mudah dipahami. |
| 15 | **S05** | Siswa | Penggunaan aplikasi membantu saya memantau kehadiran di sekolah. |
| 16 | **OT01** | Orang Tua | Orang tua dapat memantau status kehadiran anak di sekolah melalui aplikasi dengan mudah. |
| 17 | **OT02** | Orang Tua | Proses pengiriman surat izin atau sakit anak melalui aplikasi mudah dilakukan. |
| 18 | **OT03** | Orang Tua | Informasi laporan kehadiran anak disajikan dengan jelas dan mudah dipahami. |
| 19 | **OT04** | Orang Tua | Aplikasi membantu orang tua memantau kehadiran anak secara lebih efektif. |

<p align="center"><b>Tabel 4. 4 Instrumen Pertanyaan UAT</b></p>
