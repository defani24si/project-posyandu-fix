@extends('layout.app')

@section('title', 'Sistem Informasi Posyandu')

@section('content')

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-4">
                        Selamat Datang di <span class="text-primary">Sistem Posyandu</span>
                    </h1>
                    <p class="lead text-muted mb-4">
                        Sistem informasi terpadu untuk pengelolaan data kesehatan masyarakat. 
                        Memantau perkembangan kesehatan, imunisasi, dan layanan posyandu secara digital.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @if(Auth::check())
                            <a href="{{ route('posyandu.index') }}" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-home me-2"></i> Lihat Posyandu
                            </a>
                            <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                <i class="fas fa-stethoscope me-2"></i> Data Layanan
                            </a>
                        @else
                            
                            <a href="{{ route('posyandu.index') }}" class="btn btn-outline-primary btn-lg px-4">
                                <i class="fas fa-eye me-2"></i> Lihat Posyandu
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image mt-4 mt-lg-0">
                    <div class="position-relative">
                        <img src="{{ asset('img/posyandu-hero.png') }}" alt="Posyandu" class="img-fluid rounded-3 shadow">
                        <div class="position-absolute bottom-0 start-0 bg-primary text-white p-3 rounded-end shadow">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-users fa-2x me-3"></i>
                                <div>
                                    <h5 class="mb-0">Total Posyandu</h5>
                                    <h2 class="mb-0">{{ \App\Models\Posyandu::count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="stats-icon mb-3">
                            <i class="fas fa-home fa-3x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ \App\Models\Posyandu::count() }}</h3>
                        <p class="text-muted mb-0">Posyandu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="stats-icon mb-3">
                            <i class="fas fa-stethoscope fa-3x text-success"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ \App\Models\LayananPosyandu::count() }}</h3>
                        <p class="text-muted mb-0">Layanan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="stats-icon mb-3">
                            <i class="fas fa-syringe fa-3x text-warning"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ \App\Models\CatatanImunisasi::count() }}</h3>
                        <p class="text-muted mb-0">Imunisasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center py-4">
                        <div class="stats-icon mb-3">
                            <i class="fas fa-users fa-3x text-info"></i>
                        </div>
                        <h3 class="fw-bold mb-1">{{ \App\Models\KaderPosyandu::count() }}</h3>
                        <p class="text-muted mb-0">Kader</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fitur Section -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Fitur Utama Sistem</h2>
            <p class="text-muted">Kelola semua data posyandu dengan mudah dan efisien</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-4" style="width: 60px; height: 60px;">
                            <i class="fas fa-home fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Data Posyandu</h5>
                        <p class="text-muted mb-0">Kelola data posyandu wilayah, lokasi, dan informasi kontak.</p>
                        <a href="{{ route('posyandu.index') }}" class="btn btn-link mt-3 px-0">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-success bg-opacity-10 text-success rounded-circle mb-4" style="width: 60px; height: 60px;">
                            <i class="fas fa-stethoscope fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Layanan Kesehatan</h5>
                        <p class="text-muted mb-0">Catatan pemeriksaan kesehatan, vitamin, dan perkembangan.</p>
                        <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-link mt-3 px-0">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning rounded-circle mb-4" style="width: 60px; height: 60px;">
                            <i class="fas fa-syringe fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Catatan Imunisasi</h5>
                        <p class="text-muted mb-0">Data vaksinasi, jenis vaksin, dan lokasi pemberian.</p>
                        <a href="{{ route('catatan-imunisasi.index') }}" class="btn btn-link mt-3 px-0">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-info bg-opacity-10 text-info rounded-circle mb-4" style="width: 60px; height: 60px;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Jadwal Kegiatan</h5>
                        <p class="text-muted mb-0">Jadwal kegiatan posyandu dan event kesehatan.</p>
                        <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-link mt-3 px-0">
                            Lihat Detail <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Jadwal Terdekat -->
