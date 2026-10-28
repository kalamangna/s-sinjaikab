# Catatan Perubahan

Semua perubahan penting pada proyek ini dicatat dalam berkas ini berdasarkan format [Keep a Changelog](https://keepachangelog.com/id/1.1.0/).

## [1.1.0] - 2026-10-28

### Ditambahkan
- Komponen notifikasi mengambang dengan penghitung waktu penutupan otomatis dan tombol tutup mandiri tanpa menutupi navigasi.
- Mekanisme pencegahan pengiriman ganda pada seluruh formulir pembuatan tautan, pengubahan data, dan autentikasi.
- Pesan galat validasi kontekstual langsung di bawah setiap kolom isian formulir dengan batas visual penanda kesalahan yang kontras.
- Atribut aksesibilitas pembaca layar pada tombol penutup dialog dan cincin fokus kontras pada seluruh kontrol interaktif.

### Diubah
- Standardisasi teks tombol aksi menggunakan pola kata kerja aktif dan objek spesifik.
- Penyesuaian tombol autentikasi dan kontrol tabel menggunakan istilah baku definitif Login, Logout, Filter, dan Reset.
- Pembersihan teks antarmuka dari simbol garis miring dan tanda kurung sesuai panduan penulisan baku.
- Pembaruan tampilan kosong menjadi lebih deklaratif dan informatif dengan panduan tindakan lanjutan.

## [1.0.0] - 2026-10-27

### Keamanan
- Penghapusan informasi kredensial akun bawaan dari berkas README.md guna menjaga kerahasiaan akses sistem.

### Ditambahkan
- Pembaruan antarmuka terinspirasi Bitly dan s.id berupa Kotak Pemendek Cepat (Quick Shorten Bar) dan daftar tautan berpola Hybrid Link Card.
- Interaksi salin tautan satu ketukan dengan umpan balik status visual instan tanpa dialog pop-up peramban.
- Penyeragaman peran menjadi user langsung untuk seluruh ASN yang masuk via ENIKDA Gateway, serta penghapusan modul pengelolaan akun manual.
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
