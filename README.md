# Shortener Sinjaikab

Layanan pemendek tautan web resmi Pemerintah Kabupaten Sinjai berbasis domain s.sinjaikab.go.id. Sistem ini menyediakan manajemen tautan untuk Organisasi Perangkat Daerah dan generator kode QR dinamis.

## Prasyarat Sistem

- PHP 8.4.1 atau lebih baru (ekstensi: pdo, pdo_sqlite atau pdo_mysql, mbstring, openssl, xml)
- Composer 2.x
- Node.js 20 atau lebih baru dan npm

## Langkah Instalasi

1. Pasang dependensi PHP:
   ```bash
   composer install
   ```
2. Salin berkas lingkungan dan buat kunci aplikasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Jalankan migrasi basis data dan seeder awal:
   ```bash
   php artisan migrate --seed
   ```
4. Pasang dependensi frontend:
   ```bash
   npm install
   ```

## Perintah Operasional Utama

- Menjalankan server pengembangan:
  ```bash
  php artisan serve
  ```
- Menjalankan Vite development server:
  ```bash
  npm run dev
  ```
- Menjalankan pengujian otomatis:
  ```bash
  php artisan test
  ```
