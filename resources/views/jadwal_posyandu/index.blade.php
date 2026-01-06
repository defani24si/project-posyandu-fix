@extends('adminlte::page')

@section('title', 'Jadwal Posyandu')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-calendar-alt text-primary"></i>
                Jadwal Posyandu
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jadwal Posyandu</li>
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
                        <i class="fas fa-calendar-check mr-2"></i>
                        Daftar Jadwal Posyandu
                    </h3>
                </div>
                <div class="col-auto">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('jadwal_posyandu.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah Jadwal
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('jadwal_posyandu.index') }}" class="bg-light p-3 rounded">
                        <div class="row align-items-end">
                            <!-- FILTER POSYANDU -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label text-sm font-weight-bold">Filter Posyandu</label>
                                <select name="posyandu_id" class="form-control form-control-sm">
                                    <option value="">Semua Posyandu</option>
                                    @foreach($posyandus as $posyandu)
                                        <option value="{{ $posyandu->posyandu_id }}" {{ request('posyandu_id') == $posyandu->posyandu_id ? 'selected' : '' }}>
                                            {{ $posyandu->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- FILTER TANGGAL DARI -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Tanggal Dari</label>
                                <input type="date" name="tanggal_dari" class="form-control form-control-sm" 
                                       value="{{ request('tanggal_dari') }}">
                            </div>
                            
                            <!-- FILTER TANGGAL SAMPAI -->
                            <div class="col-md-2 mb-2">
                                <label class="form-label text-sm font-weight-bold">Tanggal Sampai</label>
                                <input type="date" name="tanggal_sampai" class="form-control form-control-sm" 
                                       value="{{ request('tanggal_sampai') }}">
                            </div>
                            
                            <!-- SEARCH -->
                            <div class="col-md-3 mb-2">
                                <label class="form-label text-sm font-weight-bold">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari tema atau keterangan..." 
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
                                <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-secondary btn-sm btn-block">
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
                        <span class="info-box-icon"><i class="fas fa-calendar-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Jadwal</span>
                            <span class="info-box-number">{{ $jadwals->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-calendar-day"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Bulan Ini</span>
                            <span class="info-box-number">{{ $jadwals->where('tanggal', '>=', now()->startOfMonth())->where('tanggal', '<=', now()->endOfMonth())->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Minggu Ini</span>
                            <span class="info-box-number">{{ $jadwals->where('tanggal', '>=', now()->startOfWeek())->where('tanggal', '<=', now()->endOfWeek())->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Hari Ini</span>
                            <span class="info-box-number">{{ $jadwals->where('tanggal', now()->format('Y-m-d'))->count() }}</span>
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
                            <th width="15%">
                                <i class="fas fa-calendar mr-1"></i>
                                Tanggal
                            </th>
                            <th width="18%">
                                <i class="fas fa-hospital mr-1"></i>
                                Posyandu
                            </th>
                            <th width="18%">
                                <i class="fas fa-tag mr-1"></i>
                                Tema
                            </th>
                            <th width="20%">
                                <i class="fas fa-info-circle mr-1"></i>
                                Keterangan
                            </th>
                            <th class="text-center" width="14%">
                                <i class="fas fa-cogs mr-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwals as $index => $item)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    {{ ($jadwals->currentPage() - 1) * $jadwals->perPage() + $index + 1 }}
                                </td>
                                <td class="text-center">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}" 
                                             alt="Foto Jadwal" 
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
                                            <i class="fas fa-calendar text-white"></i>
                                        </div>
                                        <div>
                                            <strong>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</strong>
                                            <br>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal)->format('l') }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $item->posyandu->nama }}</span>
                                    <br>
                                    <small class="text-muted">RT {{ $item->posyandu->rt }}/RW {{ $item->posyandu->rw }}</small>
                                </td>
                                <td>
                                    <strong>{{ $item->tema }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($item->keterangan ?? '-', 50) }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- TOMBOL SHOW/DETAIL -->
                                        <a href="{{ route('jadwal_posyandu.show', $item->jadwal_id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                        <!-- TOMBOL EDIT - Hanya untuk Admin -->
                                        <a href="{{ route('jadwal_posyandu.edit', $item->jadwal_id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- TOMBOL DELETE - Hanya untuk Admin -->
                                        <form action="{{ route('jadwal_posyandu.destroy', $item->jadwal_id) }}" 
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
                                        <i class="fas fa-calendar-times fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada jadwal posyandu</h5>
                                        <p class="mb-0">
                                            @if(request()->hasAny(['search', 'posyandu_id', 'tanggal_dari', 'tanggal_sampai']))
                                                Tidak ditemukan jadwal dengan kriteria pencarian tersebut.
                                                <br>
                                                <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                                </a>
                                            @else
                                                Belum ada jadwal posyandu yang tersedia.
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <br>
                                                <a href="{{ route('jadwal_posyandu.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Tambah Jadwal Pertama
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
        @if($jadwals->hasPages())
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $jadwals->firstItem() }} - {{ $jadwals->lastItem() }} 
                        dari {{ $jadwals->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $jadwals->withQueryString()->links('pagination::bootstrap-4') }}
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