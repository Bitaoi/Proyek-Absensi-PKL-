<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Aplikasi Buku Tamu')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

    {{-- Header --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Buku Tamu</a>
        </div>
    </nav>

    <div class="container mt-4">
        {{-- Konten dinamis --}}
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-4">
        &copy; {{ date('Y') }} Aplikasi Buku Tamu
    </footer>

</body>
</html>
