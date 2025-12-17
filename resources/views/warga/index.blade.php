@extends('adminlte::page')

@section('title', 'Data Warga')

@section('content_header')
    <h1>Data Warga</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Daftar Warga</h3>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="card-tools">
                <a href="{{ route('warga.create') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-plus"></i> Tambah Warga
                </a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <form method="GET" action="{{ route('warga.index') }}" class="mb-4">
                <div class="row">
                    <!-- SEARCH INPUT -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari NIK, nama, alamat..." 
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
                    
                    <!-- FILTER RT -->
                    <div class="col-md-2">
                        <select name="rt" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua RT</option>
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}" 
                                    {{ request('rt') == str_pad($i, 3, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    RT {{ str_pad($i, 3, '0', STR_PAD_LEFT) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- FILTER RW -->
                    <div class="col-md-2">
                        <select name="rw" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua RW</option>
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}" 
                                    {{ request('rw') == str_pad($i, 3, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    RW {{ str_pad($i, 3, '0', STR_PAD_LEFT) }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- FILTER JENIS KELAMIN -->
                    <div class="col-md-2">
                        <select name="jenis_kelamin" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua JK</option>
                            <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    
                    <!-- RESET BUTTON -->
                    <div class="col-md-2">
                        <a href="{{ route('warga.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>

                <!-- Advanced Filters (Collapsible) -->
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
                            <!-- FILTER UMUR -->
                            <div class="col-md-3">
                                <label class="form-label">Umur Minimum</label>
                                <input type="number" name="umur_min" class="form-control" 
                                       value="{{ request('umur_min') }}" placeholder="0" min="0" max="100">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Umur Maksimum</label>
                                <input type="number" name="umur_max" class="form-control" 
                                       value="{{ request('umur_max') }}" placeholder="100" min="0" max="100">
                            </div>

                            <!-- SORTING -->
                            <div class="col-md-3">
                                <label class="form-label">Urutkan Berdasarkan</label>
                                <select name="sort_by" class="form-select">
                                    <option value="nama" {{ request('sort_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                                    <option value="nik" {{ request('sort_by') == 'nik' ? 'selected' : '' }}>NIK</option>
                                    <option value="tanggal_lahir" {{ request('sort_by') == 'tanggal_lahir' ? 'selected' : '' }}>Tanggal Lahir</option>
                                    <option value="rt" {{ request('sort_by') == 'rt' ? 'selected' : '' }}>RT</option>
                                    <option value="rw" {{ request('sort_by') == 'rw' ? 'selected' : '' }}>RW</option>
                                    <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal Input</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Urutan</label>
                                <select name="sort_order" class="form-select">
                                    <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                                    <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A</option>
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
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat, Tgl Lahir</th>
                            <th>JK</th>
                            <th>RT/RW</th>
                            <th>No. Telepon</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($warga as $item)
                        <tr>
                            <td>{{ ($warga->currentPage() - 1) * $warga->perPage() + $loop->iteration }}</td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->tempat_lahir }}, {{ $item->tanggal_lahir->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge badge-{{ $item->jenis_kelamin == 'L' ? 'primary' : 'pink' }}">
                                    {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td>{{ $item->rt }}/{{ $item->rw }}</td>
                            <td>{{ $item->no_telepon ?: '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('warga.show', $item->warga_id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <a href="{{ route('warga.edit', $item->warga_id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('warga.destroy', $item->warga_id) }}" method="POST" class="d-inline">
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
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fa fa-users fa-2x mb-2"></i><br>
                                Tidak ada data warga
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
                {{ $warga->links('pagination.custom') }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Bootstrap CSS for collapse -->
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
        .badge-pink {
            background-color: #e91e63;
            color: white;
        }
    </style>
@stop

@section('js')
    <!-- Bootstrap JS for collapse -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stop