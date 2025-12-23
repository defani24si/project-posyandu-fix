
<!-- Nav Bar Start -->
<nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top" style="z-index: 1030;">
    <div class="container-fluid">
        <a href="{{ url('/') }}" class="navbar-brand">Posyandu</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav ml-auto">
                <a href="/" class="nav-item nav-link active">Home</a>
                <a href="{{ route('posyandu.index') }}" class="nav-item nav-link">Posyandu</a>
                <a href="{{ route('jadwal_posyandu.index') }}" class="nav-item nav-link">Jadwal Posyandu</a>
                <a href="{{ route('kader-posyandu.index') }}" class="nav-item nav-link">Kader Posyandu</a>
                <a href="{{ route('layanan-posyandu.index') }}" class="nav-item nav-link">Layanan Posyandu</a>
                <a href="{{ route('catatan-imunisasi.index') }}" class="nav-item nav-link">Catatan Imunisasi</a>
            </div>
        </div>
    </div>
</nav>
<!-- Nav Bar End -->