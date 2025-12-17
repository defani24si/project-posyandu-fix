@extends('adminlte::page')

@section('title', 'Detail Layanan Posyandu')

@section('content_header')
    <h1>Detail Layanan Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Informasi Layanan Posyandu</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary">Informasi Warga</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nama:</th>
                            <td>{{ $layananPosyandu->warga->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon:</th>
                            <td>{{ $layananPosyandu->warga->no_telepon ?? '-' }}</td>
                        </tr>
                    </table>

                    <h5 class="text-primary mt-4">Informasi Posyandu</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Posyandu:</th>
                            <td>{{ $layananPosyandu->jadwal->posyandu->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal:</th>
                            <td>{{ $layananPosyandu->jadwal->tanggal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tema:</th>
                            <td>{{ $layananPosyandu->jadwal->tema ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-primary">Data Kesehatan</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Berat Badan:</th>
                            <td>
                                @if($layananPosyandu->berat)
                                    <span class="badge badge-info">{{ number_format($layananPosyandu->berat, 1) }} kg</span>
                                @else
                                    <span class="text-muted">Tidak diukur</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tinggi Badan:</th>
                            <td>
                                @if($layananPosyandu->tinggi)
                                    <span class="badge badge-info">{{ number_format($layananPosyandu->tinggi, 1) }} cm</span>
                                @else
                                    <span class="text-muted">Tidak diukur</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Vitamin:</th>
                            <td>
                                @if($layananPosyandu->vitamin)
                                    <span class="badge badge-success">{{ $layananPosyandu->vitamin }}</span>
                                @else
                                    <span class="text-muted">Tidak diberikan</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($layananPosyandu->konseling)
                    <h5 class="text-primary mt-4">Konseling</h5>
                    <div class="alert alert-light">
                        {{ $layananPosyandu->konseling }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
            <a href="{{ route('layanan-posyandu.edit', $layananPosyandu->layanan_id) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('layanan-posyandu.index') }}" class="btn btn-secondary">
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
        .alert-light {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
        }
    </style>
@stop