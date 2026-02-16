# Server Setup Instructions

## Konfigurasi Upload di Server

### Opsi 1: Menggunakan Symlink (Recommended untuk VPS/Dedicated Server)

Jalankan perintah ini di server:

```bash
php artisan storage:link
```

Ini akan membuat symlink `public/storage` → `storage/app/public`.

File upload akan disimpan di `storage/app/public/` dan bisa diakses via `/storage/...`.

### Opsi 2: Untuk Shared Hosting (public_html)

Jika server menggunakan `public_html` sebagai document root dan symlink tidak berfungsi:

1. **Buat folder storage di public_html:**
   ```bash
   mkdir -p public_html/storage
   mkdir -p public_html/storage/properties
   mkdir -p public_html/storage/avatars
   mkdir -p public_html/storage/banners
   mkdir -p public_html/storage/articles
   mkdir -p public_html/storage/partners
   mkdir -p public_html/storage/testimonials
   ```

2. **Set permissions:**
   ```bash
   chmod -R 755 public_html/storage
   ```

3. **Tambahkan di .env:**
   ```env
   UPLOADS_ROOT=/home/username/public_html/storage
   ```
   
   Ganti `username` dengan username hosting Anda.

4. **Clear config cache:**
   ```bash
   php artisan config:clear
   ```

### Contoh Struktur Folder di Shared Hosting:

```
/home/username/
├── laravel-app/           # Semua file Laravel
│   ├── app/
│   ├── config/
│   ├── storage/
│   └── ...
└── public_html/           # Document root
    ├── index.php
    ├── storage/           # Folder upload gambar
    │   ├── properties/
    │   ├── avatars/
    │   └── ...
    └── ...
```

## Permissions

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Troubleshooting

Jika gambar 404:

1. Cek apakah symlink ada: `ls -la public/storage`
2. Cek apakah file ada di `storage/app/public/properties/`
3. Jalankan `php artisan storage:link`
4. Untuk shared hosting, pastikan `UPLOADS_ROOT` sudah benar
