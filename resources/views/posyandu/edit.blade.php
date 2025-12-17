@extends('adminlte::page')

@section('title', 'Edit Posyandu')

@section('content_header')
    <h1>Edit Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('posyandu.update', $posyandu->posyandu_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posyandu.partials.form')
                
                <!-- Multiple File Upload Section -->
                <div class="form-group">
                    <label>Dokumen/Files</label>
                    
                    <!-- Existing Files -->
                    @if($posyandu->files)
                        @php
                            $files = json_decode($posyandu->files, true);
                        @endphp
                        @if(is_array($files) && count($files) > 0)
                            <div class="mb-3">
                                <p class="mb-2"><strong>File yang sudah diupload:</strong></p>
                                <div class="list-group">
                                    @foreach($files as $index => $file)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa fa-file"></i> 
                                                <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="ml-2">
                                                    {{ $file['name'] }}
                                                </a>
                                                <small class="text-muted ml-2">
                                                    ({{ number_format($file['size'] / 1024, 2) }} KB)
                                                </small>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="delete_files[]" 
                                                       value="{{ $file['path'] }}" 
                                                       id="delete_file_{{ $index }}">
                                                <label class="form-check-label text-danger" for="delete_file_{{ $index }}">
                                                    Hapus
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    <!-- Upload New Files -->
                    <div class="mb-3">
                        <label for="files">Upload File Baru (Multiple)</label>
                        <input type="file" name="files[]" id="files" class="form-control" multiple
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="form-text text-muted">
                            Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5MB per file. Bisa upload multiple files.
                        </small>
                        @error('files.*')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('posyandu.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@stop