<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Aplikasi Buku Tamu</title>
    
    {{-- Memuat CSS dan JS dari Vite (cukup satu kali) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Memuat CSS Bootstrap dari CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9yj0n" crossorigin="anonymous">

    <style>
        .navbar {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.3rem;
            letter-spacing: 1px;
            /* Pastikan tidak ada margin-right atau properti yang mendorongnya terlalu jauh */
            margin-right: 0; /* Override default jika ada */
        }

        /* Ini adalah div yang akan menampung navbar-brand dan tombol logout */
        .navbar-header-custom {
            display: flex; 
            align-items: center;
            justify-content: space-between;
            width: 100%; 
        }

        .logout-btn-wrapper {
            margin-left: 100px; /* Mendorong ke kanan */
            margin-right: 0; /* Sesuaikan jarak dari kanan jika diperlukan */
        }


        .navbar-nav .nav-link {
            transition: color 0.3s, background-color 0.3s;
            padding: 8px 12px;
            border-radius: 4px;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #f8f9fa;
        }

        .navbar-nav .active > .nav-link,
        .navbar-nav .nav-link.active {
            background-color: #007bff;
            color: #fff !important;
        }

        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Hilangkan CSS tambahan sebelumnya jika tidak lagi relevan */
        /* .navbar-nav.ml-auto .nav-item {
            display: flex;
            align-items: center;
        } */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="navbar-header-custom">
            <a class="navbar-brand m-3" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>

            <div class="logout-btn-wrapper">
                <a href="{{ route('admin.logout') }}" class="btn btn-danger my-2 my-lg-0"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.laporanMingguan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.laporanMingguan') }}">Laporan Mingguan</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.laporanBulanan') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.laporanBulanan') }}">Laporan Bulanan</a>
                </li>
                <li class="nav-item {{ Request::routeIs('admin.aktivitas') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.aktivitas') }}">Aktivitas Admin</a>
                </li>
            </ul>
        </div>
    </nav>
    </nav> 

    <main class="py-4">
        <div class="container mt-4">
            @yield('content')
        </div>
    </main>

    <footer class="bg-light text-center text-lg-start mt-5 py-3">
        <div class="text-center p-3">
            &copy; {{ date('Y') }} Aplikasi Buku Tamu
        </div>
    </footer>

    {{-- Skrip JavaScript untuk Bootstrap --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57B+U2LwF31Uf8kP91P/1Q4n" crossorigin="anonymous"></script>
</body>
</html>