@extends('layout.app')

@section('title', 'Layanan Posyandu')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Data Layanan Posyandu</h1>
            <p class="text-muted mb-0 small">Catatan pemeriksaan kesehatan warga</p>
        </div>
        @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
        <a href="{{ route('layanan-posyandu.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Layanan
        </a>
        @endif
    </div>

    <!-- Filter -->
    <div class="card card-body shadow-sm mb-4 p-3">
        <form method="GET" action="{{ route('layanan-posyandu.index') }}" class="row g-2">
            <!-- Search -->
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama warga, vitamin...">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request('search'))
                    <a href="{{ request()->fullUrlWithQuery(['search'=> null]) }}" 
                       class="btn btn-outline-secondary" title="Hapus pencarian">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </div>
            
            <!-- Filter Posyandu -->
            <div class="col-md-3">
                <select name="posyandu_id" class="form-select form-select-sm">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyandu as $item)
                        <option value="{{ $item->posyandu_id }}" 
                            {{ request('posyandu_id') == $item->posyandu_id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Vitamin -->
            <div class="col-md-2">
                <select name="vitamin" class="form-select form-select-sm">
                    <option value="">Semua Vitamin</option>
                    <option value="ada" {{ request('vitamin') == 'ada' ? 'selected' : '' }}>Ada Vitamin</option>
                    <option value="tidak_ada" {{ request('vitamin') == 'tidak_ada' ? 'selected' : '' }}>Tanpa Vitamin</option>
                </select>
            </div>

            <!-- Tanggal -->
            <div class="col-md-2">
                <input type="date" name="tanggal_mulai" class="form-control form-control-sm" 
                       value="{{ request('tanggal_mulai') }}" placeholder="Tanggal">
            </div>
            
            <!-- Reset Button -->
            <div class="col-md-1">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="col-12 mt-2">
                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                    <i class="fas fa-filter"></i> Filter Lanjutan
                </button>
            </div>

            <div class="collapse mt-2" id="advancedFilters">
                <div class="row g-2 pt-2 border-top">
                    <!-- Tanggal Akhir -->
                    <div class="col-md-2">
                        <input type="date" name="tanggal_akhir" class="form-control form-control-sm" 
                               value="{{ request('tanggal_akhir') }}" placeholder="Sampai">
                    </div>

                    <!-- Berat -->
                    <div class="col-md-2">
                        <input type="number" step="0.1" name="berat_min" class="form-control form-control-sm" 
                               value="{{ request('berat_min') }}" placeholder="Berat Min (kg)">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.1" name="berat_max" class="form-control form-control-sm" 
                               value="{{ request('berat_max') }}" placeholder="Berat Max (kg)">
                    </div>

                    <!-- Tinggi -->
                    <div class="col-md-2">
                        <input type="number" step="0.1" name="tinggi_min" class="form-control form-control-sm" 
                               value="{{ request('tinggi_min') }}" placeholder="Tinggi Min (cm)">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.1" name="tinggi_max" class="form-control form-control-sm" 
                               value="{{ request('tinggi_max') }}" placeholder="Tinggi Max (cm)">
                    </div>

                    <!-- Sorting -->
                    <div class="col-md-1">
                        <select name="sort_order" class="form-select form-select-sm">
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Cards -->
    @if($layananPosyandu->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @foreach($layananPosyandu as $item)
            <div class="col">
                <div class="card h-100 border shadow-sm">
                    <!-- Card Header with Date -->
                    <div class="card-header py-2 px-3 bg-light border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">
                                {{ \Carbon\Carbon::parse($item->jadwal->tanggal ?? now())->format('d/m/Y') }}
                            </span>
                            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('layanan-posyandu.edit', $item->layanan_id) }}">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    @if(Auth::user()->role === 'admin')
                                    <li>
                                        <form action="{{ route('layanan-posyandu.destroy', $item->layanan_id) }}" 
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Nama Warga -->
                        <h6 class="card-title mb-2 fw-bold">{{ $item->warga->nama ?? '-' }}</h6>
                        
                        <!-- Posyandu -->
                        <div class="mb-3">
                            <p class="small mb-1">
                                <i class="fas fa-home text-muted me-1"></i>
                                {{ $item->jadwal->posyandu->nama ?? '-' }}
                            </p>
                        </div>
                        
                        <!-- Measurements -->
                        <div class="row g-2 mb-3">
                            <!-- Berat -->
                            <div class="col-6">
                                <div class="border rounded p-2 text-center bg-light">
                                    <small class="text-muted d-block">Berat</small>
                                    <span class="fw-bold">
                                        {{ $item->berat ? number_format($item->berat, 1) : '-' }} kg
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Tinggi -->
                            <div class="col-6">
                                <div class="border rounded p-2 text-center bg-light">
                                    <small class="text-muted d-block">Tinggi</small>
                                    <span class="fw-bold">
                                        {{ $item->tinggi ? number_format($item->tinggi, 1) : '-' }} cm
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Vitamin -->
                        <div class="border-top pt-2">
                            @if($item->vitamin)
                            <div class="alert alert-success py-1 mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-pills me-2"></i>
                                    <small class="fw-bold">{{ $item->vitamin }}</small>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-secondary py-1 mb-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle me-2"></i>
                                    <small class="text-muted">Tidak ada vitamin</small>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-grid">
                            <a href="{{ route('layanan-posyandu.show', $item->layanan_id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> Detail Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($layananPosyandu->hasPages())
        <div class="mt-4">
            {{ $layananPosyandu->withQueryString()->links('pagination.custom') }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="card border shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-stethoscope fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak ada layanan posyandu</h5>
                <p class="text-muted small mb-0">Belum ada data pemeriksaan yang tercatat</p>
                @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
                <a href="{{ route('layanan-posyandu.create') }}" class="btn btn-primary btn-sm mt-3">
                    <i class="fas fa-plus me-1"></i> Tambah Layanan Pertama
                </a>
                @endif
            </div>
        </div>
    @endif

    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1) !important;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 4px;
        }
        
        .card-title {
            font-size: 1rem;
            line-height: 1.3;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .dropdown-menu {
            min-width: 120px;
            font-size: 0.875rem;
        }
        
        /* Measurement boxes */
        .bg-light {
            background-color: #f8f9fa !important;
        }
        
        .border.rounded {
            border-radius: 8px !important;
        }
        
        /* Alert styles for vitamin */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 0.5rem;
            border-radius: 6px;
        }
        
        .alert-secondary {
            background-color: #e2e3e5;
            border-color: #d6d8db;
            color: #383d41;
            padding: 0.5rem;
            border-radius: 6px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .row-cols-md-2 > * {
                width: 100%;
            }
            
            .row.g-2 > .col-6 {
                width: 50% !important;
            }
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto submit form when select changes
        document.querySelectorAll('select[name="posyandu_id"], select[name="vitamin"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
        
        // Auto submit tanggal
        document.querySelector('input[name="tanggal_mulai"]').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
@stop