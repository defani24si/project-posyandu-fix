@extends('layout.app')

@section('title', 'Posyandu')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Data Posyandu</h1>
            <p class="text-muted mb-0 small">Daftar posyandu wilayah</p>
        </div>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('posyandu.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Posyandu
        </a>
        @endif
    </div>

    <!-- Filter -->
    <div class="card card-body shadow-sm mb-4 p-3">
        <form method="GET" action="{{ route('posyandu.index') }}" class="row g-2">
            <!-- Filter RT -->
            <div class="col-md-2">
                <select name="rt" class="form-select form-select-sm">
                    <option value="">Semua RT</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request('rt') == $i ? 'selected' : '' }}>
                            RT {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <!-- Filter RW -->
            <div class="col-md-2">
                <select name="rw" class="form-select form-select-sm">
                    <option value="">Semua RW</option>
                    @for($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ request('rw') == $i ? 'selected' : '' }}>
                            RW {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <!-- Search -->
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama atau alamat...">
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
            
            <!-- Reset Button -->
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['rt', 'rw', 'search']))
                    <a href="{{ route('posyandu.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Cards -->
    @if($posyandus->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @foreach($posyandus as $item)
            <div class="col">
                <div class="card h-100 border shadow-sm">
                    <!-- Foto Posyandu -->
                    <div class="text-center py-4 px-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" 
                                 class="img-fluid rounded-circle border border-3 border-white shadow" 
                                 alt="Foto Posyandu"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="rounded-circle border border-3 border-white bg-white d-flex align-items-center justify-content-center mx-auto shadow"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-home fa-2x text-primary"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- RT/RW Badge -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">
                                RT {{ $item->rt }} / RW {{ $item->rw }}
                            </span>
                            @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('posyandu.edit', $item->posyandu_id) }}">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('posyandu.destroy', $item->posyandu_id) }}" 
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Nama Posyandu -->
                        <h6 class="card-title fw-bold mb-2">{{ $item->nama }}</h6>
                        
                        <!-- Alamat -->
                        <div class="mb-3">
                            <p class="small text-muted mb-1">
                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                {{ Str::limit($item->alamat, 60) }}
                            </p>
                        </div>
                        
                        <!-- Kontak -->
                        @if($item->kontak)
                        <div class="border-top pt-2">
                            <p class="small mb-0">
                                <i class="fas fa-phone text-muted me-1"></i>
                                <strong>Kontak:</strong> {{ $item->kontak }}
                            </p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-grid">
                            <a href="{{ route('posyandu.show', $item->posyandu_id) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($posyandus->hasPages())
        <div class="mt-4">
            {{ $posyandus->withQueryString()->links('pagination.custom') }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="card border shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-home fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak ada posyandu</h5>
                <p class="text-muted small mb-0">Belum ada data posyandu yang tersedia</p>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <a href="{{ route('posyandu.create') }}" class="btn btn-primary btn-sm mt-3">
                    <i class="fas fa-plus me-1"></i> Tambah Posyandu Pertama
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
        
        /* Responsive */
        @media (max-width: 768px) {
            .row-cols-md-2 > * {
                width: 100%;
            }
        }
    </style>
@stop