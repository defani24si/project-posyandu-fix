@extends('adminlte::page')

@section('title', 'Detail Data Warga')

@section('content_header')
    <h1>Detail Data Warga</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Informasi Data Warga</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary">Data Pribadi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">NIK:</th>
                            <td>{{ $warga->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama:</th>
                            <td>{{ $warga->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tempat Lahir:</th>
                            <td>{{ $warga->tempat_lahir }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir:</th>
                            <td>{{ $warga->tanggal_lahir->format('d F Y') }} ({{ $warga->umur }} tahun)</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin:</th>
                            <td>
                                <span class="badge badge-{{ $warga->jenis_kelamin == 'L' ? 'primary' : 'pink' }}">
                                    {{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-primary">Data Alamat & Kontak</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Alamat:</th>
                            <td>{{ $warga->alamat }}</td>
                        </tr>
                        <tr>
                            <th>RT/RW:</th>
                            <td>{{ $warga->rt }}/{{ $warga->rw }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon:</th>
                            <td>{{ $warga->no_telepon ?: '-' }}</td>
                        </tr>
                    </table>

                    <h5 class="text-primary mt-4">Data Keluarga</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nama Ayah:</th>
                            <td>{{ $warga->nama_ayah }}</td>
                        </tr>
                        <tr>
                            <th>Nama Ibu:</th>
                            <td>{{ $warga->nama_ibu }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Riwayat Layanan -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="text-primary">Riwayat Layanan Posyandu</h5>
                    @if($warga->layananPosyandu->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Posyandu</th>
                                        <th>Berat (kg)</th>
                                        <th>Tinggi (cm)</th>
                                        <th>Vitamin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warga->layananPosyandu->take(5) as $layanan)
                                    <tr>
                                        <td>{{ $layanan->jadwal->tanggal ?? '-' }}</td>
                                        <td>{{ $layanan->jadwal->posyandu->nama ?? '-' }}</td>
                                        <td>{{ $layanan->berat ? number_format($layanan->berat, 1) : '-' }}</td>
                                        <td>{{ $layanan->tinggi ? number_format($layanan->tinggi, 1) : '-' }}</td>
                                        <td>{{ $layanan->vitamin ?: '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada riwayat layanan posyandu</p>
                    @endif
                </div>
            </div>

            <!-- Riwayat Imunisasi -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5 class="text-primary">Riwayat Imunisasi</h5>
                    @if($warga->catatanImunisasi->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Jenis Vaksin</th>
                                        <th>Lokasi</th>
                                        <th>Nakes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($warga->catatanImunisasi->take(5) as $imunisasi)
                                    <tr>
                                        <td>{{ $imunisasi->tanggal->format('d/m/Y') }}</td>
                                        <td><span class="badge badge-success">{{ $imunisasi->jenis_vaksin }}</span></td>
                                        <td>{{ $imunisasi->lokasi }}</td>
                                        <td>{{ $imunisasi->nakes }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada riwayat imunisasi</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if(Auth::check() && Auth::user()->role === 'admin')
            <a href="{{ route('warga.edit', $warga->warga_id) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('warga.index') }}" class="btn btn-secondary">
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
        .badge-pink {
            background-color: #e91e63;
            color: white;
        }
        .thead-light th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: 600;
        }
    </style>
@stop