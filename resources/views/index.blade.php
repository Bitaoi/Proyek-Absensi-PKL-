<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
</head>
<body>
    <h1>Daftar Produk</h1>
    <ul>
        @foreach ($produk as $item)
            <li>{{ $item['nama'] }} - Rp{{ number_format($item['harga'], 0, ',', '.') }}</li>
        @endforeach
    </ul>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
</head>
<body>
    <h1>Daftar Produk</h1>
    <ul>
        @foreach ($produk as $item)
            <li>{{ $item['nama'] }} - Rp{{ number_format($item['harga'], 0, ',', '.') }}</li>
        @endforeach
    </ul>
</body>
</html>
