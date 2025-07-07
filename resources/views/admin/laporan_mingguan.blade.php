@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    {{-- Filter Card untuk Navigasi Minggu --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Filter Laporan Mingguan</h5>
            <div class="d-flex justify-content-between align-items-center">
                {{-- Tombol untuk pindah ke minggu sebelumnya --}}
                <a href="{{ route('admin.laporanMingguan', ['date' => $previousWeekDate]) }}" class="btn btn-outline-secondary">&laquo; Minggu Sebelumnya</a>
                
                {{-- Teks yang menunjukkan periode minggu yang sedang ditampilkan --}}
                <span class="font-weight-bold text-center">
                    {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}
                </span>
                
                {{-- Tombol untuk pindah ke minggu berikutnya --}}
                <a href="{{ route('admin.laporanMingguan', ['date' => $nextWeekDate]) }}" class="btn btn-outline-secondary">Minggu Berikutnya &raquo;</a>
            </div>
            <div class="text-center mt-3">
                {{-- Tombol untuk kembali ke laporan minggu ini --}}
                <a href="{{ route('admin.laporanMingguan') }}" class="btn btn-primary">Kembali ke Minggu Ini</a>
            </div>
        </div>
    </div>

    <h1 class="mb-1">Laporan Absensi Mingguan</h1>
    <p class="lead mb-4">Menampilkan rekap absensi dari tanggal <strong>{{ $startDate->format('d F Y') }}</strong> hingga <strong>{{ $endDate->format('d F Y') }}</strong>.</p>

    {{-- Tabel data absensi --}}
    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Tujuan Kunjungan</th>
                    <th>Waktu Absen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guestsMingguan as $index => $guest)
                    <tr>
                        <td>{{ $guestsMingguan->firstItem() + $index }}</td>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td>
                        <td>{{ (new DateTime($guest->timestamp))->format('d F Y, H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">Tidak ada data absensi untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Navigasi halaman (pagination) --}}
    <div class="d-flex justify-content-center mb-4">
        {{ $guestsMingguan->links() }}
    </div>

    {{-- Tombol Aksi (Ekspor dan Kembali) --}}
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            {{-- Tombol ekspor kini menyertakan tanggal agar data yang diekspor sesuai --}}
            <a href="{{ route('admin.exportMingguan', ['type' => 'excel', 'date' => $startDate->format('Y-m-d')]) }}" class="btn btn-success">Unduh Excel</a>
            <a href="{{ route('admin.exportMingguan', ['type' => 'pdf', 'date' => $startDate->format('Y-m-d')]) }}" class="btn btn-danger">Unduh PDF</a>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection
