@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
    <h1>Edit User</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="kader" {{ old('role', $user->role) == 'kader' ? 'selected' : '' }}>Kader</option>
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="foto_profil">Foto Profil</label>
                    <div class="mb-2">
                        @if($user->foto_profil)
                            <div class="mb-2">
                                <p>Foto Profil Saat Ini:</p>
                                <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                                     alt="Foto Profil" 
                                     class="img-thumbnail"
                                     style="max-width: 200px; max-height: 200px; object-fit: cover;"
                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <p class="text-danger" style="display:none;">Gagal memuat foto. Silakan upload ulang.</p>
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

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 6px;
        }
        .img-thumbnail {
            border-radius: 8px;
        }
    </style>
@stop

