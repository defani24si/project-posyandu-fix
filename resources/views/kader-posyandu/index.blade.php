@extends('layout.app')

@section('title', 'Kader Posyandu')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Data Kader Posyandu</h1>
            <p class="text-muted mb-0 small">Daftar kader aktif posyandu</p>
        </div>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('kader-posyandu.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Kader
        </a>
        @endif
    </div>

    <!-- Filter -->
    <div class="card card-body shadow-sm mb-4 p-3">
        <form method="GET" action="{{ route('kader-posyandu.index') }}" class="row g-2">
            <!-- Search -->
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama kader, posyandu...">
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
            
            <!-- Filter Status -->
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Filter Peran -->
            <div class="col-md-2">
                <select name="peran" class="form-select form-select-sm">
                    <option value="">Semua Peran</option>
                    @foreach($peranList as $peran)
                        <option value="{{ $peran }}" {{ request('peran') == $peran ? 'selected' : '' }}>
                            {{ $peran }}
                        </option>
                    @endforeach
                </select>
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
                    <!-- Tanggal Mulai -->
                    <div class="col-md-3">
                        <input type="date" name="tanggal_mulai" class="form-control form-control-sm" 
                               value="{{ request('tanggal_mulai') }}" placeholder="Mulai Tugas Dari">
                    </div>
                    
                    <!-- Tanggal Akhir -->
                    <div class="col-md-3">
                        <input type="date" name="tanggal_akhir" class="form-control form-control-sm" 
                               value="{{ request('tanggal_akhir') }}" placeholder="Sampai">
                    </div>

                    <!-- Sorting -->
                    <div class="col-md-3">
                        <select name="sort_by" class="form-select form-select-sm">
                            <option value="mulai_tugas" {{ request('sort_by') == 'mulai_tugas' ? 'selected' : '' }}>Mulai Tugas</option>
                            <option value="akhir_tugas" {{ request('sort_by') == 'akhir_tugas' ? 'selected' : '' }}>Akhir Tugas</option>
                            <option value="peran" {{ request('sort_by') == 'peran' ? 'selected' : '' }}>Peran</option>
                        </select>
                    </div>

                    <!-- Sort Order -->
                    <div class="col-md-2">
                        <select name="sort_order" class="form-select form-select-sm">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Cards -->
    @if($kaderPosyandu->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @foreach($kaderPosyandu as $item)
            <div class="col">
                <div class="card h-100 border shadow-sm">
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        @if($item->akhir_tugas && $item->akhir_tugas->isPast())
                            <span class="badge bg-secondary">Tidak Aktif</span>
                        @else
                            <span class="badge bg-success">Aktif</span>
                        @endif
                    </div>
                    
                    <!-- Card Header with Avatar -->
                    <div class="card-header bg-transparent border-bottom-0 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-white fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0 fw-bold">{{ $item->warga->nama ?? '-' }}</h6>
                                <small class="text-muted">{{ $item->peran }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body pt-2">
                        <!-- Posyandu -->
                        <div class="mb-2">
                            <p class="small mb-1">
                                <i class="fas fa-home text-muted me-1"></i>
                                <strong>Posyandu:</strong> {{ $item->posyandu->nama ?? '-' }}
                            </p>
                        </div>
                        
                        <!-- Periode Tugas -->
                        <div class="border-top pt-2">
                            <div class="row g-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Mulai Tugas</small>
                                    <span class="small fw-bold">
                                        {{ $item->mulai_tugas ? $item->mulai_tugas->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Akhir Tugas</small>
                                    <span class="small fw-bold {{ $item->akhir_tugas && $item->akhir_tugas->isPast() ? 'text-danger' : 'text-success' }}">
                                        {{ $item->akhir_tugas ? $item->akhir_tugas->format('d/m/Y') : 'Masih Aktif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Admin Actions -->
                        @if(Auth::check() && Auth::user()->role === 'admin')
                        <div class="border-top pt-2 mt-2">
                            <div class="d-flex gap-2">
                                <a href="{{ route('kader-posyandu.edit', $item->kader_id) }}" 
                                   class="btn btn-outline-warning btn-sm flex-fill">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('kader-posyandu.destroy', $item->kader_id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-grid">
                            <a href="{{ route('kader-posyandu.show', $item->kader_id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> Detail Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($kaderPosyandu->hasPages())
        <div class="mt-4">
            {{ $kaderPosyandu->withQueryString()->links('pagination.custom') }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="card border shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak ada kader posyandu</h5>
                <p class="text-muted small mb-0">Belum ada data kader yang tercatat</p>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('kader-posyandu.create') }}" class="btn btn-primary btn-sm mt-3">
                    <i class="fas fa-plus me-1"></i> Tambah Kader Pertama
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
        
        .rounded-circle {
            transition: transform 0.3s;
        }
        
        .card:hover .rounded-circle {
            transform: scale(1.05);
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 4px;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        /* Status colors */
        .bg-success {
            background-color: #28a745 !important;
        }
        
        .bg-secondary {
            background-color: #6c757d !important;
        }
        
        /* Avatar styles */
        .bg-primary {
            background-color: #007bff !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .row-cols-md-2 > * {
                width: 100%;
            }
            
            .card-body {
                padding: 1rem !important;
            }
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto submit form when select changes
        document.querySelectorAll('select[name="posyandu_id"], select[name="status"], select[name="peran"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
@stop