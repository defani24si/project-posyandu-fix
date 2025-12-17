@extends('adminlte::page')

@section('title', 'Edit Layanan Posyandu')

@section('content_header')
    <h1>Edit Layanan Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Form Edit Layanan Posyandu</h3>
        </div>
        <form action="{{ route('layanan-posyandu.update', $layananPosyandu->layanan_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jadwal_id">Jadwal Posyandu <span class="text-danger">*</span></label>
                            <select name="jadwal_id" id="jadwal_id" class="form-control @error('jadwal_id') is-invalid @enderror" required>
                                <option value="">Pilih Jadwal</option>
                                @foreach($jadwal as $item)
                                    <option value="{{ $item->jadwal_id }}" 
                                        {{ (old('jadwal_id') ?? $layananPosyandu->jadwal_id) == $item->jadwal_id ? 'selected' : '' }}>
                                        {{ $item->posyandu->nama }} - {{ $item->tanggal }} ({{ $item->tema }})
                                    </option>
                                @endforeach
                            </select>
                            @error('jadwal_id')
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
                                    <option value="{{ $item->warga_id }}" 
                                        {{ (old('warga_id') ?? $layananPosyandu->warga_id) == $item->warga_id ? 'selected' : '' }}>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="berat">Berat Badan (kg)</label>
                            <input type="number" step="0.1" name="berat" id="berat" class="form-control @error('berat') is-invalid @enderror" 
                                   value="{{ old('berat') ?? $layananPosyandu->berat }}" placeholder="0.0">
                            @error('berat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tinggi">Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" name="tinggi" id="tinggi" class="form-control @error('tinggi') is-invalid @enderror" 
                                   value="{{ old('tinggi') ?? $layananPosyandu->tinggi }}" placeholder="0.0">
                            @error('tinggi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vitamin">Vitamin</label>
                            <input type="text" name="vitamin" id="vitamin" class="form-control @error('vitamin') is-invalid @enderror" 
                                   value="{{ old('vitamin') ?? $layananPosyandu->vitamin }}" placeholder="Jenis vitamin yang diberikan">
                            @error('vitamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="konseling">Konseling</label>
                            <textarea name="konseling" id="konseling" rows="4" class="form-control @error('konseling') is-invalid @enderror" 
                                      placeholder="Catatan konseling atau saran yang diberikan">{{ old('konseling') ?? $layananPosyandu->konseling }}</textarea>
                            @error('konseling')
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
                <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-secondary">
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