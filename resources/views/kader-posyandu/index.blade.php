@extends('adminlte::page')

@section('title', 'Kader Posyandu')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-user-nurse text-primary"></i>
                Data Kader Posyandu
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kader Posyandu</li>
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
                        Daftar Kader Posyandu
                    </h3>
                </div>
                <div class="col-auto">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('kader-posyandu.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Kader
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('kader-posyandu.index') }}" class="bg-light p-3 rounded">
                        <div class="row align-items-end">
                            <!-- SEARCH -->
                            <div class="col-md-4 mb-2">
                                <label class="form-label text-sm font-weight-bold">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nama kader, posyandu, peran..." 
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
                            
                            <!-- FILTER PERAN -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter Peran</label>
                                <select name="peran" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">Semua Peran</option>
                                    @foreach($peranList as $peran)
                                        <option value="{{ $peran }}" {{ request('peran') == $peran ? 'selected' : '' }}>
                                            {{ $peran }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- RESET -->
                            <div class="col-md-2 mb-2">
                                <a href="{{ route('kader-posyandu.index') }}" class="btn btn-secondary btn-sm btn-block">
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
                        <span class="info-box-icon"><i class="fas fa-user-nurse"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Kader</span>
                            <span class="info-box-number">{{ $kaderPosyandu->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-user-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kader Aktif</span>
                            <span class="info-box-number">{{ $kaderPosyandu->filter(function($item) { return empty($item->akhir_tugas); })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-hospital-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Posyandu Terlayani</span>
                            <span class="info-box-number">{{ $kaderPosyandu->pluck('posyandu_id')->filter()->unique()->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-users-cog"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Jenis Peran</span>
                            <span class="info-box-number">{{ $kaderPosyandu->pluck('peran')->filter()->unique()->count() }}</span>
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
                            <th width="25%">
                                <i class="fas fa-user mr-1"></i>
                                Nama Kader
                            </th>
                            <th width="20%">
                                <i class="fas fa-hospital mr-1"></i>
                                Posyandu
                            </th>
                            <th width="15%">
                                <i class="fas fa-user-tag mr-1"></i>
                                Peran
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-calendar mr-1"></i>
                                Periode Tugas
                            </th>
                            <th class="text-center" width="20%">
                                <i class="fas fa-cogs mr-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kaderPosyandu as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    {{ ($kaderPosyandu->currentPage() - 1) * $kaderPosyandu->perPage() + $index + 1 }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2" 
                                             style="width: 35px; height: 35px;">
                                            <i class="fas fa-user-nurse text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $item->warga->nama ?? '-' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $item->posyandu->nama ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $item->peran }}</span>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-plus mr-1"></i>
                                        {{ $item->mulai_tugas ? $item->mulai_tugas->format('d/m/Y') : '-' }}
                                        <br>
                                        <i class="fas fa-calendar-minus mr-1"></i>
                                        {{ $item->akhir_tugas ? $item->akhir_tugas->format('d/m/Y') : 'Aktif' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- TOMBOL SHOW/DETAIL -->
                                        <a href="{{ route('kader-posyandu.show', $item->kader_id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                        <!-- TOMBOL EDIT - Hanya untuk Admin -->
                                        <a href="{{ route('kader-posyandu.edit', $item->kader_id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- TOMBOL DELETE - Hanya untuk Admin -->
                                        <form action="{{ route('kader-posyandu.destroy', $item->kader_id) }}" 
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
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-user-nurse fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada data kader posyandu</h5>
                                        <p class="mb-0">
                                            @if(request()->hasAny(['search', 'posyandu_id', 'peran']))
                                                Tidak ditemukan kader dengan kriteria pencarian tersebut.
                                                <br>
                                                <a href="{{ route('kader-posyandu.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                                </a>
                                            @else
                                                Belum ada data kader posyandu yang tersedia.
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <br>
                                                <a href="{{ route('kader-posyandu.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Kader Pertama
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
        @if($kaderPosyandu->hasPages())
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $kaderPosyandu->firstItem() }} - {{ $kaderPosyandu->lastItem() }} 
                        dari {{ $kaderPosyandu->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $kaderPosyandu->withQueryString()->links('pagination::bootstrap-4') }}
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