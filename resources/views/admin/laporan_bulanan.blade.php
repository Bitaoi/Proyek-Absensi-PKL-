@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Laporan Absensi Bulanan</h1>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Filter Laporan</h5>
                <form action="{{ route('admin.laporanBulanan') }}" method="GET">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="month">Bulan</label>
                            <select name="month" id="month" class="form-control">
                                @foreach($months as $key => $value)
                                    <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="year">Tahun</label>
                            <select name="year" id="year" class="form-control">
                                @foreach($years as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <h2>Data Absensi Bulan {{ $months[$month] }} Tahun {{ $year }}</h2>
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>No. Telp</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Tujuan</th>
                        <th>Waktu Absen</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guestsBulanan as $index => $guest)
                        <tr>
                            <td>{{ $guestsBulanan->firstItem() + $index }}</td>
                            <td>{{ $guest->name }}</td>
                            <td>{{ $guest->phone_number }}</td>
                            <td>{{ $guest->address }}</td>
                            <td>{{ $guest->kecamatan->kecamatan_name ?? '-' }}</td>
                            <td>{{ $guest->kelurahan->kelurahan_name ?? '-' }}</td>
                            <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td>
                            {{-- Menggunakan DateTime bawaan PHP untuk format tanggal --}}
                            <td>{{ (new DateTime($guest->timestamp))->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">Tidak ada data absensi untuk bulan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mb-4">
            {{ $guestsBulanan->appends(request()->query())->links() }}
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.export', ['type' => 'excel', 'month' => $month, 'year' => $year]) }}" class="btn btn-success mr-2">Unduh Excel</a>
            <a href="{{ route('admin.export', ['type' => 'pdf', 'month' => $month, 'year' => $year]) }}" class="btn btn-danger">Unduh PDF</a>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>
@endsection
