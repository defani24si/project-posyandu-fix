@extends('adminlte::page')

@section('title', 'Data Posyandu')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-hospital-user text-primary"></i>
                Data Posyandu
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Posyandu</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-list mr-2"></i>
                        Daftar Posyandu
                    </h3>
                </div>
                <div class="col-auto">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('posyandu.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Posyandu
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('posyandu.index') }}" class="bg-light p-3 rounded">
                        <div class="row align-items-end">
                            <!-- FILTER RT -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter RT</label>
                                <select name="rt" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua RT</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" {{ request('rt') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            RT {{ sprintf('%02d', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <!-- FILTER RW -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter RW</label>
                                <select name="rw" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua RW</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" {{ request('rw') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            RW {{ sprintf('%02d', $i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <!-- SEARCH -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-sm font-weight-bold">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nama posyandu atau alamat..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- RESET -->
                            <div class="col-md-2 mb-2">
                                <a href="{{ route('posyandu.index') }}" class="btn btn-secondary btn-sm btn-block">
                                    <i class="fas fa-undo mr-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- STATISTICS CARDS -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-hospital-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Posyandu</span>
                            <span class="info-box-number">{{ $posyandus->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">RT Terlayani</span>
                            <span class="info-box-number">{{ $posyandus->pluck('rt')->unique()->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">RW Terlayani</span>
                            <span class="info-box-number">{{ $posyandus->pluck('rw')->unique()->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-phone"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kontak Aktif</span>
                            <span class="info-box-number">{{ $posyandus->whereNotNull('kontak')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-image mr-1"></i>
                                Foto
                            </th>
                            <th width="20%">
                                <i class="fas fa-hospital mr-1"></i>
                                Nama Posyandu
                            </th>
                            <th width="25%">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Alamat
                            </th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-home mr-1"></i>
                                RT/RW
                            </th>
                            <th width="15%">
                                <i class="fas fa-phone mr-1"></i>
                                Kontak
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-cogs mr-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posyandus as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    {{ ($posyandus->currentPage() - 1) * $posyandus->perPage() + $index + 1 }}
                                </td>
                                <td class="text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" 
                                             alt="Foto Posyandu" 
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'60\' height=\'60\'%3E%3Crect width=\'60\' height=\'60\' fill=\'%23e9ecef\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%236c757d\' font-size=\'12\'%3ENo Image%3C/text%3E%3C/svg%3E';">
                                    @else
                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-hospital-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $item->nama }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        {{ $item->alamat }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary">RT {{ $item->rt }}</span>
                                    <span class="badge badge-info">RW {{ $item->rw }}</span>
                                </td>
                                <td>
                                    <a href="tel:{{ $item->kontak }}" class="text-decoration-none">
                                        <i class="fas fa-phone text-success mr-1"></i>
                                        {{ $item->kontak }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- TOMBOL SHOW/DETAIL -->
                                        <a href="{{ route('posyandu.show', $item->posyandu_id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                        <!-- TOMBOL EDIT - Hanya untuk Admin -->
                                        <a href="{{ route('posyandu.edit', $item->posyandu_id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- TOMBOL DELETE - Hanya untuk Admin -->
                                        <form action="{{ route('posyandu.destroy', $item->posyandu_id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada data posyandu</h5>
                                        <p class="mb-0">
                                            @if(request()->hasAny(['search', 'rt', 'rw']))
                                                Tidak ditemukan posyandu dengan kriteria pencarian tersebut.
                                                <br>
                                                <a href="{{ route('posyandu.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                                </a>
                                            @else
                                                Belum ada data posyandu yang tersedia.
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <br>
                                                <a href="{{ route('posyandu.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Posyandu Pertama
                                                </a>
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- PAGINATION -->
        @if($posyandus->hasPages())
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $posyandus->firstItem() }} - {{ $posyandus->lastItem() }} 
                        dari {{ $posyandus->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $posyandus->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            border-bottom: none;
        }
        
        .info-box {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
        }
        
        .table td {
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        
        .btn-group .btn {
            border-radius: 4px !important;
            margin-right: 2px;
        }
        
        .btn-group .btn:last-child {
            margin-right: 0;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        
        .empty-state {
            padding: 2rem;
        }
        
        .form-label {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
        }
        
        .breadcrumb {
            background: none;
            padding: 0;
            margin: 0;
        }
        
        .breadcrumb-item + .breadcrumb-item::before {
            color: #6c757d;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@stop