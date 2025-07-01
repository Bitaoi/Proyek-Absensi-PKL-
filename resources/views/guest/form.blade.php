<!DOCTYPE html>
<html>
<head>
    <title>Form Buku Tamu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="style_form.css">
</head>
<body>

<h2>Formulir Buku Tamu</h2>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('guest.store') }}">
    @csrf
    <label>Nama Lengkap:</label><br>
    <input type="text" name="name" required><br><br>

    <label>Nomor HP:</label><br>
    <input type="text" name="phone_number" required><br><br>

    <label>Alamat:</label><br>
    <textarea name="address"></textarea><br><br>

    <label>Kecamatan:</label><br>
    <select name="kecamatan_id" id="kecamatan" required>
        <option value="">-- Pilih Kecamatan --</option>
        @foreach($kecamatan as $item)
            <option value="{{ $item->kecamatan_id }}">{{ $item->kecamatan_name }}</option>
        @endforeach
    </select><br><br>

    <label>Kelurahan:</label><br>
    <select name="kelurahan_id" id="kelurahan" required>
        <option value="">-- Pilih Kelurahan --</option>
    </select><br><br>

    <label>Tujuan Kunjungan:</label><br>
    <select name="purpose_id" id="purpose" required>
        <option value="">-- Pilih Tujuan --</option>
        @foreach($purposes as $item)
            <option value="{{ $item->purpose_id }}">{{ $item->purpose_name }}</option>
        @endforeach
    </select><br><br>

    <div id="divLainnya" style="display: none;">
        <label>Tujuan Lainnya:</label><br>
        <input type="text" name="other_purpose_description"><br><br>
    </div>

    <button type="submit">Simpan</button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        $('#kecamatan').on('change', function() {
            let id = $(this).val();
            if (id) {
                $.get('/kelurahan/' + id, function(data) {
                    $('#kelurahan').empty().append('<option value="">-- Pilih Kelurahan --</option>');
                    data.forEach(function(kel) {
                        $('#kelurahan').append('<option value="' + kel.kelurahan_id + '">' + kel.kelurahan_name + '</option>');
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Gagal memuat kelurahan: " + textStatus);
                });
            } else {
                $('#kelurahan').empty().append('<option value="">-- Pilih Kelurahan --</option>');
            }
        });

        $('#purpose').on('change', function() {
            let selected = $(this).find('option:selected').text();
            if (selected === 'Lainnya') {
                $('#divLainnya').show();
            } else {
                $('#divLainnya').hide();
            }
        });

    });
</script>


</body>
</html>
