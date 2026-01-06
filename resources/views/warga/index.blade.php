@extends('adminlte::page')

@section('title', 'Data Warga')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-users text-primary"></i>
                Data Warga
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Warga</li>
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
                        Daftar Warga
                    </h3>
                </div>
                <div class="col-auto">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('warga.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Warga
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('warga.index') }}" class="bg-light p-3 rounded">
                        <div class="row align-items-end">
                            <!-- SEARCH -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label text-sm font-weight-bold">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari NIK, nama, alamat..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- FILTER RT -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter RT</label>
                                <select name="rt" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua RT</option>
                                    @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}" {{ request('rt') == str_pad($i, 3, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            RT {{ str_pad($i, 3, '0', STR_PAD_LEFT) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <!-- FILTER RW -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter RW</label>
                                <select name="rw" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua RW</option>
                                    @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}" {{ request('rw') == str_pad($i, 3, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                            RW {{ str_pad($i, 3, '0', STR_PAD_LEFT) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            
                            <!-- FILTER JENIS KELAMIN -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua JK</option>
                                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            
                            <!-- RESET -->
                            <div class="col-md-2 mb-2">
                                <a href="{{ route('warga.index') }}" class="btn btn-secondary btn-sm btn-block">
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
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Warga</span>
                            <span class="info-box-number">{{ $warga->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-male"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Laki-laki</span>
                            <span class="info-box-number">{{ $warga->filter(function($item) { return $item->jenis_kelamin == 'L'; })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-female"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Perempuan</span>
                            <span class="info-box-number">{{ $warga->filter(function($item) { return $item->jenis_kelamin == 'P'; })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-phone"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Punya Telepon</span>
                            <span class="info-box-number">{{ $warga->filter(function($item) { return !empty($item->no_telepon); })->count() }}</span>
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
                            <th width="15%">
                                <i class="fas fa-id-card mr-1"></i>
                                NIK
                            </th>
                            <th width="20%">
                                <i class="fas fa-user mr-1"></i>
                                Nama
                            </th>
                            <th width="20%">
                                <i class="fas fa-birthday-cake mr-1"></i>
                                Tempat, Tgl Lahir
                            </th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-venus-mars mr-1"></i>
                                JK
                            </th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-home mr-1"></i>
                                RT/RW
                            </th>
                            <th width="15%">
                                <i class="fas fa-phone mr-1"></i>
                                No. Telepon
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-cogs mr-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($warga as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    {{ ($warga->currentPage() - 1) * $warga->perPage() + $index + 1 }}
                                </td>
                                <td>
                                    <small class="text-muted">{{ $item->nik }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $item->nama }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $item->tempat_lahir }}, {{ $item->tanggal_lahir->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'info' }}">
                                        {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary">RT {{ $item->rt }}</span>
                                    <span class="badge badge-info">RW {{ $item->rw }}</span>
                                </td>
                                <td>
                                    @if($item->no_telepon)
                                        <a href="tel:{{ $item->no_telepon }}" class="text-decoration-none">
                                            <i class="fas fa-phone text-success mr-1"></i>
                                            {{ $item->no_telepon }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- TOMBOL SHOW/DETAIL -->
                                        <a href="{{ route('warga.show', $item->warga_id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                        <!-- TOMBOL EDIT - Hanya untuk Admin -->
                                        <a href="{{ route('warga.edit', $item->warga_id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- TOMBOL DELETE - Hanya untuk Admin -->
                                        <form action="{{ route('warga.destroy', $item->warga_id) }}" 
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
                                <td colspan="8" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada data warga</h5>
                                        <p class="mb-0">
                                            @if(request()->hasAny(['search', 'rt', 'rw', 'jenis_kelamin']))
                                                Tidak ditemukan warga dengan kriteria pencarian tersebut.
                                                <br>
                                                <a href="{{ route('warga.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                                </a>
                                            @else
                                                Belum ada data warga yang tersedia.
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <br>
                                                <a href="{{ route('warga.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Warga Pertama
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
        @if($warga->hasPages())
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $warga->firstItem() }} - {{ $warga->lastItem() }} 
                        dari {{ $warga->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $warga->withQueryString()->links('pagination::bootstrap-4') }}
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