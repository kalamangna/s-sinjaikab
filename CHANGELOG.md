# Catatan Perubahan

Semua perubahan penting pada proyek ini dicatat dalam berkas ini berdasarkan format [Keep a Changelog](https://keepachangelog.com/id/1.1.0/).

## [1.4.0] - 2026-10-29

### Diubah
- Penggantian seluruh istilah antarmuka dari `tautan` menjadi `link` secara konsisten pada seluruh tampilan, kontroler, layanan, dan pengujian.
- Penataan ulang hierarki dan proporsi *branding* `Link Shortener - Pemkab Sinjai` dengan ukuran judul dan subjudul yang seimbang di header.
- Penyempurnaan tata letak responsif *mobile-first* dan *tablet* pada seluruh halaman:
  - Penataan kartu link mobile dengan header satu baris terpadu dan bilah aksi dalam pola grid 2x2 simetris dengan target sentuh `h-10`.
  - Penataan kartu ringkasan statistik menjadi 2 kolom berdampingan pada mobile untuk menghemat ruang vertikal.
  - Form pencarian dan tombol filter responsif vertikal pada ponsel dan sejajar pada layar tablet dan desktop.
  - Perbaikan wadah notifikasi mengambang agar tidak melampaui batas layar pada perangkat seluler sempit.
  - Optimalisasi dialog modal dengan input kustom `min-w-0` guna mencegah luapan horizontal pada ponsel.
- Penyesuaian informasi pembuat link pada kartu daftar untuk menampilkan nama pengguna dan OPD, serta menyembunyikan keterangan OPD khusus akun administrator.

## [1.3.0] - 2026-10-29

### Ditambahkan
- Dukungan pengubahan kode tautan (kustom slug) pada formulir modal edit tautan.
- Modal pratinjau kode QR dinamis disertai tombol unduh berkas SVG langsung pada daftar tautan.
- Banner metadata media resmi `images/meta.png` untuk pratinjau OpenGraph dan Twitter Card pada seluruh halaman.
- Aksesor `display_short_url` dan `display_original_url` pada model `ShortUrl` untuk menyederhanakan tampilan alamat URL tanpa awalan protokol `https://`.
- Konfigurasi pelokalan bahasa Indonesia secara menyeluruh pada aplikasi dan pustaka waktu Carbon.

### Diubah
- Kolom judul tautan (`title`) pada tabel `short_urls` dijadikan opsional melalui migrasi skema basis data baru.
- Penyatuan halaman operasional pengguna terautentikasi ke rute kelola tautan (`/urls`) serta penghapusan rute dan tampilan dasbor redundan.
- Pemadatan tata letak halaman utama (*landing page*) menjadi satu layar penuh tanpa kebutuhan gulir (*scroll*) pada layar standar.
- Standardisasi identitas *branding* di seluruh antarmuka: penggunaan entitas `Diskominfo-SP Sinjai` pada footer dan meta author, serta lockup resmi logo Kabupaten Sinjai.
- Penataan halaman login akun ENIKDA menjadi lebih bersih dengan fokus logo mandiri terpusat.

## [1.2.0] - 2026-10-28

### Ditambahkan
- Kolom `username` pada tabel `users` khusus administrator lokal tanpa ketergantungan email.
- Banner alert kendala autentikasi pada formulir login dengan ikon bahaya dan penanda batas warna kontras.
- Tombol toggle lihat dan sembunyikan password dengan dukungan aksesibilitas `aria-label`.
- Penanganan sesi kendala `session('error')` pada komponen notifikasi mengambang (floating toast).

### Diubah
- Alur autentikasi login kini menggunakan NIP untuk ASN dan Username untuk Administrator, serta menghapus ketergantungan kolom email.
- Halaman login diperbarui menjadi Login Akun ENIKDA dengan kolom NIP (autofokus) dan Password tanpa kotak centang simpan sesi.
- Halaman muka publik disederhanakan menjadi tampilan satu layar fokus tanpa kartu pemasaran bertumpuk.
- Standardisasi pesan kegagalan autentikasi menjadi lugas dan definitif: "NIP atau Password salah."
- Batas prasyarat PHP pada composer.json disesuaikan menjadi ^8.4.1.

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
