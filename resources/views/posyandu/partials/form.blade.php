<div class="form-group">
    <label for="nama">Nama Posyandu</label>
    <input type="text" name="nama" id="nama" class="form-control" 
           value="{{ isset($posyandu) ? $posyandu->nama : old('nama') }}" required>
    @error('nama')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="alamat">Alamat</label>
    <input type="text" name="alamat" id="alamat" class="form-control" 
           value="{{ isset($posyandu) ? $posyandu->alamat : old('alamat') }}" required>
    @error('alamat')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="rt">RT</label>
            <input type="text" name="rt" id="rt" class="form-control" 
                   value="{{ isset($posyandu) ? $posyandu->rt : old('rt') }}" required>
            @error('rt')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="rw">RW</label>
            <input type="text" name="rw" id="rw" class="form-control" 
                   value="{{ isset($posyandu) ? $posyandu->rw : old('rw') }}" required>
            @error('rw')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="kontak">Kontak</label>
    <input type="text" name="kontak" id="kontak" class="form-control" 
           value="{{ isset($posyandu) ? $posyandu->kontak : old('kontak') }}" required>
    @error('kontak')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label for="foto">Foto Posyandu</label>
    @if(isset($posyandu) && $posyandu->foto)
        <div class="mb-2">
            <p>Foto Saat Ini:</p>
            <img src="{{ asset('storage/' . $posyandu->foto) }}" 
                 alt="Foto Posyandu" 
                 class="img-thumbnail"
                 style="max-width: 200px; max-height: 200px; object-fit: cover;"
                 onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
            <p class="text-danger" style="display:none;">Gagal memuat foto. Silakan upload ulang.</p>
        </div>
    @endif
    <input type="file" name="foto" id="foto" class="form-control" 
           accept="image/jpeg,image/png,image/jpg,image/gif">
    <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
    @error('foto')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>