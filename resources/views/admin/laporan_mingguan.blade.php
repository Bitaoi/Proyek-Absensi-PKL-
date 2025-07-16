<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Mingguan</title>
    @extends('layouts.admin')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @section('content')
</head>

<body>
<h1 class="mb-3">Laporan Absensi Mingguan</h1>
<div class="mt-4">
    <div class="card mb-4 shadow-sm">
        <div class="">

            <div class="d-flex justify-content-end align-items-center">
                <h5 class="card-title me-auto mb-0">Filter Laporan</h5>
                <div class="btn-group" role="group" aria-label="Navigasi Minggu">
                    <a href="{{ route('admin.laporanMingguan', ['start_date' => $prevWeekStartDate, 'end_date' => $prevWeekEndDate]) }}" class="btn btn-outline-secondary"> &laquo; Minggu Lalu</a>
                </div>
                
                <div class="btn-group" role="group" aria-label="tengah">
                    <a href="{{ route('admin.laporanMingguan') }}" class="btn btn-outline-primary">Minggu Ini</a>
                </div>
                <div class="btn-group" role="group" aria-label="akhir">
                    <a href="{{ route('admin.laporanMingguan', ['start_date' => $nextWeekStartDate, 'end_date' => $nextWeekEndDate]) }}" class="btn btn-outline-secondary">Minggu Depan &raquo;</a>
                </div>
                </div>
            </div>

            <hr>


            <p class="mb-2"><strong>Pilih Rentang Tanggal Kustom:</strong></p>
            <form action="{{ route('admin.laporanMingguan') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-5">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-5">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <button type="submit" class="btn w-100" id="filter">Filter</button> {{-- Menggunakan w-100 agar tombol memenuhi kolom --}}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <h1 class="mb-1">Laporan Absensi</h1>
    <p class="lead mb-4">Menampilkan rekap absensi dari tanggal <strong>{{ $startDate->format('d F Y') }}</strong> hingga <strong>{{ $endDate->format('d F Y') }}</strong>.</p>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Tujuan Kunjungan</th>
                    <th>Waktu Absen</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guestsMingguan as $index => $guest)
                    <tr>
                        <td>{{ $guestsMingguan->firstItem() + $index }}</td>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->address }}</td>
                        <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td>
                        <td>{{ (new DateTime($guest->timestamp))->format('d F Y, H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Tidak ada data absensi untuk periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mb-4">
        {{ $guestsMingguan->links() }}
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <a href="{{ route('admin.exportMingguan', ['type' => 'excel', 'start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="btn" id="excel">Unduh Excel</a>
            <a href="{{ route('admin.exportMingguan', ['type' => 'pdf', 'start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="btn" id="pdf">Unduh PDF</a>
        </div>
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn">Kembali</a>
        </div>
    </div>
@endsection
</body>

<style>
    body{
        background-color: aliceblue;
    }

    .btn{
        background-color: #3b818a;
        color: whitesmoke;
        -webkit-border-radius: 25px;
        -moz-border-radius: 25px;
        border-radius: 25px;
    }

    .btn:hover{
        background-color:rgba(160, 181, 183, 0.21);
        color:rgb(16, 80, 89);
        transition: 0.5s;
    }

    #excel{
        background-color: #10793F;
    }

    #pdf{
        background-color: #F40F02;
    }

    #pdf:hover{
        background-color:rgb(153, 14, 44);
        color: whitesmoke;
        transition: 0.5s;
    }

    #excel:hover{
        background-color:rgb(3, 53, 26);
        color: whitesmoke;
        transition: 0.5s;
    }
</style>