@extends('adminlte::page')

@section('title', 'Detail User')

@section('content_header')
    <h1>Detail User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    @if($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                             alt="Foto Profil" 
                             class="img-circle img-thumbnail"
                             style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;"
                             onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="img-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 200px; height: 200px; border-radius: 50%; display:none;">
                            <i class="fa fa-user text-white" style="font-size: 80px;"></i>
                        </div>
                    @else
                        <div class="img-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" 
                             style="width: 200px; height: 200px; border-radius: 50%;">
                            <i class="fa fa-user text-white" style="font-size: 80px;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nama</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
@stop

