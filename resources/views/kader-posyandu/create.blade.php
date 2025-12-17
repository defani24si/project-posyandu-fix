@extends('adminlte::page')

@section('title', 'Tambah Kader Posyandu')

@section('content_header')
    <h1>Tambah Kader Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Form Tambah Kader Posyandu</h3>
        </div>
        <form action="{{ route('kader-posyandu.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="posyandu_id">Posyandu <span class="text-danger">*</span></label>
                            <select name="posyandu_id" id="posyandu_id" class="form-control @error('posyandu_id') is-invalid @enderror" required>
                                <option value="">Pilih Posyandu</option>
                                @foreach($posyandu as $item)
                                    <option value="{{ $item->posyandu_id }}" {{ old('posyandu_id') == $item->posyandu_id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('posyandu_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warga_id">Warga <span class="text-danger">*</span></label>
                            <select name="warga_id" id="warga_id" class="form-control @error('warga_id') is-invalid @enderror" required>
                                <option value="">Pilih Warga</option>
                                @foreach($warga as $item)
                                    <option value="{{ $item->warga_id }}" {{ old('warga_id') == $item->warga_id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('warga_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="peran">Peran <span class="text-danger">*</span></label>
                            <input type="text" name="peran" id="peran" class="form-control @error('peran') is-invalid @enderror" 
                                   value="{{ old('peran') }}" placeholder="Contoh: Ketua, Sekretaris, Bendahara" required>
                            @error('peran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mulai_tugas">Mulai Tugas <span class="text-danger">*</span></label>
                            <input type="date" name="mulai_tugas" id="mulai_tugas" class="form-control @error('mulai_tugas') is-invalid @enderror" 
                                   value="{{ old('mulai_tugas') }}" required>
                            @error('mulai_tugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="akhir_tugas">Akhir Tugas</label>
                            <input type="date" name="akhir_tugas" id="akhir_tugas" class="form-control @error('akhir_tugas') is-invalid @enderror" 
                                   value="{{ old('akhir_tugas') }}">
                            <small class="form-text text-muted">Kosongkan jika masih aktif</small>
                            @error('akhir_tugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('kader-posyandu.index') }}" class="btn btn-secondary">
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