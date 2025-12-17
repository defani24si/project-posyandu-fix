@extends('adminlte::page')

@section('title', 'Detail Jadwal Posyandu')

@section('content_header')
    <h1>Detail Jadwal Posyandu</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama Posyandu</th>
                    <td>{{ $jadwalPosyandu->posyandu->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($jadwalPosyandu->tanggal)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Tema</th>
                    <td>{{ $jadwalPosyandu->tema }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $jadwalPosyandu->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Poster Kegiatan</th>
                    <td>
                        @if($jadwalPosyandu->poster_kegiatan)
                            <img src="{{ asset('storage/' . $jadwalPosyandu->poster_kegiatan) }}" 
                                 alt="Poster Kegiatan" 
                                 class="img-thumbnail"
                                 style="max-width: 300px; max-height: 300px; cursor: pointer;"
                                 data-toggle="modal" 
                                 data-target="#posterModal">
                        @else
                            <span class="text-muted">Tidak ada poster</span>
                        @endif
                    </td>
                </tr>
            </table>
            <a href="{{ route('jadwal_posyandu.index') }}" class="btn btn-secondary">Kembali</a>
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('jadwal_posyandu.edit', $jadwalPosyandu->jadwal_id) }}" class="btn btn-primary">Edit</a>
            @endif
        </div>
    </div>

    @if($jadwalPosyandu->poster_kegiatan)
    <!-- Modal untuk preview poster -->
    <div class="modal fade" id="posterModal" tabindex="-1" role="dialog" aria-labelledby="posterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="posterModalLabel">Poster Kegiatan - {{ $jadwalPosyandu->tema }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('storage/' . $jadwalPosyandu->poster_kegiatan) }}" 
                         alt="Poster Kegiatan" 
                         class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    @endif
@stop
