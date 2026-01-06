@extends('adminlte::page')

@section('title', 'Layanan Posyandu')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-hand-holding-medical text-primary"></i>
                Data Layanan Posyandu
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Layanan Posyandu</li>
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
                        Daftar Layanan Posyandu
                    </h3>
                </div>
                <div class="col-auto">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('layanan-posyandu.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Layanan
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('layanan-posyandu.index') }}" class="bg-light p-3 rounded">
                        <div class="row align-items-end">
                            <!-- SEARCH -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label text-sm font-weight-bold">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nama warga, posyandu, vitamin..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- FILTER POSYANDU -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter Posyandu</label>
                                <select name="posyandu_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua Posyandu</option>
                                    @foreach($posyandu as $item)
                                        <option value="{{ $item->posyandu_id }}" {{ request('posyandu_id') == $item->posyandu_id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- FILTER VITAMIN -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter Vitamin</label>
                                <select name="vitamin" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua Vitamin</option>
                                    <option value="ada" {{ request('vitamin') == 'ada' ? 'selected' : '' }}>Ada Vitamin</option>
                                    <option value="tidak_ada" {{ request('vitamin') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                            </div>
                            
                            <!-- TANGGAL -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Tanggal</label>
                                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" 
                                       value="{{ request('tanggal_mulai') }}" 
                                       onchange="this.form.submit()">
                            </div>
                            
                            <!-- RESET -->
                            <div class="col-md-1 mb-2">
                                <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-secondary btn-sm btn-block">
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
                        <span class="info-box-icon"><i class="fas fa-hand-holding-medical"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Layanan</span>
                            <span class="info-box-number">{{ $layananPosyandu->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-pills"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Dengan Vitamin</span>
                            <span class="info-box-number">{{ $layananPosyandu->filter(function($item) { return !empty($item->vitamin); })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Bulan Ini</span>
                            <span class="info-box-number">{{ $layananPosyandu->filter(function($item) { return $item->created_at && $item->created_at->month == now()->month; })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-hospital-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Posyandu Aktif</span>
                            <span class="info-box-number">{{ $layananPosyandu->pluck('jadwal.posyandu_id')->filter()->unique()->count() }}</span>
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
                            <th width="20%">
                                <i class="fas fa-user mr-1"></i>
                                Nama Warga
                            </th>
                            <th width="20%">
                                <i class="fas fa-hospital mr-1"></i>
                                Posyandu
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-calendar mr-1"></i>
                                Tanggal
                            </th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-weight mr-1"></i>
                                Berat (kg)
                            </th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-ruler-vertical mr-1"></i>
                                Tinggi (cm)
                            </th>
                            <th width="10%">
                                <i class="fas fa-pills mr-1"></i>
                                Vitamin
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-cogs mr-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($layananPosyandu as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    {{ ($layananPosyandu->currentPage() - 1) * $layananPosyandu->perPage() + $index + 1 }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $item->warga->nama ?? '-' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $item->jadwal->posyandu->nama ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $item->jadwal->tanggal ?? '-' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info">{{ $item->berat ? number_format($item->berat, 1) : '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary">{{ $item->tinggi ? number_format($item->tinggi, 1) : '-' }}</span>
                                </td>
                                <td>
                                    @if($item->vitamin)
                                        <span class="badge badge-success">{{ $item->vitamin }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- TOMBOL SHOW/DETAIL -->
                                        <a href="{{ route('layanan-posyandu.show', $item->layanan_id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
                                        <!-- TOMBOL EDIT - Admin dan Kader -->
                                        <a href="{{ route('layanan-posyandu.edit', $item->layanan_id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if(Auth::user()->role === 'admin')
                                        <!-- TOMBOL DELETE - Hanya Admin -->
                                        <form action="{{ route('layanan-posyandu.destroy', $item->layanan_id) }}" 
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
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-hand-holding-medical fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada data layanan posyandu</h5>
                                        <p class="mb-0">
                                            @if(request()->hasAny(['search', 'posyandu_id', 'vitamin', 'tanggal_mulai']))
                                                Tidak ditemukan layanan dengan kriteria pencarian tersebut.
                                                <br>
                                                <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                                </a>
                                            @else
                                                Belum ada data layanan posyandu yang tersedia.
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <br>
                                                <a href="{{ route('layanan-posyandu.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Layanan Pertama
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
        @if($layananPosyandu->hasPages())
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $layananPosyandu->firstItem() }} - {{ $layananPosyandu->lastItem() }} 
                        dari {{ $layananPosyandu->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $layananPosyandu->withQueryString()->links('pagination::bootstrap-4') }}
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
        
        .badge-success {
            background-color: #17a2b8;
            color: white;
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