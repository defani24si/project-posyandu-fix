# Troubleshooting Foto Tidak Muncul

## Masalah yang Sudah Diperbaiki

### 1. Path URL Foto
**Masalah:** Menggunakan `Storage::url()` yang kadang tidak bekerja dengan benar
**Solusi:** Mengganti dengan `asset('storage/' . $path)` yang lebih reliable

### 2. Storage Link
**Masalah:** Symbolic link mungkin tidak dibuat dengan benar
**Solusi:** Sudah dibuat ulang dengan perintah `php artisan storage:link`

### 3. Direktori Penyimpanan
**Masalah:** Direktori untuk menyimpan foto mungkin belum ada
**Solusi:** Sudah dibuat direktori:
- `storage/app/public/foto_profil/` untuk foto profil user
- `storage/app/public/posyandu_files/` untuk file posyandu

### 4. Controller Data Handling
**Masalah:** Menggunakan `$request->all()` yang bisa menyebabkan konflik
**Solusi:** Mengganti dengan `$request->only()` untuk mengambil field spesifik

## Cara Menguji

1. **Upload Foto Profil User:**
   - Buka halaman Create User atau Edit User
   - Upload foto profil (format: JPG, PNG, GIF, maksimal 2MB)
   - Simpan
   - Foto seharusnya muncul di:
     - Halaman Index User (kolom Foto Profil)
     - Halaman Edit User (preview foto saat ini)
     - Halaman Show User (foto besar)

2. **Upload Multiple Files Posyandu:**
   - Buka halaman Create Posyandu atau Edit Posyandu
   - Upload multiple files (PDF, DOC, DOCX, JPG, PNG, maksimal 5MB per file)
   - Simpan
   - Files seharusnya muncul di:
     - Halaman Show Posyandu (daftar semua files)
     - Halaman Edit Posyandu (daftar files dengan opsi hapus)

## Jika Foto Masih Tidak Muncul

### 1. Cek Storage Link
```bash
php artisan storage:link
```

### 2. Cek Permissions (Linux/Mac)
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 3. Cek File Benar-benar Tersimpan
- Buka folder: `storage/app/public/foto_profil/`
- Pastikan file ada di sana

### 4. Cek URL di Browser
- Buka Developer Tools (F12)
- Lihat tab Network untuk melihat request gambar
- Cek apakah URL benar: `http://your-domain/storage/foto_profil/filename.jpg`

### 5. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 6. Cek Database
- Pastikan kolom `foto_profil` di tabel `users` berisi path yang benar
- Format: `foto_profil/filename.jpg` (tanpa `public/` atau `storage/`)

## Format Path yang Benar

### Di Database:
- User foto_profil: `foto_profil/1764135820_nama_file.jpg`
- Posyandu files: JSON string dengan path `posyandu_files/1764135820_nama_file.pdf`

### Di View:
- User: `{{ asset('storage/' . $user->foto_profil) }}`
- Posyandu: `{{ asset('storage/' . $file['path']) }}`

### Di Storage:
- User: `storage/app/public/foto_profil/1764135820_nama_file.jpg`
- Posyandu: `storage/app/public/posyandu_files/1764135820_nama_file.pdf`

## Perubahan yang Dilakukan

1. **resources/views/users/index.blade.php**
   - Mengganti `Storage::url()` dengan `asset('storage/' . ...)`

2. **resources/views/users/edit.blade.php**
   - Mengganti `Storage::url()` dengan `asset('storage/' . ...)`
   - Menambahkan error handling untuk gambar yang gagal dimuat

3. **resources/views/users/show.blade.php**
   - Mengganti `Storage::url()` dengan `asset('storage/' . ...)`
   - Menambahkan fallback jika gambar tidak ditemukan

4. **resources/views/posyandu/show.blade.php**
   - Mengganti `Storage::url()` dengan `asset('storage/' . ...)`

5. **resources/views/posyandu/edit.blade.php**
   - Mengganti `Storage::url()` dengan `asset('storage/' . ...)`

6. **app/Http/Controllers/UserController.php**
   - Mengganti `$request->all()` dengan `$request->only()` untuk menghindari konflik

























