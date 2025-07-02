@extends('layouts.admin') {{-- Ganti ke 'layouts.admin' jika itu layout admin Anda, atau 'layouts.app' jika Anda ingin menggunakan yang default Laravel --}}

@section('content')
<div class="container mt-4"> {{-- Sangat penting untuk membungkus konten Anda dalam container --}}
    <style>
        /* CSS yang Anda berikan */
        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 6px;
            width: 250px;
        }

        .search-button {
            padding: 6px 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; /* Tambahkan margin bawah agar tidak terlalu mepet dengan tombol */
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn-group {
            margin-top: 20px;
        }

        .btn-custom {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 5px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
        }

        .btn-success:hover {
            background-color: #1e7e34;
        }

        .btn-info {
            background-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #117a8b;
        }
    </style>

    <h1>Dashboard Admin</h1>
    <p>Selamat Datang, Admin</p>
    <p>Ringkasan Absensi Hari Ini: {{ $absensiToday }}</p>

    {{-- Form Pencarian --}}
    <form action="{{ route('admin.dashboard') }}" method="GET" class="search-form">
        <input type="text" name="search" class="search-input" placeholder="Cari nama atau tanggal (yyyy-mm-dd)" value="{{ request('search') }}">
        <button type="submit" class="search-button">Cari</button>
    </form>

    <h2>Rekap Absensi Hari Ini</h2> {{-- Tambahkan judul ini --}}

    {{-- Tabel Data Tamu --}}
    <table>
        <thead>
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
                    <td>{{ $guest->timestamp }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Data tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Navigasi --}}
    <div class="btn-group">
        <a href="{{ route('admin.laporanMingguan') }}" class="btn-custom btn-primary">Laporan Mingguan</a>
        <a href="{{ route('admin.laporanBulanan') }}" class="btn-custom btn-primary">Laporan Bulanan</a>
        <a href="{{ route('admin.export') }}" class="btn-custom btn-success">Export Data</a>
        <a href="{{ route('admin.aktivitas') }}" class="btn-custom btn-info">Lihat Aktivitas Admin</a>
    </div>

    {{-- Pagination --}}
    <div style="margin-top: 20px;">
        {{ $guests->links() }}
    </div>
</div>
@endsection