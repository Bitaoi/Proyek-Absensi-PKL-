<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 5px;
            font-weight: bold;
        }
        h1 {
            font-size: 16pt;
        }
        h2 {
            font-size: 12pt;
            color: #555;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <h2>Bulan: {{ $monthName }} Tahun: {{ $year }}</h2>
    <p class="meta-info">Tanggal Export: {{ (new DateTime())->format('d F Y') }}</p>

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
                    <td>{{ (new DateTime($guest->timestamp))->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data absensi untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>