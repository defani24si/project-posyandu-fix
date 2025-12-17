@extends('adminlte::page')

@section('title', 'Edit Catatan Imunisasi')

@section('content_header')
    <h1>Edit Catatan Imunisasi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Form Edit Catatan Imunisasi</h3>
        </div>
        <form action="{{ route('catatan-imunisasi.update', $catatanImunisasi->imunisasi_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warga_id">Warga <span class="text-danger">*</span></label>
                            <select name="warga_id" id="warga_id" class="form-control @error('warga_id') is-invalid @enderror" required>
                                <option value="">Pilih Warga</option>
                                @foreach($warga as $item)
                                    <option value="{{ $item->warga_id }}" 
                                        {{ (old('warga_id') ?? $catatanImunisasi->warga_id) == $item->warga_id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_vaksin">Jenis Vaksin <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_vaksin" id="jenis_vaksin" class="form-control @error('jenis_vaksin') is-invalid @enderror" 
                                   value="{{ old('jenis_vaksin') ?? $catatanImunisasi->jenis_vaksin }}" placeholder="Contoh: BCG, DPT, Polio, Campak" required>
                            @error('jenis_vaksin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal">Tanggal Imunisasi <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                   value="{{ old('tanggal') ?? ($catatanImunisasi->tanggal ? $catatanImunisasi->tanggal->format('Y-m-d') : '') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lokasi">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                                   value="{{ old('lokasi') ?? $catatanImunisasi->lokasi }}" placeholder="Contoh: Puskesmas, Posyandu, Rumah Sakit" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nakes">Tenaga Kesehatan <span class="text-danger">*</span></label>
                            <input type="text" name="nakes" id="nakes" class="form-control @error('nakes') is-invalid @enderror" 
                                   value="{{ old('nakes') ?? $catatanImunisasi->nakes }}" placeholder="Nama dokter/bidan/perawat" required>
                            @error('nakes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kartu_imunisasi_scan">Scan Kartu Imunisasi</label>
                            <input type="file" name="kartu_imunisasi_scan" id="kartu_imunisasi_scan" 
                                   class="form-control-file @error('kartu_imunisasi_scan') is-invalid @enderror" 
                                   accept="image/*">
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            @if($catatanImunisasi->kartu_imunisasi_scan)
                                <div class="mt-2">
                                    <small class="text-info">File saat ini: 
                                        <a href="{{ asset('storage/' . $catatanImunisasi->kartu_imunisasi_scan) }}" target="_blank">
                                            Lihat file
                                        </a>
                                    </small>
                                </div>
                            @endif
                            @error('kartu_imunisasi_scan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Update
                </button>
                <a href="{{ route('catatan-imunisasi.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
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
    </style>
@stop