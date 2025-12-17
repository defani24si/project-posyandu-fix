@extends('adminlte::page')

@section('title', 'Create Posyandu')

@section('content_header')
    <h1>Create Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('posyandu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('posyandu.partials.form')
                
                <!-- Multiple File Upload Section -->
                <div class="form-group">
                    <label for="files">Upload Dokumen/Files (Multiple)</label>
                    <input type="file" name="files[]" id="files" class="form-control" multiple
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <small class="form-text text-muted">
                        Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5MB per file. Bisa upload multiple files.
                    </small>
                    @error('files.*')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('posyandu.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@stop