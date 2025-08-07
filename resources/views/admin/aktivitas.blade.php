@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-3">Log Aktivitas Admin</h1>
    <p class="lead">Halaman ini menampilkan catatan semua aktivitas penting yang dilakukan oleh pengguna admin.</p>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Cari Log Aktivitas</h5>
            <form action="{{ route('admin.aktivitas') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search_log" class="form-control" placeholder="Cari berdasarkan aksi, pengguna, atau deskripsi..." value="{{ request('search_log') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Waktu</th>
                    <th>Pengguna</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitasLogs as $index => $log)
                    <tr>
                        <td>{{ $aktivitasLogs->firstItem() + $index }}</td>
                        <td>{{ (new DateTime($log->created_at))->format('d F Y, H:i:s') }}</td>
                        <td>{{ $log->user->name ?? 'Sistem' }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada log aktivitas ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Navigasi halaman (pagination) --}}
    <div class="d-flex justify-content-center mb-4">
        {{ $aktivitasLogs->appends(request()->query())->links() }}
    </div>

    {{-- Tombol Kembali ke Dashboard diletakkan di pojok kanan bawah --}}
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection