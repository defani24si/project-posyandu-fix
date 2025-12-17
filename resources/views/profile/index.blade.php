@extends('adminlte::page')

@section('title', 'Profil Saya')

@section('content_header')
    <h1>Profil Saya</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Profile Information -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($user->foto_profil)
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('storage/' . $user->foto_profil) }}"
                                 alt="User profile picture"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('vendor/adminlte/dist/img/user4-128x128.jpg') }}"
                                 alt="User profile picture">
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ ucfirst($user->role) }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Email</b> <span class="float-right">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Role</b> <span class="float-right">{{ ucfirst($user->role) }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Bergabung</b> <span class="float-right">{{ $user->created_at->format('d M Y') }}</span>
                        </li>
                    </ul>

                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#activity" data-toggle="tab">
                                <i class="fas fa-user"></i> Informasi Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#settings" data-toggle="tab">
                                <i class="fas fa-cog"></i> Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Profile Information Tab -->
                        <div class="active tab-pane" id="activity">
                            <div class="row">
                                <div class="col-12">
                                    <h5><i class="fas fa-info-circle text-primary"></i> Informasi Akun</h5>
                                    <hr>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Nama Lengkap:</strong></div>
                                        <div class="col-sm-9">{{ $user->name }}</div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Email:</strong></div>
                                        <div class="col-sm-9">{{ $user->email }}</div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Role:</strong></div>
                                        <div class="col-sm-9">
                                            <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Tanggal Bergabung:</strong></div>
                                        <div class="col-sm-9">{{ $user->created_at->format('d F Y, H:i') }}</div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Terakhir Update:</strong></div>
                                        <div class="col-sm-9">{{ $user->updated_at->format('d F Y, H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tab-pane" id="settings">
                            <h5><i class="fas fa-key text-warning"></i> Ubah Password</h5>
                            <hr>
                            
                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label for="current_password">Password Saat Ini</label>
                                    <input type="password" name="current_password" id="current_password" 
                                           class="form-control @error('current_password') is-invalid @enderror" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" name="password" id="password" 
                                           class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" required>
                                </div>
                                
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-key"></i> Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .profile-user-img {
            border: 3px solid #007bff;
        }
        .nav-pills .nav-link.active {
            background-color: #007bff;
        }
        .card-primary.card-outline {
            border-top: 3px solid #007bff;
        }
    </style>
@stop