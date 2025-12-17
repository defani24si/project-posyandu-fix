@extends('adminlte::page')

@section('title', 'Detail Posyandu')

@section('content_header')
    <h1>Detail Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center mb-3">
                    @if($posyandu->foto)
                        <img src="{{ asset('storage/' . $posyandu->foto) }}" 
                             alt="Foto Posyandu" 
                             class="img-thumbnail"
                             style="max-width: 250px; max-height: 250px; object-fit: cover; border-radius: 8px;"
                             onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 250px; height: 250px; border-radius: 8px; display:none;">
                            <i class="fa fa-building text-white" style="font-size: 80px;"></i>
                        </div>
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 250px; height: 250px; border-radius: 8px;">
                            <i class="fa fa-building text-white" style="font-size: 80px;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama Posyandu</th>
                    <td>{{ $posyandu->nama }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $posyandu->alamat }}</td>
                </tr>
                <tr>
                    <th>RT</th>
                    <td>{{ $posyandu->rt }}</td>
                </tr>
                <tr>
                    <th>RW</th>
                    <td>{{ $posyandu->rw }}</td>
                </tr>
                <tr>
                    <th>Kontak</th>
                    <td>{{ $posyandu->kontak }}</td>
                </tr>
                <tr>
                    <th>Dokumen/Files</th>
                    <td>
                        @if($posyandu->files)
                            @php
                                $files = json_decode($posyandu->files, true);
                            @endphp
                            @if(is_array($files) && count($files) > 0)
                                <div class="list-group">
                                    @foreach($files as $file)
                                        <div class="list-group-item">
                                            <i class="fa fa-file"></i> 
                                            <a href="{{ asset('storage/' . $file['path']) }}" target="_blank" class="ml-2">
                                                {{ $file['name'] }}
                                            </a>
                                            <small class="text-muted ml-2">
                                                ({{ number_format($file['size'] / 1024, 2) }} KB)
                                            </small>
                                            <span class="badge badge-info ml-2">{{ $file['type'] ?? 'Unknown' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                </tr>
            </table>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('posyandu.index') }}" class="btn btn-secondary">Kembali</a>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('posyandu.edit', $posyandu->posyandu_id) }}" class="btn btn-primary">Edit</a>
                @endif
            </div>
        </div>
    </div>
@stop