@extends('adminlte::page')

@section('title', 'Detail Kader Posyandu')

@section('content_header')
    <h1>Detail Kader Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Informasi Kader Posyandu</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nama Kader:</th>
                            <td>{{ $kaderPosyandu->warga->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon:</th>
                            <td>{{ $kaderPosyandu->warga->no_telepon ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Posyandu:</th>
                            <td>{{ $kaderPosyandu->posyandu->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Posyandu:</th>
                            <td>{{ $kaderPosyandu->posyandu->alamat ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Peran:</th>
                            <td><span class="badge badge-primary">{{ $kaderPosyandu->peran }}</span></td>
                        </tr>
                        <tr>
                            <th>Mulai Tugas:</th>
                            <td>{{ $kaderPosyandu->mulai_tugas ? $kaderPosyandu->mulai_tugas->format('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Akhir Tugas:</th>
                            <td>
                                @if($kaderPosyandu->akhir_tugas)
                                    {{ $kaderPosyandu->akhir_tugas->format('d F Y') }}
                                @else
                                    <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if(!$kaderPosyandu->akhir_tugas || $kaderPosyandu->akhir_tugas->isFuture())
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('kader-posyandu.edit', $kaderPosyandu->kader_id) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('kader-posyandu.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-header {
            background-color: #007bff !important;
        }
        .card-title.text-white {
            color: white !important;
        }
        .badge {
            font-size: 0.9rem;
            padding: 0.5em 1em;
        }
    </style>
@stop