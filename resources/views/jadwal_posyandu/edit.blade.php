@extends('adminlte::page')

@section('title', 'Edit Jadwal Posyandu')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-edit text-primary"></i>
                Edit Jadwal Posyandu
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jadwal_posyandu.index') }}">Jadwal Posyandu</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan pada form:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title text-white mb-0">
                <i class="fas fa-edit mr-2"></i>
                Form Edit Jadwal Posyandu
            </h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('jadwal_posyandu.update', $jadwalPosyandu->jadwal_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Pilih Posyandu -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="posyandu_id">
                                <i class="fas fa-hospital-user text-primary mr-1"></i>
                                Posyandu <span class="text-danger">*</span>
                            </label>
                            <select name="posyandu_id" id="posyandu_id" class="form-control @error('posyandu_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Posyandu --</option>
                                @foreach($posyandus as $posyandu)
                                    <option value="{{ $posyandu->posyandu_id }}"
                                        {{ old('posyandu_id', $jadwalPosyandu->posyandu_id) == $posyandu->posyandu_id ? 'selected' : '' }}>
                                        {{ $posyandu->nama }} (RT {{ $posyandu->rt }}/RW {{ $posyandu->rw }})
                                    </option>
                                @endforeach
                            </select>
                            @error('posyandu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal">
                                <i class="fas fa-calendar text-primary mr-1"></i>
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal" id="tanggal" 
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', $jadwalPosyandu->tanggal) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tema -->
                <div class="form-group">
                    <label for="tema">
                        <i class="fas fa-tag text-primary mr-1"></i>
                        Tema <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="tema" id="tema" 
                           class="form-control @error('tema') is-invalid @enderror"
                           value="{{ old('tema', $jadwalPosyandu->tema) }}" 
                           placeholder="Masukkan tema kegiatan posyandu" required>
                    @error('tema')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">
                        <i class="fas fa-info-circle text-primary mr-1"></i>
                        Keterangan
                    </label>
                    <textarea name="keterangan" id="keterangan" 
                              class="form-control @error('keterangan') is-invalid @enderror" 
                              rows="4" placeholder="Masukkan keterangan tambahan (opsional)">{{ old('keterangan', $jadwalPosyandu->keterangan) }}</textarea>
                    @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Poster Kegiatan -->
                <div class="form-group">
                    <label for="poster_kegiatan">
                        <i class="fas fa-image text-primary mr-1"></i>
                        Poster Kegiatan
                    </label>
                    
                    @if($jadwalPosyandu->poster_kegiatan)
                        <div class="mb-3">
                            <div class="card" style="max-width: 300px;">
                                <img src="{{ asset('storage/' . $jadwalPosyandu->poster_kegiatan) }}" 
                                     alt="Poster Saat Ini" 
                                     class="card-img-top"
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <small class="text-muted">Poster saat ini</small>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="deletePoster({{ $jadwalPosyandu->jadwal_id }})">
                                            <i class="fas fa-trash"></i> Hapus Poster
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <input type="file" name="poster_kegiatan" id="poster_kegiatan" 
                           class="form-control-file @error('poster_kegiatan') is-invalid @enderror" 
                           accept="image/*" onchange="previewPoster(this)">
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle"></i>
                        Format: JPG, PNG, GIF. Maksimal 2MB
                    </small>
                    @error('poster_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Preview -->
                    <div id="posterPreview" class="mt-3" style="display: none;">
                        <div class="card" style="max-width: 300px;">
                            <img id="previewImage" src="" alt="Preview Poster" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <small class="text-muted">Preview poster baru</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Jadwal
                    </button>
                    <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Form untuk delete poster (hidden) -->
    <form id="deletePosterForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('css')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            border-bottom: none;
        }
        
        .form-group label {
            font-weight: 600;
            color: #495057;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@stop

@section('js')
<script>
function previewPoster(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('posterPreview').style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function deletePoster(jadwalId) {
    if (confirm('Yakin ingin menghapus poster ini?')) {
        const form = document.getElementById('deletePosterForm');
        form.action = `/jadwal_posyandu/${jadwalId}/poster`;
        form.submit();
    }
}
</script>
@stop