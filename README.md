# PBP Kelompok 8 – Project

## Teknologi Utama
- Laravel (Blade Templates)
- PHP
- MySQL/MariaDB
- Vite (untuk build aset frontend)

---

## Prasyarat

Pastikan perangkat Anda sudah terpasang:
- PHP 8.4 beserta extension umum:
  - OpenSSL, PDO, Mbstring, Tokenizer, JSON, Ctype, BCMath, Fileinfo
- Composer 2.7
- MySQL 5.7+
- Node.js 18+
- NPM 9+
- Git

Cek versi cepat:
```bash
php -v
composer -V
node -v
npm -v
mysql --version
```

---

## Setup

1) Clone repository
```bash
git clone https://github.com/aribtm94/PBP_KELOMPOK-8_PROJECT.git
cd PBP_KELOMPOK-8_PROJECT
```

2) Duplikasi file environment
```bash
cp .env.example .env
```

3) Konfigurasi database di file .env
- Buat database kosong di MySQL/MariaDB, contoh: pbp_kel8
- Edit nilai berikut pada `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gayakuid
DB_USERNAME=root
DB_PASSWORD=
```

4) Install dependency PHP
```bash
composer install
```

5) Generate application key
```bash
php artisan key:generate
```

6) Jalankan migrasi dan seeder
```bash
php artisan migrate --seed
```

7) Install dependency frontend dan build frontend
```bash
npm install
npm run build
```

8) Jalankan server Laravel
```bash
php artisan serve
```

## Perintah Umum yang Berguna

- Clear cache konfigurasi/route/view:
```bash
php artisan optimize:clear
```

- Membuat symbolic link storage:
```bash
php artisan storage:link
```

---

## Troubleshooting

- APP_KEY missing:
  - Jalankan `php artisan key:generate` kemudian reload aplikasi.

- Error koneksi database (SQLSTATE[HY000] [1049] Unknown database):
  - Pastikan database sudah dibuat dan nama/username/password di `.env` benar.
  - Jalankan `php artisan migrate`.

- Ekstensi PHP tidak tersedia:
  - Pastikan extension seperti `pdo_mysql`, `mbstring`, `fileinfo` aktif. Install/aktifkan via package manager OS Anda atau `php.ini`.

- Port sudah digunakan:
  - Ubah port Laravel: `php artisan serve --host=127.0.0.1 --port=8001`
  - Untuk Vite, hentikan proses lain atau ubah konfigurasi port (lihat `vite.config.js` jika ada).

- Aset frontend tidak termuat di produksi:
  - Jalankan `npm run build`, lalu pastikan `APP_URL` di `.env` benar.
  - Jika menggunakan `php artisan route:cache`, lakukan `php artisan optimize:clear` setelah perubahan.

---

## Struktur Kredensial/Dataset Contoh

Jika proyek ini menyertakan seeder untuk membuat akun default (mis. admin/user demo), periksa:
- `database/seeders/*`
- Dokumentasi internal pada file atau komentar kode

Jalankan:
```bash
php artisan db:seed
```
Lalu cek tabel users untuk kredensial yang dibuat.

---

## Kontribusi

Pull Request dan Issue dipersilakan:
- Fork repo ini
- Buat branch fitur/fix Anda: `git checkout -b feature/nama-fitur`
- Commit perubahan: `git commit -m "feat: deskripsi singkat"`
- Push branch: `git push origin feature/nama-fitur`
- Buka Pull Request di GitHub

---

## Lisensi

Jika belum ditentukan, tambahkan lisensi yang diinginkan pada file LICENSE. Misal MIT.

---

## Ringkasan Step-by-Step Singkat

1. Clone repo
2. `cp .env.example .env` dan set DB di `.env`
3. `composer install`
4. `php artisan key:generate`
5. `php artisan migrate` (opsional `db:seed`)
6. `npm install` lalu `npm run dev`
7. `php artisan serve`

Jika Anda ingin, kami bisa membantu membuatkan PR untuk menambahkan README ini ke repository.
