@extends('adminlte::page')

@section('title', 'Kader Posyandu')

@section('content_header')
    <h1>Data Kader Posyandu</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Daftar Kader Posyandu</h3>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="card-tools">
                <a href="{{ route('kader-posyandu.create') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-plus"></i> Tambah Kader
                </a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <form method="GET" action="{{ route('kader-posyandu.index') }}" class="mb-4">
                <div class="row">
                    <!-- SEARCH INPUT -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama kader, posyandu, peran..." 
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
                    
                    <!-- FILTER STATUS -->
                    <div class="col-md-2">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <!-- FILTER PERAN -->
                    <div class="col-md-2">
                        <select name="peran" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Peran</option>
                            @foreach($peranList as $peran)
                                <option value="{{ $peran }}" {{ request('peran') == $peran ? 'selected' : '' }}>
                                    {{ $peran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- RESET BUTTON -->
                    <div class="col-md-1">
                        <a href="{{ route('kader-posyandu.index') }}" class="btn btn-secondary w-100">Reset</a>
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
                            <!-- FILTER TANGGAL -->
                            <div class="col-md-3">
                                <label class="form-label">Mulai Tugas Dari</label>
                                <input type="date" name="tanggal_mulai" class="form-control" 
                                       value="{{ request('tanggal_mulai') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Mulai Tugas Sampai</label>
                                <input type="date" name="tanggal_akhir" class="form-control" 
                                       value="{{ request('tanggal_akhir') }}">
                            </div>

                            <!-- SORTING -->
                            <div class="col-md-3">
                                <label class="form-label">Urutkan Berdasarkan</label>
                                <select name="sort_by" class="form-select">
                                    <option value="mulai_tugas" {{ request('sort_by') == 'mulai_tugas' ? 'selected' : '' }}>Mulai Tugas</option>
                                    <option value="akhir_tugas" {{ request('sort_by') == 'akhir_tugas' ? 'selected' : '' }}>Akhir Tugas</option>
                                    <option value="peran" {{ request('sort_by') == 'peran' ? 'selected' : '' }}>Peran</option>
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Urutan</label>
                                <select name="sort_order" class="form-select">
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Terbaru</option>
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
                            <th>Nama Kader</th>
                            <th>Posyandu</th>
                            <th>Peran</th>
                            <th>Mulai Tugas</th>
                            <th>Akhir Tugas</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($kaderPosyandu as $item)
                        <tr>
                            <td>{{ ($kaderPosyandu->currentPage() - 1) * $kaderPosyandu->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->warga->nama ?? '-' }}</td>
                            <td>{{ $item->posyandu->nama ?? '-' }}</td>
                            <td>{{ $item->peran }}</td>
                            <td>{{ $item->mulai_tugas ? $item->mulai_tugas->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->akhir_tugas ? $item->akhir_tugas->format('d/m/Y') : 'Aktif' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('kader-posyandu.show', $item->kader_id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <a href="{{ route('kader-posyandu.edit', $item->kader_id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kader-posyandu.destroy', $item->kader_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fa fa-users fa-2x mb-2"></i><br>
                                Tidak ada data kader posyandu
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
                {{ $kaderPosyandu->links('pagination.custom') }}
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