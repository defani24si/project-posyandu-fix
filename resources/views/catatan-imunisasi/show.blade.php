@extends('adminlte::page')

@section('title', 'Detail Catatan Imunisasi')

@section('content_header')
    <h1>Detail Catatan Imunisasi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title text-white">Informasi Catatan Imunisasi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="text-primary">Informasi Warga</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nama:</th>
                            <td>{{ $catatanImunisasi->warga->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No. Telepon:</th>
                            <td>{{ $catatanImunisasi->warga->no_telepon ?? '-' }}</td>
                        </tr>
                    </table>

                    <h5 class="text-primary mt-4">Informasi Imunisasi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Jenis Vaksin:</th>
                            <td><span class="badge badge-primary">{{ $catatanImunisasi->jenis_vaksin }}</span></td>
                        </tr>
                        <tr>
                            <th>Tanggal:</th>
                            <td>{{ $catatanImunisasi->tanggal ? $catatanImunisasi->tanggal->format('d F Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi:</th>
                            <td>{{ $catatanImunisasi->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Tenaga Kesehatan:</th>
                            <td>{{ $catatanImunisasi->nakes }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="text-primary">Scan Kartu Imunisasi</h5>
                    @if($catatanImunisasi->kartu_imunisasi_scan)
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $catatanImunisasi->kartu_imunisasi_scan) }}" 
                                 alt="Kartu Imunisasi" 
                                 class="img-fluid img-thumbnail" 
                                 style="max-height: 300px; cursor: pointer;"
                                 onclick="showImageModal('{{ asset('storage/' . $catatanImunisasi->kartu_imunisasi_scan) }}')">
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $catatanImunisasi->kartu_imunisasi_scan) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fa fa-external-link-alt"></i> Buka di tab baru
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fa fa-image fa-3x mb-3"></i>
                            <p>Tidak ada scan kartu imunisasi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'kader']))
            <a href="{{ route('catatan-imunisasi.edit', $catatanImunisasi->imunisasi_id) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>
            @endif
            <a href="{{ route('catatan-imunisasi.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Scan Kartu Imunisasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Kartu Imunisasi" class="img-fluid">
                </div>
            </div>
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
        .img-thumbnail {
            border: 2px solid #007bff;
        }
        .img-thumbnail:hover {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }
    </style>
@stop

@section('js')
    <script>
        function showImageModal(imageSrc) {
            $('#modalImage').attr('src', imageSrc);
            $('#imageModal').modal('show');
        }
    </script>
@stop