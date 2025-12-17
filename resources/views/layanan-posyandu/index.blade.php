@extends('adminlte::page')

@section('title', 'Layanan Posyandu')

@section('content_header')
    <h1>Data Layanan Posyandu</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Daftar Layanan Posyandu</h3>
            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
            <div class="card-tools">
                <a href="{{ route('layanan-posyandu.create') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-plus"></i> Tambah Layanan
                </a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <form method="GET" action="{{ route('layanan-posyandu.index') }}" class="mb-4">
                <div class="row">
                    <!-- SEARCH INPUT -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama warga, posyandu, vitamin..." 
                                   aria-label="Search">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                            @if(request('search'))
                                <a href="{{ request()->fullUrlWithQuery(['search'=> null]) }}" 
                                   class="btn btn-outline-secondary" 
                                   title="Hapus pencarian">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- FILTER POSYANDU -->
                    <div class="col-md-3">
                        <select name="posyandu_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Posyandu</option>
                            @foreach($posyandu as $item)
                                <option value="{{ $item->posyandu_id }}" 
                                    {{ request('posyandu_id') == $item->posyandu_id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- FILTER VITAMIN -->
                    <div class="col-md-2">
                        <select name="vitamin" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Vitamin</option>
                            <option value="ada" {{ request('vitamin') == 'ada' ? 'selected' : '' }}>Ada Vitamin</option>
                            <option value="tidak_ada" {{ request('vitamin') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada</option>
                        </select>
                    </div>

                    <!-- TANGGAL -->
                    <div class="col-md-2">
                        <input type="date" name="tanggal_mulai" class="form-control" 
                               value="{{ request('tanggal_mulai') }}" 
                               placeholder="Tanggal Mulai"
                               onchange="this.form.submit()">
                    </div>
                    
                    <!-- RESET BUTTON -->
                    <div class="col-md-1">
                        <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="collapse" data-bs-target="#advancedFilters">
                            <i class="fa fa-filter"></i> Filter Lanjutan
                        </button>
                    </div>
                </div>

                <div class="collapse mt-3" id="advancedFilters">
                    <div class="card card-body bg-light">
                        <div class="row">
                            <!-- FILTER TANGGAL AKHIR -->
                            <div class="col-md-2">
                                <label class="form-label">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir" class="form-control" 
                                       value="{{ request('tanggal_akhir') }}">
                            </div>

                            <!-- FILTER BERAT -->
                            <div class="col-md-2">
                                <label class="form-label">Berat Min (kg)</label>
                                <input type="number" step="0.1" name="berat_min" class="form-control" 
                                       value="{{ request('berat_min') }}" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Berat Max (kg)</label>
                                <input type="number" step="0.1" name="berat_max" class="form-control" 
                                       value="{{ request('berat_max') }}" placeholder="100">
                            </div>

                            <!-- FILTER TINGGI -->
                            <div class="col-md-2">
                                <label class="form-label">Tinggi Min (cm)</label>
                                <input type="number" step="0.1" name="tinggi_min" class="form-control" 
                                       value="{{ request('tinggi_min') }}" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tinggi Max (cm)</label>
                                <input type="number" step="0.1" name="tinggi_max" class="form-control" 
                                       value="{{ request('tinggi_max') }}" placeholder="200">
                            </div>

                            <!-- SORTING -->
                            <div class="col-md-1">
                                <label class="form-label">Urutan</label>
                                <select name="sort_order" class="form-select">
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa fa-filter"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th>Nama Warga</th>
                            <th>Posyandu</th>
                            <th>Tanggal</th>
                            <th>Berat (kg)</th>
                            <th>Tinggi (cm)</th>
                            <th>Vitamin</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($layananPosyandu as $item)
                        <tr>
                            <td>{{ ($layananPosyandu->currentPage() - 1) * $layananPosyandu->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->warga->nama ?? '-' }}</td>
                            <td>{{ $item->jadwal->posyandu->nama ?? '-' }}</td>
                            <td>{{ $item->jadwal->tanggal ?? '-' }}</td>
                            <td>{{ $item->berat ? number_format($item->berat, 1) : '-' }}</td>
                            <td>{{ $item->tinggi ? number_format($item->tinggi, 1) : '-' }}</td>
                            <td>{{ $item->vitamin ?: '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('layanan-posyandu.show', $item->layanan_id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
                                    <a href="{{ route('layanan-posyandu.edit', $item->layanan_id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if(Auth::user()->role === 'admin')
                                    <form action="{{ route('layanan-posyandu.destroy', $item->layanan_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fa fa-stethoscope fa-2x mb-2"></i><br>
                                Tidak ada data layanan posyandu
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
                {{ $layananPosyandu->links('pagination.custom') }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            border-bottom: none;
            background-color: #007bff !important;
        }
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 8px;
        }
        .btn-group {
            gap: 4px;
        }
        .btn-group .btn {
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            transition: all 0.3s ease;
        }
        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);
            border-radius: 8px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stop