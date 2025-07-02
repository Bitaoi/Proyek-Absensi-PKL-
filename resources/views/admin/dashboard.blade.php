@extends('layouts.app') {{-- Pastikan Anda punya layouts.app, jika tidak bisa dihapus --}}

@section('content')

<p>Selamat Datang, Admin</p>

<p>Ringkasan Absensi Hari Ini: {{ $absensiToday }}</p>
<p>Ringkasan Absensi Minggu Ini: {{ $absensiWeek }}</p>
<p>Ringkasan Absensi Bulan Ini: {{ $absensiMonth }}</p>

{{-- Form Pencarian --}}
<form action="{{ route('dashboard') }}" method="GET" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Cari nama atau tanggal (yyyy-mm-dd)" value="{{ request('search') }}">
    <button type="submit">Cari</button>
</form>

{{-- Tabel Data Tamu --}}
<table border="1" cellpadding="5" cellspacing="0">
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
<div style="margin-top: 20px;">
    <a href="{{ route('admin.laporanMingguan') }}" class="btn btn-primary">Laporan Mingguan</a>
    <a href="{{ route('admin.laporanBulanan') }}" class="btn btn-primary">Laporan Bulanan</a>
    <a href="{{ route('admin.export') }}" class="btn btn-success">Export Data</a>
    <a href="{{ route('admin.aktivitas') }}" class="btn btn-info">Lihat Aktivitas Admin</a>
</div>

{{-- Pagination --}}
<div style="margin-top: 20px;">
    {{ $guests->links() }}
</div>

@endsection
