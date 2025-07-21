<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Dashboard Admin</title>
    @extends('layouts.admin')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    @section('content')
</head>

<body>
<div class="container mt-4">
    <h1 class="mb-3">Dashboard Admin</h1>
    <p class="lead">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</p>

    @isset($absensiToday)
        <div class="alert alert-info">
            Ringkasan Absensi Hari Ini: <strong>{{ $absensiToday }}</strong>
        </div>
    @endisset

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Cari Absensi</h5>
            <form action="{{ route('admin.dashboard') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama atau tanggal (yyyy-mm-dd)" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h2 class="mb-3">Rekap Absensi Hari Ini</h2>
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tujuan</th>
                    <th>Waktu Absen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    <tr>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->address }}</td>
                        <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td>
                        <td>{{ (new DateTime($guest->timestamp))->format('d F Y, H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Tidak ada absensi hari ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mb-4">
        {{ $guests->links() }}
    </div>

    <h2 class="mb-3">Laporan & Aksi</h2>
    <div class="row">
        <div class="col-md-3 col-sm-6 mb-2">
            <a href="{{ route('admin.laporanMingguan') }}" class="btn btn-primary btn-block">Laporan Mingguan</a>
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            <a href="{{ route('admin.laporanBulanan') }}" class="btn btn-secondary btn-block">Laporan Bulanan</a>
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            {{-- PERBAIKAN: Menggunakan format 'n' untuk bulan tanpa awalan nol --}}
            <a href="{{ route('admin.export', ['type' => 'excel', 'month' => (new DateTime())->format('n'), 'year' => (new DateTime())->format('Y')]) }}" class="btn btn-success btn-block">Export Excel</a>
        </div>
        <div class="col-md-3 col-sm-6 mb-2">
            <a href="{{ route('admin.aktivitas') }}" class="btn btn-info btn-block">Lihat Aktivitas Admin</a>
        </div>
    </div>
</div>
@endsection    
</body>
