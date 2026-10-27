# Catatan Perubahan

Semua perubahan penting pada proyek ini dicatat dalam berkas ini berdasarkan format [Keep a Changelog](https://keepachangelog.com/id/1.1.0/).

## [1.0.0] - 2026-10-27

### Ditambahkan
- Penyesuaian akun bawaan menjadi 1 akun lokal administrator utama: `kalamangna` (kata sandi: `Syazani`), serta pembersihan seluruh akun percontohan lokal.
- Integrasi autentikasi Gateway ENIKDA / SIMPEG Sinjai untuk login ASN menggunakan NIP dan kata sandi dengan sinkronisasi otomatis nama dan OPD.
- Migrasi penambahan kolom `nip` pada tabel `users`.
- Layanan `EnikdaGatewayService` untuk komunikasi API gateway kepegawaian beserta verifikasi fallback hash.
- Inisialisasi awal proyek Laravel 13 dan konfigurasi Tailwind CSS untuk domain `s.sinjaikab.go.id`.
- Migrasi tabel `short_urls` dan penambahan kolom hak akses peran OPD serta unit kerja pada tabel `users`.
- Modul autentikasi pengguna dengan isolasi hak akses antara Administrator Diskominfo dan Operator OPD.
- Layanan pemendek tautan mandiri dengan dukungan kustom alias slug dan pembuatan kode unik alfanumerik otomatis.
- Validasi keamanan URL tujuan untuk mencegah pengalihan balik mandiri dan memblokir ekstensi berkas yang berpotensi berbahaya.
- Mekanisme pengalihan cepat HTTP 302 disertai penambahan jumlah klik secara atomik.
- Generator kode QR format SVG menggunakan library Simple Software IO QR Code.
- Antarmuka dasbor ringkasan statistik klik tautan dan manajemen akun OPD bagi administrator.
- Halaman depan publik resmi Pemerintah Kabupaten Sinjai dan penanganan halaman galat 404 informatif.
- Rangkaian pengujian fitur otomatis PHPUnit untuk autentikasi, manajemen pengguna, pembuatan tautan, dan pengalihan.
