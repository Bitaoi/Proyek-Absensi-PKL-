@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Dashboard Admin</h1>
        <p class="lead">Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</p>

        @isset($absensiToday)
            <p>Ringkasan Absensi Hari Ini: {{ $absensiToday }}</p>
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

        <h2>Rekap Absensi Hari Ini</h2>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Tujuan</th>
                        <th>Waktu Absen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $guest)
                        <tr>
                            <td>{{ $guest->name }}</td>
                            <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td>
                            {{-- Menggunakan DateTime bawaan PHP untuk format tanggal --}}
                            <td>{{ (new DateTime($guest->timestamp))->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Tidak ada absensi hari ini.</td>
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
                <a href="{{ route('admin.laporanBulanan') }}" class="btn btn-primary btn-block">Laporan Bulanan</a>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <a href="{{ route('admin.export', ['type' => 'excel', 'month' => (new DateTime())->format('m'), 'year' => (new DateTime())->format('Y')]) }}" class="btn btn-success btn-block">Export Data</a>
            </div>
            <div class="col-md-3 col-sm-6 mb-2">
                <a href="{{ route('admin.aktivitas') }}" class="btn btn-info btn-block">Lihat Aktivitas Admin</a>
            </div>
        </div>
    </div>
@endsection
