@extends('layouts.admin') {{-- Menggunakan layout admin. Pastikan 'layouts/admin.blade.php' ada --}}

@section('content')
    {{-- Semua elemen UI dashboard ada di sini --}}
    <h1>Dashboard Admin</h1>
    <p>Selamat Datang, {{ Auth::user()->name ?? 'Admin' }}</p>

    <p>Ringkasan Absensi Hari Ini: {{ $absensiToday }}</p>
    <p>Ringkasan Absensi Minggu Ini: {{ $absensiWeek }}</p>
    <p>Ringkasan Absensi Bulan Ini: {{ $absensiMonth }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tujuan</th>
                <th>Waktu Absen</th>
                {{-- Tambahkan kolom lain jika perlu dari tabel 'guests' --}}
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $guest)
                <tr>
                    <td>{{ $guest->name }}</td>
                    <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td>
                    <td>{{ $guest->timestamp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.laporanMingguan') }}" class="btn btn-primary">Laporan Mingguan</a>
    <a href="{{ route('admin.laporanBulanan') }}" class="btn btn-primary">Laporan Bulanan</a>
    <a href="{{ route('admin.export') }}" class="btn btn-success">Export Data</a>
    <a href="{{ route('admin.aktivitas') }}" class="btn btn-info">Lihat Aktivitas Admin</a>

    {{-- Anda juga mungkin ingin menambahkan form pencarian di sini --}}
    <form action="{{ route('admin.dashboard') }}" method="GET">
        <input type="text" name="search" placeholder="Cari nama/tanggal" value="{{ request('search') }}">
        <button type="submit">Cari</button>
    </form>
@endsection