<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Bulanan</title>
    @extends('layouts.admin')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    @section('content')
</head>

<body>
<<<<<<< HEAD
    <div class="mt-4">
=======
    <div class="container mt-4">
>>>>>>> ad1614231b0c85f7a1c064b92621ec34ace9f26f
        <h1 class="mb-3">Laporan Absensi Bulanan</h1>

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Filter Laporan</h5>
                <form action="{{ route('admin.laporanBulanan') }}" method="GET">
                    <div class="row align-items-end">
                        <div class="col-md-5 mt-3">
                            <label for="month" class="form-label">Bulan</label>
                            <select name="month" id="month" class="form-select">
                                @foreach($months as $key => $value)
                                    <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5 mt-3">
                            <label for="year" class="form-label">Tahun</label>
                            <select name="year" id="year" class="form-select">
                                @foreach($years as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mt-3 justify-content-end">
                            <button type="submit" class="btn btn-block w-20">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- PERBAIKAN: Mengubah $month menjadi (int)$month --}}
        <h2>Data Absensi Bulan {{ $months[(int)$month] }} Tahun {{ $year }}</h2>
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
                            <td>{{ (new DateTime($guest->timestamp))->format('d F Y, H:i:s') }}</td>
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
            <a href="{{ route('admin.export', ['type' => 'excel', 'month' => $month, 'year' => $year]) }}" class="btn" id="excel">Unduh Excel</a>
            <a href="{{ route('admin.export', ['type' => 'pdf', 'month' => $month, 'year' => $year]) }}" class="btn" id="pdf">Unduh PDF</a>
            <a href="{{ route('admin.dashboard') }}" class="btn float-end">Kembali</a>
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