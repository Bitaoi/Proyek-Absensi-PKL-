@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-1">Laporan Absensi Mingguan</h1>
    <p class="lead mb-4">Menampilkan rekap absensi dari tanggal <strong>{{ $startDate->format('d F Y') }}</strong> hingga <strong>{{ $endDate->format('d F Y') }}</strong>.</p>

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
                        <td colspan="4" class="text-center text-muted py-3">Tidak ada data absensi dalam 7 hari terakhir.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mb-4">
        {{ $guestsMingguan->links() }}
    </div>

    {{-- BAGIAN YANG HILANG DAN SEKARANG DITAMBAHKAN KEMBALI --}}
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('admin.exportMingguan', ['type' => 'excel']) }}" class="btn btn-success">Unduh Excel</a>
            <a href="{{ route('admin.exportMingguan', ['type' => 'pdf']) }}" class="btn btn-danger">Unduh PDF</a>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection