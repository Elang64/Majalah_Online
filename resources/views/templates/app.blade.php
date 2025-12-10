<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Majalah Online</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.min.css" rel="stylesheet" />
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
</head>
<style>
    :root {
        --primary: #2c5f7d;
        --secondary: #4a89ac;
        --accent: #e67e22;
        --light: #f8f9fa;
        --dark: #212529;
        --border: rgba(255, 255, 255, 0.2);
        --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    body {
        color: var(--dark);
        background: var(--light);
    }

    .navbar {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
    }

    .navbar.scrolled {
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.6rem;
        color: var(--primary) !important;
    }

    .nav-link {
        font-weight: 500;
        color: var(--primary) !important;
        padding: 0.5rem 1rem !important;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .nav-link:hover,
    .nav-link.active {
        background: var(--primary);
        color: white !important;
    }

    .dropdown-menu {
        border-radius: 16px;
        border: none;
        box-shadow: var(--shadow);
        padding: 0.75rem 0;
    }

    .dropdown-item {
        padding: 0.6rem 1.5rem;
        border-radius: 8px;
        margin: 0.2rem 0.8rem;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background: var(--primary);
        color: white;
    }

    .btn-primary,
    .btn-outline-primary,
    .btn-danger {
        border-radius: 30px;
        padding: 0.5rem 1.3rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary { background: var(--primary); border: none; }
    .btn-primary:hover { background: #1e4a66; transform: translateY(-2px); }
    .btn-outline-primary { color: var(--primary); border-color: var(--primary); }
    .btn-outline-primary:hover { background: var(--primary); color: white; }
    .btn-danger { background: #e74c3c; border: none; }

    .center-nav {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
    }

    .center-nav .navbar-nav {
        flex-direction: row;
        gap: 10px;
    }

    /* admin page*/
        .page-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

    @media (max-width: 991.98px) {
        .center-nav {
            position: static;
            transform: none;
            margin: 1rem 0;
        }
        .center-nav .navbar-nav {
            flex-direction: column;
            align-items: center;
        }
        .nav-link {
            width: 80%;
            text-align: center;
        }
    }
</style>

<body class="mt-5 pt-4">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top shadow-sm" style="border: 1px solid var(--light);">
        <div class="container-fluid mx-5">
            <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarSupportedContent">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand mt-2 mt-lg-0" href="#">
                  <i class="fas fa-book-open-reader me-2 fa-lg" style="color: var(--primary)"></i> ModernMag
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="center-nav">
                    <ul class="navbar-nav">
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-mdb-dropdown-init>
                                    <i class="fas fa-database me-1"></i> Data Master
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('admin.magazines.index') }}"><i class="fas fa-book me-2"></i> Data Majalah</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.promos.index') }}"><i class="fas fa-tag me-2"></i> Data Promo</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}"><i class="fas fa-users me-2"></i> Data Petugas</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-bar-chart me-1"></i> Dashboard
                                </a>
                            </li>

                        @elseif (Auth::check() && Auth::user()->role == 'staff')
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <i class="fas fa-receipt me-1"></i> Data Transaksi
                                </a>
                            </li>

                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="fas fa-home me-1"></i> Beranda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home.magazines.all') }}">
                                    <i class="fas fa-book me-1"></i> Majalah
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('magazines.purchased') }}">
                                    <i class="fas fa-heart me-1"></i> Koleksi Saya
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="d-flex align-items-center">
                @if (Auth::check())
                    <a href="{{ route('logout') }}" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-rounded me-2">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                        <a href="{{ route('signup') }}" class="btn btn-primary btn-rounded">
                            <i class="fas fa-user-plus me-1"></i> Daftar
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.1.0/mdb.umd.min.js"></script>

    @stack('script')
</body>
</html>
