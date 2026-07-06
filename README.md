Nama: Salwa Faiha NIM: 101230115 Kelas: TF23C

# Teras Coklat — Loyalty Program

Sebuah aplikasi PHP sederhana untuk program loyalitas "Teras Coklat".

## Ringkasan
- Platform: PHP (jalankan lewat XAMPP / Apache)
- Database: MySQL (lihat `config/database.php`)

## Menjalankan secara lokal
1. Salin folder projek ke `htdocs` XAMPP (mis. `c:\xampp\htdocs\es_coklat`).
2. Mulai Apache dan MySQL lewat XAMPP Control Panel.
3. Buka browser ke `http://localhost/es_coklat`.

## Struktur penting
- Entry point: `index.php`
- Konfigurasi database: `config/database.php`
- Endpoint proses: `includes/proses.php`
- Cache token QR: `cache/qr_token.json`

## Menjalankan pengecekan sintaks (lokal)
Jalankan perintah berikut di direktori proyek untuk memeriksa sintaks PHP secara cepat:

```bash
find . -type f -name "*.php" -not -path "./vendor/*" -print0 | xargs -0 -n1 -P4 -I{} php -l {}
```

Pada Windows (PowerShell) gunakan:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

## CI / Tes di GitHub
Saya menambahkan workflow GitHub Actions yang menjalankan pengecekan sintaks PHP otomatis pada push dan pull request.
File workflow: `.github/workflows/php-lint.yml`.

Setelah Anda mendorong (push) perubahan ke repository GitHub, Actions akan berjalan otomatis dan menunjukkan hasil linting.

## Catatan
- Aplikasi ini dibuat sederhana tanpa dependency manager (no Composer). Workflow hanya melakukan pengecekan sintaks.
- Jika Anda ingin saya melakukan commit dan push ke remote, beri tahu repositori remote atau izinkan saya melakukan push dari lingkungan ini.

---
Terima kasih — beri tahu saya jika ingin menambahkan PHPUnit atau tes lebih lengkap.

