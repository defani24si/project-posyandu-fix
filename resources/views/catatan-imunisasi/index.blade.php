@extends('layout.app')

@section('title', 'Catatan Imunisasi')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Catatan Imunisasi</h1>
            <p class="text-muted mb-0 small">Data vaksinasi warga</p>
        </div>
        @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
        <a href="{{ route('catatan-imunisasi.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Catatan
        </a>
        @endif
    </div>

    <!-- Filter -->
    <div class="card card-body shadow-sm mb-4 p-3">
        <form method="GET" action="{{ route('catatan-imunisasi.index') }}" class="row g-2">
            <!-- Search -->
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama warga, vaksin...">
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
            
            <!-- Jenis Vaksin -->
            <div class="col-md-2">
                <select name="jenis_vaksin" class="form-select form-select-sm">
                    <option value="">Semua Vaksin</option>
                    @foreach($jenisVaksinList as $vaksin)
                        <option value="{{ $vaksin }}" {{ request('jenis_vaksin') == $vaksin ? 'selected' : '' }}>
                            {{ $vaksin }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Lokasi -->
            <div class="col-md-2">
                <select name="lokasi" class="form-select form-select-sm">
                    <option value="">Semua Lokasi</option>
                    @foreach($lokasiList as $lokasi)
                        <option value="{{ $lokasi }}" {{ request('lokasi') == $lokasi ? 'selected' : '' }}>
                            {{ $lokasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Kartu Scan -->
            <div class="col-md-2">
                <select name="kartu_scan" class="form-select form-select-sm">
                    <option value="">Semua Kartu</option>
                    <option value="ada" {{ request('kartu_scan') == 'ada' ? 'selected' : '' }}>Ada Scan</option>
                    <option value="tidak_ada" {{ request('kartu_scan') == 'tidak_ada' ? 'selected' : '' }}>Tanpa Scan</option>
                </select>
            </div>
            
            <!-- Reset Button -->
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'jenis_vaksin', 'lokasi', 'kartu_scan']))
                    <a href="{{ route('catatan-imunisasi.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                    @endif
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
                               value="{{ request('tanggal_mulai') }}" placeholder="Tanggal Mulai">
                    </div>
                    
                    <!-- Tanggal Akhir -->
                    <div class="col-md-3">
                        <input type="date" name="tanggal_akhir" class="form-control form-control-sm" 
                               value="{{ request('tanggal_akhir') }}" placeholder="Tanggal Akhir">
                    </div>

                    <!-- Nakes -->
                    <div class="col-md-3">
                        <select name="nakes" class="form-select form-select-sm">
                            <option value="">Semua Nakes</option>
                            @foreach($nakesList as $nakes)
                                <option value="{{ $nakes }}" {{ request('nakes') == $nakes ? 'selected' : '' }}>
                                    {{ $nakes }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sorting -->
                    <div class="col-md-2">
                        <select name="sort_by" class="form-select form-select-sm">
                            <option value="tanggal" {{ request('sort_by') == 'tanggal' ? 'selected' : '' }}>Tanggal</option>
                            <option value="jenis_vaksin" {{ request('sort_by') == 'jenis_vaksin' ? 'selected' : '' }}>Jenis Vaksin</option>
                            <option value="lokasi" {{ request('sort_by') == 'lokasi' ? 'selected' : '' }}>Lokasi</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Cards -->
    @if($catatanImunisasi->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @foreach($catatanImunisasi as $item)
            <div class="col">
                <div class="card h-100 border shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header py-2 px-3 bg-light border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m') }}
                            </span>
                            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('catatan-imunisasi.edit', $item->imunisasi_id) }}">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    @if(Auth::user()->role === 'admin')
                                    <li>
                                        <form action="{{ route('catatan-imunisasi.destroy', $item->imunisasi_id) }}" 
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
                        
                        <!-- Vaksin Badge -->
                        <div class="mb-2">
                            <span class="badge bg-info">
                                {{ $item->jenis_vaksin }}
                            </span>
                        </div>
                        
                        <!-- Info Details -->
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-map-marker-alt text-muted me-2 fs-6"></i>
                                <small>{{ $item->lokasi }}</small>
                            </div>
                            
                            <div class="d-flex align-items-center mb-1">
                                <i class="fas fa-user-md text-muted me-2 fs-6"></i>
                                <small>{{ $item->nakes }}</small>
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar text-muted me-2 fs-6"></i>
                                <small>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        
                        <!-- Kartu Scan -->
                        @if($item->kartu_imunisasi_scan)
                        <div class="border-top pt-2">
                            <a href="{{ asset('storage/' . $item->kartu_imunisasi_scan) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-image me-1"></i> Lihat Kartu Scan
                            </a>
                        </div>
                        @else
                        <div class="border-top pt-2">
                            <span class="badge bg-light text-muted w-100 text-center py-1">
                                <i class="fas fa-times-circle me-1"></i> Tidak ada scan
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-grid">
                            <a href="{{ route('catatan-imunisasi.show', $item->imunisasi_id) }}" 
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
        @if($catatanImunisasi->hasPages())
        <div class="mt-4">
            {{ $catatanImunisasi->withQueryString()->links('pagination.custom') }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="card border shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-syringe fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak ada catatan imunisasi</h5>
                <p class="text-muted small mb-0">Belum ada data vaksinasi yang tercatat</p>
                @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
                <a href="{{ route('catatan-imunisasi.create') }}" class="btn btn-primary btn-sm mt-3">
                    <i class="fas fa-plus me-1"></i> Tambah Catatan Pertama
                </a>
                @endif
            </div>
        </div>
    @endif

    <style>
        .card {
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .card-title {
            font-size: 1rem;
            line-height: 1.3;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 4px;
        }
        
        .card-footer {
            background: transparent;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .dropdown-menu {
            min-width: 120px;
            font-size: 0.875rem;
        }
        
        /* Vaksin badge color */
        .badge.bg-info {
            background-color: #17a2b8 !important;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .row-cols-md-2 > * {
                width: 100%;
            }
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto submit form when select changes
        document.querySelectorAll('select[name="jenis_vaksin"], select[name="lokasi"], select[name="kartu_scan"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
@stop