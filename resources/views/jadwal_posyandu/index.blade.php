@extends('layout.app')

@section('title', 'Jadwal Posyandu')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Jadwal Posyandu</h1>
            <p class="text-muted mb-0 small">Daftar kegiatan posyandu</p>
        </div>
        @if(Auth::check() && Auth::user()->role === 'admin')
        <a href="{{ route('jadwal_posyandu.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Jadwal
        </a>
        @endif
    </div>

    <!-- Filter -->
    <div class="card card-body shadow-sm mb-4 p-3">
        <form method="GET" action="{{ route('jadwal_posyandu.index') }}" class="row g-2">
            <div class="col-md-3">
                <select name="posyandu_id" class="form-select form-select-sm">
                    <option value="">Semua Posyandu</option>
                    @foreach($posyandus as $posyandu)
                        <option value="{{ $posyandu->posyandu_id }}" {{ request('posyandu_id') == $posyandu->posyandu_id ? 'selected' : '' }}>
                            {{ $posyandu->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-2">
                <input type="date" name="tanggal_dari" class="form-control form-control-sm" 
                       value="{{ request('tanggal_dari') }}" placeholder="Dari">
            </div>
            
            <div class="col-md-2">
                <input type="date" name="tanggal_sampai" class="form-control form-control-sm" 
                       value="{{ request('tanggal_sampai') }}" placeholder="Sampai">
            </div>
            
            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" 
                           value="{{ request('search') }}" 
                           placeholder="Cari tema...">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-fill">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['posyandu_id', 'tanggal_dari', 'tanggal_sampai', 'search']))
                    <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                        <i class="fas fa-redo"></i>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Cards -->
    @if($jadwals->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-3">
            @foreach($jadwals as $item)
            <div class="col">
                <div class="card h-100 border shadow-sm">
                    <!-- Poster Area -->
                    <div class="text-center py-4 px-3 border-bottom bg-light" style="min-height: 180px;">
                        @if($item->poster_kegiatan)
                            <img src="{{ asset('storage/' . $item->poster_kegiatan) }}" 
                                 class="img-fluid rounded" 
                                 alt="Poster"
                                 style="max-height: 140px; object-fit: contain; cursor: pointer;"
                                 onclick="showPosterModal('{{ asset('storage/' . $item->poster_kegiatan) }}', '{{ $item->tema }}')">
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted small mb-0">Tidak ada poster</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Card Content -->
                    <div class="card-body">
                        <!-- Tanggal Badge -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary">
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                            </span>
                            @if(Auth::check() && Auth::user()->role === 'admin')
                            <div class="dropdown">
                                <button class="btn btn-sm btn-link text-muted p-0" type="button" 
                                        data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('jadwal_posyandu.edit', $item->jadwal_id) }}">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('jadwal_posyandu.destroy', $item->jadwal_id) }}" 
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
                        
                        <!-- Tema -->
                        <h6 class="card-title fw-bold mb-2">{{ $item->tema }}</h6>
                        
                        <!-- Info -->
                        <div class="mb-3">
                            <p class="mb-1 small">
                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                {{ $item->posyandu->nama ?? '-' }}
                            </p>
                            <p class="mb-0 small text-muted">
                                <i class="fas fa-clock text-muted me-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd') }}
                            </p>
                        </div>
                        
                        <!-- Keterangan -->
                        @if($item->keterangan)
                        <div class="border-top pt-2 mt-2">
                            <p class="small text-muted mb-0">{{ Str::limit($item->keterangan, 60) }}</p>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-grid">
                            <a href="{{ route('jadwal_posyandu.show', $item->jadwal_id) }}" 
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
        @if($jadwals->hasPages())
        <div class="mt-4">
            {{ $jadwals->withQueryString()->links('pagination.custom') }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="card border shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted mb-2">Tidak ada jadwal</h5>
                <p class="text-muted small mb-0">Belum ada jadwal posyandu yang tersedia</p>
            </div>
        </div>
    @endif

    <!-- Modal Poster -->
    <div class="modal fade" id="posterModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Poster Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalPosterImage" src="" alt="Poster" class="img-fluid rounded">
                </div>
                <div class="modal-footer">
                    <a id="downloadPoster" href="" download class="btn btn-primary">
                        <i class="fas fa-download me-1"></i> Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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
        
        /* Layout yang lebih rapi */
        .border-bottom {
            border-bottom: 1px solid #dee2e6 !important;
        }
        
        .border-top {
            border-top: 1px solid #dee2e6 !important;
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
<script>
function showPosterModal(imageSrc, title) {
    $('#modalPosterImage').attr('src', imageSrc);
    $('.modal-title').text('Poster: ' + title);
    $('#downloadPoster').attr('href', imageSrc);
    $('#posterModal').modal('show');
}
</script>
@stop