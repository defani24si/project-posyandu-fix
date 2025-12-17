# Dokumentasi Implementasi Kode

## 1. Halaman Edit dan Tampilan Pagination User dengan Foto Profil

### A. Migration - Tambah Kolom Foto Profil
**File:** `database/migrations/2025_11_26_053328_add_foto_profil_to_users_table.php`

```php
// Baris 14-16
Schema::table('users', function (Blueprint $table) {
    $table->string('foto_profil')->nullable()->after('email');
});
```

### B. Model User - Update Fillable
**File:** `app/Models/User.php`

```php
// Baris 20-24
protected $fillable = [
    'name',
    'email',
    'password',
    'foto_profil',
];
```

### C. UserController - Upload Foto Profil
**File:** `app/Http/Controllers/UserController.php`

#### Index dengan Pagination (Baris 10-33)
```php
public function index(Request $request)
{
    $query = User::query();
    
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', "%{$searchTerm}%")
              ->orWhere('email', 'like', "%{$searchTerm}%");
        });
    }
    
    $users = $query->paginate(10)->withQueryString();
    
    return view('users.index', compact('users'));
}
```

#### Store - Upload Foto Profil (Baris 40-50)
```php
if ($request->hasFile('foto_profil')) {
    $file = $request->file('foto_profil');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('public/foto_profil', $filename);
    $data['foto_profil'] = 'foto_profil/' . $filename;
}
```

#### Update - Handle Foto Profil (Baris 85-99)
```php
// Handle foto profil upload
if ($request->hasFile('foto_profil')) {
    // Hapus foto lama jika ada
    if ($user->foto_profil && Storage::exists('public/' . $user->foto_profil)) {
        Storage::delete('public/' . $user->foto_profil);
    }
    
    $file = $request->file('foto_profil');
    $filename = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('public/foto_profil', $filename);
    $data['foto_profil'] = 'foto_profil/' . $filename;
} else {
    // Jika tidak ada file baru, tetap gunakan foto lama
    unset($data['foto_profil']);
}
```

### D. View User Index - Pagination & Foto Profil
**File:** `resources/views/users/index.blade.php`

#### Tampilan Foto Profil di Tabel (Baris 48-58)
```blade
<td class="text-center">
    @if($user->foto_profil)
        <img src="{{ Storage::url($user->foto_profil) }}" 
             alt="Foto Profil" 
             class="img-circle img-size-50"
             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
    @else
        <div class="img-circle img-size-50 bg-secondary d-flex align-items-center justify-content-center" 
             style="width: 50px; height: 50px; border-radius: 50%;">
            <i class="fa fa-user text-white"></i>
        </div>
    @endif
</td>
```

#### Pagination (Baris 108-110)
```blade
<div class="card-footer clearfix">
    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
</div>
```

### E. View User Edit - Form Foto Profil
**File:** `resources/views/users/edit.blade.php`

#### Form Upload Foto Profil (Baris 30-48)
```blade
<div class="form-group">
    <label for="foto_profil">Foto Profil</label>
    <div class="mb-2">
        @if($user->foto_profil)
            <div class="mb-2">
                <p>Foto Profil Saat Ini:</p>
                <img src="{{ Storage::url($user->foto_profil) }}" 
                     alt="Foto Profil" 
                     class="img-thumbnail"
                     style="max-width: 200px; max-height: 200px; object-fit: cover;">
            </div>
        @else
            <p class="text-muted">Belum ada foto profil</p>
        @endif
    </div>
    <input type="file" name="foto_profil" id="foto_profil" class="form-control" 
           accept="image/jpeg,image/png,image/jpg,image/gif">
    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
    @error('foto_profil')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
```

---

## 2. Halaman Edit dan Form Tampilan Detail Pelanggan (Posyandu) dengan Multiple File Upload

### A. Migration - Tambah Kolom Files
**File:** `database/migrations/2025_11_26_053350_add_files_to_posyandu_table.php`

```php
// Baris 14-16
Schema::table('posyandu', function (Blueprint $table) {
    $table->text('files')->nullable()->after('kontak');
});
```

### B. Model Posyandu - Update Fillable
**File:** `app/Models/Posyandu.php`

```php
// Baris 18-20
protected $fillable = [
    'nama', 'alamat', 'rt', 'rw', 'kontak', 'files'
];
```

### C. PosyanduController - Multiple File Upload
**File:** `app/Http/Controllers/PosyanduController.php`

#### Store - Multiple File Upload (Baris 54-67)
```php
// Handle multiple file uploads
if ($request->hasFile('files')) {
    $uploadedFiles = [];
    foreach ($request->file('files') as $file) {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/posyandu_files', $filename);
        $uploadedFiles[] = [
            'name' => $file->getClientOriginalName(),
            'path' => 'posyandu_files/' . $filename,
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
        ];
    }
    $data['files'] = json_encode($uploadedFiles);
} else {
    $data['files'] = null;
}
```

