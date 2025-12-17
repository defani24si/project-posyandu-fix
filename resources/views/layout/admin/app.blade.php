<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.admin.css')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-primary border-bottom">
        <div class="container-fluid">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-hospital me-2"></i>Sistem Posyandu
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name ?? 'User' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="d-flex">
        <!-- Sidebar -->
        @include('layout.admin.sidebar')
        
        <!-- Main Content -->
        <main class="content" style="margin-left: 0; width: 100%; padding-top: 70px;">
            @include('layout.admin.content')
            @include('layout.admin.footer')
        </main>
    </div>
    
    @include('layout.admin.js')
</body>
</html>

