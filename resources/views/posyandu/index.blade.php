@extends('adminlte::page')

@section('title', 'Posyandu')

@section('content_header')
    <h1>Data Posyandu</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Posyandu</h3>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="card-tools">
                <a href="{{ route('posyandu.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Posyandu
                </a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <!-- FORM FILTER & SEARCH -->
            <form method="GET" action="{{ route('posyandu.index') }}" class="mb-3">
                <div class="row">
                    <!-- FILTER RT -->
                    <div class="col-md-2">
                        <select name="rt" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua RT</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('rt') == $i ? 'selected' : '' }}>
                                    RT {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- FILTER RW -->
                    <div class="col-md-2">
                        <select name="rw" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua RW</option>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('rw') == $i ? 'selected' : '' }}>
                                    RW {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- SEARCH INPUT -->
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Cari nama atau alamat..." 
                                   aria-label="Search">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fa fa-search"></i>
                            </button>
                            
                            <!-- CLEAR SEARCH BUTTON -->
                            @if(request('search'))
                                <a href="{{ request()->fullUrlWithQuery(['search'=> null]) }}" 
                                   class="btn btn-outline-secondary" 
                                   title="Hapus pencarian">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- RESET BUTTON -->
                    <div class="col-md-2">
                        <a href="{{ route('posyandu.index') }}" class="btn btn-secondary">Reset All</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="60">No</th>
                            <th width="80">Foto</th>
                            <th>Nama Posyandu</th>
                            <th>Alamat</th>
                            <th>RT/RW</th>
                            <th>Kontak</th>
                            <th width="130" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($posyandus as $item)
                        <tr>
                            <td>{{ ($posyandus->currentPage() - 1) * $posyandus->perPage() + $loop->iteration }}</td>
                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" 
                                         alt="Foto Posyandu" 
                                         class="img-circle img-size-50"
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"
                                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\'%3E%3Crect width=\'50\' height=\'50\' fill=\'%236c757d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'white\'%3E%3C/text%3E%3C/svg%3E';">
                                @else
                                    <div class="img-circle img-size-50 bg-secondary d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; border-radius: 50%;">
                                        <i class="fa fa-building text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>RT {{ $item->rt }} / RW {{ $item->rw }}</td>
                            <td>{{ $item->kontak }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <!-- TOMBOL SHOW/DETAIL -->
                                    <a href="{{ route('posyandu.show', $item->posyandu_id) }}" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <!-- TOMBOL EDIT - Hanya untuk Admin -->
                                    <a href="{{ route('posyandu.edit', $item->posyandu_id) }}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- TOMBOL DELETE - Hanya untuk Admin -->
                                    <form action="{{ route('posyandu.destroy', $item->posyandu_id) }}" method="POST" class="d-inline">
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
                                <i class="fa fa-database fa-2x mb-2"></i><br>
                                Tidak ada data posyandu
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer clearfix">
                {{ $posyandus->withQueryString()->links('pagination.custom') }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-header {
            border-bottom: none;
            background-color: #007bff !important; /* bg-primary - biru tua */
        }
        .table th {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #007bff; /* bg-primary - biru tua */
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
        /* Tombol action tetap warna default */
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        .btn-group form {
            display: inline;
        }
        .bg-gradient-primary {
            background-color: #007bff !important; /* bg-primary */
        }
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4em 0.8em;
            border-radius: 12px;
            background-color: #cce5ff; /* biru muda seperti sidebar-light-primary */
            color: #004085;
            border: none;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05); /* biru sangat transparan */
            transition: all 0.3s ease;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(248, 250, 252, 0.8);
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 123, 255, 0.1);
            border-radius: 8px;
        }
        .form-select, .form-control {
            border-radius: 6px;
            border: 1px solid #d1d5db;
        }
        .form-select:focus, .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .bg-light {
            background-color: #f8f9fa !important; /* warna light default */
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .btn-primary {
            background-color: #007bff; /* bg-primary */
            border-color: #007bff;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d; /* bg-secondary */
            border-color: #6c757d;
            border-radius: 6px;
            color: white;
        }
        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }
        .text-muted {
            color: #6c757d !important;
        }
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            color: #155724;
        }
        .card-title.text-white {
            color: white !important;
        }
        
        /* Warna sesuai konfigurasi AdminLTE */
        :root {
            --primary: #007bff;        /* bg-primary - biru tua */
            --light-primary: #cce5ff;  /* sidebar-light-primary - biru muda */
            --secondary: #6c757d;
        }
    </style>
@stop