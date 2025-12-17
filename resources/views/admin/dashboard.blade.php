@extends('adminlte::page')

@section('title', 'Dashboard - Sistem Posyandu')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
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

    <!-- Welcome Card -->
    <div class="card bg-gradient-primary text-white mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="mb-0 opacity-75">
                        Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong> • 
                        {{ now()->format('l, d F Y') }}
                    </p>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <!-- Total Warga -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['total_warga']) }}</h3>
                    <p>Total Warga</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('warga.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Posyandu -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['total_posyandu']) }}</h3>
                    <p>Total Posyandu</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hospital-user"></i>
                </div>
                <a href="{{ route('posyandu.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Active Kader -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['total_kader']) }}</h3>
                    <p>Kader Aktif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-nurse"></i>
                </div>
                <a href="{{ route('kader-posyandu.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Layanan Bulan Ini -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['total_layanan_bulan_ini']) }}</h3>
                    <p>Layanan Bulan Ini</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-medical"></i>
                </div>
                <a href="{{ route('layanan-posyandu.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row">
        <div class="col-lg-6 col-12">
            <div class="info-box bg-gradient-info">
                <span class="info-box-icon"><i class="fas fa-syringe"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Imunisasi Bulan Ini</span>
                    <span class="info-box-number">{{ number_format($stats['total_imunisasi_bulan_ini']) }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ min(($stats['total_imunisasi_bulan_ini'] / 100) * 100, 100) }}%"></div>
                    </div>
                    <span class="progress-description">
                        Target: 100 imunisasi per bulan
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon"><i class="fas fa-calendar-week"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Jadwal Minggu Ini</span>
                    <span class="info-box-number">{{ number_format($stats['jadwal_minggu_ini']) }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ min(($stats['jadwal_minggu_ini'] / 7) * 100, 100) }}%"></div>
                    </div>
                    <span class="progress-description">
                        Dari 7 hari dalam seminggu
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activities -->
    <div class="row">
        <!-- Layanan Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-1"></i>
                        Trend Layanan Posyandu
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="layananChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Imunisasi Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Trend Imunisasi
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="imunisasiChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Gender Distribution and Upcoming Schedules -->
    <div class="row">
        <!-- Gender Distribution -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Distribusi Jenis Kelamin
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" style="height: 200px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Upcoming Schedules -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Jadwal Mendatang
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Posyandu</th>
                                    <th>Tema</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcoming_schedules as $schedule)
                                    <tr>
                                        <td>
                                            <i class="fas fa-calendar text-primary"></i>
                                            {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                                        </td>
                                        <td>{{ $schedule->posyandu->nama }}</td>
                                        <td>{{ $schedule->tema }}</td>
                                        <td>
                                            @if(\Carbon\Carbon::parse($schedule->tanggal)->isToday())
                                                <span class="badge badge-success">Hari Ini</span>
                                            @elseif(\Carbon\Carbon::parse($schedule->tanggal)->isTomorrow())
                                                <span class="badge badge-warning">Besok</span>
                                            @else
                                                <span class="badge badge-info">Mendatang</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-3">
                                            <i class="fas fa-calendar-times fa-2x mb-2"></i><br>
                                            Tidak ada jadwal mendatang
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <!-- Recent Layanan -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Layanan Terbaru
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Warga</th>
                                    <th>Posyandu</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_layanan as $layanan)
                                    <tr>
                                        <td>{{ $layanan->warga->nama ?? '-' }}</td>
                                        <td>{{ $layanan->jadwal->posyandu->nama ?? '-' }}</td>
                                        <td>{{ $layanan->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            Belum ada layanan terbaru
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Imunisasi -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-syringe mr-1"></i>
                        Imunisasi Terbaru
                    </h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Warga</th>
                                    <th>Vaksin</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_imunisasi as $imunisasi)
                                    <tr>
                                        <td>{{ $imunisasi->warga->nama ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-primary">{{ $imunisasi->jenis_vaksin }}</span>
                                        </td>
                                        <td>{{ $imunisasi->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-3">
                                            Belum ada imunisasi terbaru
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        
        .small-box {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .small-box:hover {
            transform: translateY(-5px);
        }
        
        .info-box {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .card-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            border-bottom: none;
        }
        
        .card-title {
            color: white !important;
            font-weight: 600;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        
        .opacity-75 {
            opacity: 0.75;
        }
        
        .opacity-50 {
            opacity: 0.5;
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
            border-radius: 10px;
            border: none;
        }
    </style>
@stop

@section('js')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Layanan Chart
        const layananCtx = document.getElementById('layananChart').getContext('2d');
        const layananChart = new Chart(layananCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($layanan_chart, 'month')) !!},
                datasets: [{
                    label: 'Jumlah Layanan',
                    data: {!! json_encode(array_column($layanan_chart, 'count')) !!},
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Imunisasi Chart
        const imunisasiCtx = document.getElementById('imunisasiChart').getContext('2d');
        const imunisasiChart = new Chart(imunisasiCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($imunisasi_chart, 'month')) !!},
                datasets: [{
                    label: 'Jumlah Imunisasi',
                    data: {!! json_encode(array_column($imunisasi_chart, 'count')) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                    borderColor: '#28a745',
                    borderWidth: 2,
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Gender Distribution Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        const genderData = {!! json_encode($gender_stats) !!};
        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: genderData.map(item => item.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'),
                datasets: [{
                    data: genderData.map(item => item.total),
                    backgroundColor: ['#007bff', '#e91e63'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
@stop