@extends('layouts.admin') 
@section('content')
    <div class="container mt-4">
        <h1>Laporan Absensi Mingguan</h1>
        <p>Halaman ini akan menampilkan rekap absensi pengunjung secara mingguan.</p>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Tujuan</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($guestsMingguan as $guest) --}}
                {{--    <tr> --}}
                {{--        <td>{{ $guest->name }}</td> --}}
                {{--        <td>{{ $guest->timestamp->format('Y-m-d') }}</td> --}}
                {{--        <td>{{ $guest->purpose->purpose_name ?? $guest->other_purpose_description }}</td> --}}
                {{--    </tr> --}}
                {{-- @endforeach --}}
            </tbody>
        </table>
    

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>
@endsection