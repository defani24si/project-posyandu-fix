@extends('adminlte::page')

@section('title', 'Edit Jadwal Posyandu')

@section('content_header')
    <h1>Edit Jadwal Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('jadwal_posyandu.update', $jadwalPosyandu->jadwal_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Pilih Posyandu -->
                <div class="form-group">
                    <label for="posyandu_id">Posyandu</label>
                    <select name="posyandu_id" class="form-control" required>
                        <option value="">-- Pilih Posyandu --</option>
                        @foreach($posyandus as $posyandu)
                            <option value="{{ $posyandu->posyandu_id }}"
                                {{ $jadwalPosyandu->posyandu_id == $posyandu->posyandu_id ? 'selected' : '' }}>
                                {{ $posyandu->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $jadwalPosyandu->tanggal) }}" required>
                </div>

                <!-- Tema -->
                <div class="form-group">
                    <label for="tema">Tema</label>
                    <input type="text" name="tema" class="form-control"
                        value="{{ old('tema', $jadwalPosyandu->tema) }}" required>
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ old('keterangan', $jadwalPosyandu->keterangan) }}</textarea>
                </div>

                <!-- Poster Kegiatan -->
                <div class="form-group">
                    <label for="poster_kegiatan">Poster Kegiatan</label>
                    
                    @if($jadwalPosyandu->poster_kegiatan)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $jadwalPosyandu->poster_kegiatan) }}" 
                                 alt="Poster Saat Ini" 
                                 class="img-thumbnail"
                                 style="max-width: 200px; max-height: 200px;">
                            <div class="mt-2">
                                <form action="{{ route('jadwal_posyandu.poster.delete', $jadwalPosyandu->jadwal_id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Yakin ingin menghapus poster?')">
                                        <i class="fas fa-trash"></i> Hapus Poster
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    
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

                <button type="submit" class="btn btn-primary">Update</button>
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