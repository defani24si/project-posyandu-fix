<aside class="sidebar sidebar-dark sidebar-expand-lg bg-primary border-end collapse" id="sidebar" style="min-height: 100vh; width: 250px; position: fixed; top: 56px; left: 0; z-index: 1000; padding-top: 1rem;">
    <div class="sidebar-content">
        <div class="sidebar-header text-center py-3 mb-3">
            <h5 class="text-white mb-0 fw-bold">
                <i class="fas fa-clipboard-list me-2"></i>Menu
            </h5>
        </div>
        <nav class="sidebar-nav px-2">
            <ul class="nav flex-column">
                <li class="nav-item mb-1">
                    <a class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active bg-white bg-opacity-25 rounded' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a class="nav-link text-white {{ request()->routeIs('posyandu.*') ? 'active bg-white bg-opacity-25 rounded' : '' }}" href="{{ route('posyandu.index') }}">
                        <i class="fas fa-hospital me-2"></i> Posyandu
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-white {{ request()->routeIs('jadwal_posyandu.*') ? 'active bg-white bg-opacity-25 rounded' : '' }}" href="{{ route('jadwal_posyandu.index') }}">
                        <i class="fas fa-calendar me-2"></i> Jadwal Posyandu
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link text-white {{ request()->routeIs('users.*') ? 'active bg-white bg-opacity-25 rounded' : '' }}" href="{{ route('users.index') }}">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>

<style>
    .sidebar {
        transition: all 0.3s ease;
    }
    
    .sidebar.collapse:not(.show) {
        display: none;
    }
    
    .sidebar .nav-link {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }
    
    .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.25) !important;
        font-weight: 600;
    }
    
    @media (min-width: 992px) {
        .sidebar {
            display: block !important;
        }
        
        main.content {
            margin-left: 250px !important;
        }
    }
</style>

