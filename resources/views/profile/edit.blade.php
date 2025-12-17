@extends('adminlte::page')

@section('title', 'Edit Profil')

@section('content_header')
    <h1>Edit Profil</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Form Edit Profil</h3>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <!-- Profile Photo -->
                    <div class="col-md-4">
                        <div class="form-group text-center">
                            <label>Foto Profil</label>
                            <div class="mb-3">
                                @if($user->foto_profil)
                                    <img id="preview-image" 
                                         src="{{ asset('storage/' . $user->foto_profil) }}" 
                                         alt="Profile Photo" 
                                         class="img-fluid img-circle"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                                @else
                                    <img id="preview-image" 
                                         src="{{ asset('vendor/adminlte/dist/img/user4-128x128.jpg') }}" 
                                         alt="Profile Photo" 
                                         class="img-fluid img-circle"
                                         style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                                @endif
                            </div>
                            
                            <input type="file" name="foto_profil" id="foto_profil" 
                                   class="form-control-file @error('foto_profil') is-invalid @enderror" 
                                   accept="image/*" onchange="previewImage(this)">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @error('foto_profil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($user->foto_profil)
                                <div class="mt-2">
                                    <form action="{{ route('profile.photo.delete') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Yakin ingin menghapus foto profil?')">
                                            <i class="fas fa-trash"></i> Hapus Foto
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') ?? $user->name }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') ?? $user->email }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                                    <small class="form-text text-muted">Role tidak dapat diubah</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Bergabung</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $user->created_at->format('d F Y') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('profile.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
@stop

@section('css')
    <style>
        .card-header {
            background-color: #007bff !important;
        }
        .card-title.text-white {
            color: white !important;
        }
        .img-circle {
            border-radius: 50% !important;
        }
    </style>
@stop

@section('js')
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@stop