@extends('adminlte::page')

@section('title', 'Jadwal Posyandu')

@section('content_header')
    <h1>Jadwal Posyandu</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Jadwal Posyandu</h3>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="card-tools">
                <a href="{{ route('jadwal_posyandu.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Jadwal
                </a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <form method="GET" action="{{ route('jadwal_posyandu.index') }}" class="mb-3">
                <div class="row">
                    <!-- FILTER POSYANDU -->
                    <div class="col-md-3">
                        <select name="posyandu_id" class="form-select">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandus as $posyandu)
                                <option value="{{ $posyandu->posyandu_id }}" {{ request('posyandu_id') == $posyandu->posyandu_id ? 'selected' : '' }}>
                                    {{ $posyandu->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- FILTER TANGGAL DARI -->
                    <div class="col-md-2">
                        <input type="date" name="tanggal_dari" class="form-control" 
                               value="{{ request('tanggal_dari') }}" 
                               placeholder="Tanggal Dari">
                    </div>
                    
                    <!-- FILTER TANGGAL SAMPAI -->
                    <div class="col-md-2">
                        <input type="date" name="tanggal_sampai" class="form-control" 
                               value="{{ request('tanggal_sampai') }}" 
                               placeholder="Tanggal Sampai">
                    </div>
                    
                    <!-- SEARCH INPUT -->
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari tema, keterangan, atau posyandu..." 
                                   aria-label="Search">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                            
                            <!-- CLEAR SEARCH BUTTON -->
                            @if(request('search'))
                                <a href="{{ request()->fullUrlWithQuery(['search'=> null]) }}" 
                                   class="btn btn-outline-secondary" 
                                   title="Hapus pencarian">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- BUTTONS -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
                
                <!-- RESET BUTTON -->
                @if(request('posyandu_id') || request('tanggal_dari') || request('tanggal_sampai') || request('search'))
                <div class="row mt-2">
                    <div class="col-md-12">
                        <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fa fa-refresh"></i> Reset Filter
                        </a>
                    </div>
                </div>
                @endif
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Posyandu</th>
                            <th>Tanggal</th>
                            <th>Tema</th>
                            <th>Poster</th>
                            <th>Keterangan</th>
                            <th width="150" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($jadwals as $item)
                        <tr>
                            <td>{{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->posyandu->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->tema }}</td>
                            <td class="text-center">
                                @if($item->poster_kegiatan)
                                    <img src="{{ asset('storage/' . $item->poster_kegiatan) }}" 
                                         alt="Poster Kegiatan" 
                                         class="img-thumbnail"
                                         style="width: 50px; height: 50px; object-fit: cover; cursor: pointer;"
                                         onclick="showPosterModal('{{ asset('storage/' . $item->poster_kegiatan) }}', '{{ $item->tema }}')">
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-image"></i><br>
                                        <small>Tidak ada</small>
                                    </span>
                                @endif
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('jadwal_posyandu.show', $item->jadwal_id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <a href="{{ route('jadwal_posyandu.edit', $item->jadwal_id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('jadwal_posyandu.destroy', $item->jadwal_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fa fa-database fa-2x mb-2"></i><br>
                                Tidak ada data jadwal posyandu
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
                {{ $jadwals->withQueryString()->links('pagination.custom') }}
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan poster -->
    <div class="modal fade" id="posterModal" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="posterModalLabel">Poster Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPosterImage" src="" alt="Poster Kegiatan" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <a id="downloadPoster" href="" download class="btn btn-primary">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-header {
            border-bottom: none;
            background-color: #007bff !important;
        }
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 8px;
        }
        .btn-group {
            gap: 4px;
        }
        .btn-group .btn {
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            transition: all 0.3s ease;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-group form {
            display: inline;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            transition: all 0.3s ease;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(248, 250, 252, 0.8);
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);
            border-radius: 8px;
        }
        .form-select, .form-control {
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
        .form-select:focus, .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 6px;
            color: white;
        }
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            color: #155724;
        }
        .img-thumbnail {
            border: 2px solid #007bff;
            transition: transform 0.3s ease;
        }
        .img-thumbnail:hover {
            transform: scale(1.1);
        }
    </style>
@stop

@section('js')
    <script>
        function showPosterModal(imageSrc, title) {
            $('#modalPosterImage').attr('src', imageSrc);
            $('#posterModalLabel').text('Poster: ' + title);
            $('#downloadPoster').attr('href', imageSrc);
            $('#posterModal').modal('show');
        }
    </script>
@stop