@if(Auth::check())
<section class="schedule-section py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Jadwal Terdekat</h2>
                <p class="text-muted">Kegiatan posyandu yang akan datang</p>
            </div>
            <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-outline-primary">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @php
                $upcomingSchedules = \App\Models\JadwalPosyandu::where('tanggal', '>=', now())
                    ->orderBy('tanggal')
                    ->take(3)
                    ->get();
            @endphp
            
            @forelse($upcomingSchedules as $schedule)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="date-badge bg-primary text-white text-center rounded me-3" style="width: 60px; height: 60px;">
                                <div class="day fs-3 fw-bold">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('d') }}</div>
                                <div class="month small">{{ \Carbon\Carbon::parse($schedule->tanggal)->format('M') }}</div>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1">{{ $schedule->tema }}</h5>
                                <p class="text-muted mb-0 small">
                                    {{ \Carbon\Carbon::parse($schedule->tanggal)->isoFormat('dddd') }}
                                </p>
                            </div>
                        </div>
                        <p class="text-muted mb-3">{{ Str::limit($schedule->keterangan, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-home me-1"></i> {{ $schedule->posyandu->nama ?? '-' }}
                            </span>
                            <a href="{{ route('jadwal_posyandu.show', $schedule->jadwal_id) }}" class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Tidak ada jadwal mendatang</h5>
                        <p class="text-muted small mb-0">Belum ada jadwal posyandu yang akan datang</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endif

<!-- Posyandu Terbaru -->
<section class="posyandu-section py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">Posyandu Terbaru</h2>
                <p class="text-muted">Posyandu yang baru ditambahkan</p>
            </div>
            <a href="{{ route('posyandu.index') }}" class="btn btn-outline-primary">
                Lihat Semua <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @php
                $recentPosyandu = \App\Models\Posyandu::latest()
                    ->take(4)
                    ->get();
            @endphp
            
            @forelse($recentPosyandu as $posyandu)
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <div class="text-center mb-3">
                            @if($posyandu->foto)
                                <img src="{{ asset('storage/' . $posyandu->foto) }}" 
                                     class="img-fluid rounded-circle" 
                                     alt="{{ $posyandu->nama }}"
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-home fa-2x text-white"></i>
                                </div>
                            @endif
                        </div>
                        <h6 class="fw-bold mb-2 text-center">{{ $posyandu->nama }}</h6>
                        <div class="text-center mb-2">
                            <span class="badge bg-primary">
                                RT {{ $posyandu->rt }} / RW {{ $posyandu->rw }}
                            </span>
                        </div>
                        <p class="text-muted small text-center mb-3">{{ Str::limit($posyandu->alamat, 50) }}</p>
                        <a href="{{ route('posyandu.show', $posyandu->posyandu_id) }}" 
                           class="btn btn-sm btn-outline-primary w-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-home fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-2">Tidak ada posyandu</h5>
                        <p class="text-muted small mb-0">Belum ada data posyandu yang tersedia</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Quick Actions for Admin/Kader -->
@if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
<section class="actions-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3">Aksi Cepat</h2>
            <p class="text-muted">Kelola data dengan cepat dan mudah</p>
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <a href="{{ route('layanan-posyandu.create') }}" class="card border-0 shadow-sm text-decoration-none text-dark h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="action-icon bg-success bg-opacity-10 text-success rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-plus fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Tambah Layanan</h6>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3">
                <a href="{{ route('catatan-imunisasi.create') }}" class="card border-0 shadow-sm text-decoration-none text-dark h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="action-icon bg-warning bg-opacity-10 text-warning rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-syringe fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Catat Imunisasi</h6>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3">
                <a href="{{ route('jadwal_posyandu.create') }}" class="card border-0 shadow-sm text-decoration-none text-dark h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="action-icon bg-info bg-opacity-10 text-info rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-calendar-plus fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Buat Jadwal</h6>
                    </div>
                </a>
            </div>
            
            @if(Auth::user()->role === 'admin')
            <div class="col-md-3">
                <a href="{{ route('kader-posyandu.create') }}" class="card border-0 shadow-sm text-decoration-none text-dark h-100 hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="action-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-user-plus fa-2x"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Tambah Kader</h6>
                    </div>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Footer Section -->
<section class="footer-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Butuh Bantuan?</h3>
                <p class="mb-4">Hubungi admin sistem untuk pertanyaan dan bantuan teknis.</p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="mailto:admin@posyandu.com" class="btn btn-light">
                        <i class="fas fa-envelope me-2"></i> Email Admin
                    </a>
                    <a href="#" class="btn btn-outline-light">
                        <i class="fas fa-question-circle me-2"></i> Panduan Sistem
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <div class="footer-logo">
                    <i class="fas fa-heartbeat fa-4x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .hero-section h1, 
    .hero-section p {
        color: white;
    }
    
    .hero-section .btn-primary {
        background: white;
        color: #667eea;
        border: none;
    }
    
    .hero-section .btn-outline-primary {
        background: transparent;
        color: white;
        border: 2px solid white;
    }
    
    .hero-section .btn-outline-primary:hover {
        background: white;
        color: #667eea;
    }
    
    .hover-lift {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    
    .feature-icon, .action-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .date-badge {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .stats-icon {
        transition: transform 0.3s;
    }
    
    .card:hover .stats-icon {
        transform: scale(1.1);
    }
    
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.5rem;
        }
        
        .stats-section .col-6 {
            margin-bottom: 1rem;
        }
    }
</style>

@endsection