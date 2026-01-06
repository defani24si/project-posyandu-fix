@extends('adminlte::page')

@section('title', 'Data User')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="m-0">
                <i class="fas fa-users-cog text-primary"></i>
                Data User
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data User</li>
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

    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="card-title text-white mb-0">
                        <i class="fas fa-list mr-2"></i>
                        Daftar User
                    </h3>
                </div>
                <div class="col-auto">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('users.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus mr-1"></i> Tambah User
                    </a>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <!-- FORM SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <form method="GET" action="{{ route('users.index') }}" class="bg-light p-3 rounded">
                        <div class="row align-items-end">
                            <!-- SEARCH -->
                            <div class="col-md-6 mb-2">
                                <label class="form-label text-sm font-weight-bold">Pencarian</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari nama atau email..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- RESET -->
                            <div class="col-md-6 mb-2">
                                @if(request('search'))
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- STATISTICS CARDS -->
            <div class="row mb-4">
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total User</span>
                            <span class="info-box-number">{{ $users->total() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-user-shield"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Admin</span>
                            <span class="info-box-number">{{ $users->filter(function($item) { return $item->role == 'admin'; })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-user-nurse"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Kader</span>
                            <span class="info-box-number">{{ $users->filter(function($item) { return $item->role == 'kader'; })->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">User Biasa</span>
                            <span class="info-box-number">{{ $users->filter(function($item) { return $item->role == 'user'; })->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center" width="10%">
                                <i class="fas fa-image mr-1"></i>
                                Foto Profil
                            </th>
                            <th width="25%">
                                <i class="fas fa-user mr-1"></i>
                                Nama
                            </th>
                            <th width="30%">
                                <i class="fas fa-envelope mr-1"></i>
                                Email
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-user-tag mr-1"></i>
                                Role
                            </th>
                            <th class="text-center" width="15%">
                                <i class="fas fa-cogs mr-1"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td class="text-center font-weight-bold text-primary">
                                    {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                </td>
                                <td class="text-center">
                                    @if($user->foto_profil)
                                        <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                                             alt="Foto Profil" 
                                             class="img-circle"
                                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"
                                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'50\' height=\'50\'%3E%3Crect width=\'50\' height=\'50\' fill=\'%236c757d\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'white\'%3E%3C/text%3E%3C/svg%3E';">
                                    @else
                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope mr-1"></i>
                                        {{ $user->email }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    @if($user->role === 'admin')
                                        <span class="badge badge-danger">Admin</span>
                                    @elseif($user->role === 'kader')
                                        <span class="badge badge-primary">Kader</span>
                                    @else
                                        <span class="badge badge-info">User</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- TOMBOL SHOW/DETAIL -->
                                        <a href="{{ route('users.show', $user->id) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if(Auth::check() && Auth::user()->role === 'admin')
                                        <!-- TOMBOL EDIT - Hanya untuk Admin -->
                                        <a href="{{ route('users.edit', $user->id) }}" 
                                           class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- TOMBOL DELETE - Hanya untuk Admin -->
                                        <form action="{{ route('users.destroy', $user->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-3x mb-3 text-muted"></i>
                                        <h5>Tidak ada data user</h5>
                                        <p class="mb-0">
                                            @if(request('search'))
                                                Tidak ditemukan user dengan kriteria pencarian tersebut.
                                                <br>
                                                <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-undo mr-1"></i> Reset Pencarian
                                                </a>
                                            @else
                                                Belum ada data user yang tersedia.
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <br>
                                                <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary mt-2">
                                                    <i class="fas fa-plus mr-1"></i> Tambah User Pertama
                                                </a>
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- PAGINATION -->
        @if($users->hasPages())
        <div class="card-footer bg-light">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted">
                        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} 
                        dari {{ $users->total() }} data
                    </small>
                </div>
                <div class="col-md-6">
                    {{ $users->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .card-header {
            border-radius: 10px 10px 0 0 !important;
            border-bottom: none;
        }
        
        .info-box {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
        }
        
        .table td {
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        
        .btn-group .btn {
            border-radius: 4px !important;
            margin-right: 2px;
        }
        
        .btn-group .btn:last-child {
            margin-right: 0;
        }
        
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        
        .empty-state {
            padding: 2rem;
        }
        
        .form-label {
            margin-bottom: 0.25rem;
            font-size: 0.875rem;
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
            border-radius: 8px;
            border: none;
        }
        
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
    </style>
@stop