#### Update - Handle Multiple Files dengan Delete (Baris 106-130)
```php
// Handle multiple file uploads
$existingFiles = $posyandu->files ? json_decode($posyandu->files, true) : [];

// Hapus file yang dipilih untuk dihapus
if ($request->has('delete_files')) {
    foreach ($request->delete_files as $fileToDelete) {
        if (Storage::exists('public/' . $fileToDelete)) {
            Storage::delete('public/' . $fileToDelete);
        }
        $existingFiles = array_filter($existingFiles, function($file) use ($fileToDelete) {
            return $file['path'] !== $fileToDelete;
        });
    }
    $existingFiles = array_values($existingFiles); // Re-index array
}

// Tambah file baru
if ($request->hasFile('files')) {
    foreach ($request->file('files') as $file) {
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/posyandu_files', $filename);
        $existingFiles[] = [
            'name' => $file->getClientOriginalName(),
            'path' => 'posyandu_files/' . $filename,
            'size' => $file->getSize(),
            'type' => $file->getMimeType(),
        ];
    }
}

$data['files'] = !empty($existingFiles) ? json_encode($existingFiles) : null;
```

### D. View Posyandu Edit - Multiple File Upload Form
**File:** `resources/views/posyandu/edit.blade.php`

#### Form Multiple File Upload dengan Delete Option (Baris 20-60)
```blade
<!-- Multiple File Upload Section -->
<div class="form-group">
    <label>Dokumen/Files</label>
    
    <!-- Existing Files -->
    @if($posyandu->files)
        @php
            $files = json_decode($posyandu->files, true);
        @endphp
        @if(is_array($files) && count($files) > 0)
            <div class="mb-3">
                <p class="mb-2"><strong>File yang sudah diupload:</strong></p>
                <div class="list-group">
                    @foreach($files as $index => $file)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fa fa-file"></i> 
                                <a href="{{ Storage::url($file['path']) }}" target="_blank" class="ml-2">
                                    {{ $file['name'] }}
                                </a>
                                <small class="text-muted ml-2">
                                    ({{ number_format($file['size'] / 1024, 2) }} KB)
                                </small>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="delete_files[]" 
                                       value="{{ $file['path'] }}" 
                                       id="delete_file_{{ $index }}">
                                <label class="form-check-label text-danger" for="delete_file_{{ $index }}">
                                    Hapus
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
    
    <!-- Upload New Files -->
    <div class="mb-3">
        <label for="files">Upload File Baru (Multiple)</label>
        <input type="file" name="files[]" id="files" class="form-control" multiple
               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        <small class="form-text text-muted">
            Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5MB per file. Bisa upload multiple files.
        </small>
        @error('files.*')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>
```

### E. View Posyandu Show - Tampilan Detail Files
**File:** `resources/views/posyandu/show.blade.php`

#### Tampilan Multiple Files (Baris 33-56)
```blade
<tr>
    <th>Dokumen/Files</th>
    <td>
        @if($posyandu->files)
            @php
                $files = json_decode($posyandu->files, true);
            @endphp
            @if(is_array($files) && count($files) > 0)
                <div class="list-group">
                    @foreach($files as $file)
                        <div class="list-group-item">
                            <i class="fa fa-file"></i> 
                            <a href="{{ Storage::url($file['path']) }}" target="_blank" class="ml-2">
                                {{ $file['name'] }}
                            </a>
                            <small class="text-muted ml-2">
                                ({{ number_format($file['size'] / 1024, 2) }} KB)
                            </small>
                            <span class="badge badge-info ml-2">{{ $file['type'] ?? 'Unknown' }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <span class="text-muted">Tidak ada file</span>
            @endif
        @else
            <span class="text-muted">Tidak ada file</span>
        @endif
    </td>
</tr>
```

### F. Routes
**File:** `routes/web.php`

```php
// Baris 12
Route::resource('users', UserController::class);
```

---

## Ringkasan File yang Dibuat/Diupdate

### File Baru:
1. `database/migrations/2025_11_26_053328_add_foto_profil_to_users_table.php`
2. `database/migrations/2025_11_26_053350_add_files_to_posyandu_table.php`
3. `app/Http/Controllers/UserController.php`
4. `resources/views/users/index.blade.php`
5. `resources/views/users/edit.blade.php`
6. `resources/views/users/create.blade.php`
7. `resources/views/users/show.blade.php`

### File yang Diupdate:
1. `app/Models/User.php` - Tambah `foto_profil` di fillable
2. `app/Models/Posyandu.php` - Tambah `files` di fillable
3. `app/Http/Controllers/PosyanduController.php` - Tambah multiple file upload
4. `resources/views/posyandu/edit.blade.php` - Tambah form multiple file upload
5. `resources/views/posyandu/create.blade.php` - Tambah form multiple file upload
6. `resources/views/posyandu/show.blade.php` - Tampilkan multiple files
7. `routes/web.php` - Tambah route users

---

## Cara Menjalankan Migration

Jalankan perintah berikut untuk menjalankan migration:

```bash
php artisan migrate
```

Pastikan juga membuat symbolic link untuk storage:

```bash
php artisan storage:link
```

























