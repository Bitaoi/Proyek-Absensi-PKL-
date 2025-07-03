<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <h2>Bulan: {{ $monthName }} Tahun: {{ $year }}</h2>
    <p>Tanggal Export: {{ $date }}</p>

    <table>
        <thead>
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
            @forelse($guests as $index => $guest)
                <tr>
                    <td>{{ $index + 1 }}</td>
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
                    <td colspan="8" class="text-center">Tidak ada data absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
