@extends('adminlte::page')

@section('title', 'Create Jadwal Posyandu')

@section('content_header')
    <h1>Create Jadwal Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('jadwal_posyandu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Pilih Posyandu -->
                <div class="form-group">
                    <label for="posyandu_id">Posyandu</label>
                    <select name="posyandu_id" class="form-control" required>
                        <option value="">-- Pilih Posyandu --</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->posyandu_id }}" {{ old('posyandu_id') == $posyandu->posyandu_id ? 'selected' : '' }}>
                                {{ $posyandu->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('posyandu_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                    @error('tanggal')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tema -->
                <div class="form-group">
                    <label for="tema">Tema</label>
                    <input type="text" name="tema" class="form-control" value="{{ old('tema') }}" required>
                    @error('tema')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Poster Kegiatan -->
                <div class="form-group">
                    <label for="poster_kegiatan">Poster Kegiatan</label>
                    <input type="file" name="poster_kegiatan" id="poster_kegiatan" 
                           class="form-control-file @error('poster_kegiatan') is-invalid @enderror" 
                           accept="image/*" onchange="previewPoster(this)">
                    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    @error('poster_kegiatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <!-- Preview -->
                    <div id="posterPreview" class="mt-3" style="display: none;">
                        <img id="previewImage" src="" alt="Preview Poster" 
                             class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
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
    </script>
@stop