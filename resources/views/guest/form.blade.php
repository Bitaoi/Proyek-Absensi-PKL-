<!DOCTYPE html>
<html>
<head>
    <title>Form Buku Tamu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style_form.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Formulir Buku Tamu</h2>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('guest.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Nomor HP:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Alamat:</label>
            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="kecamatan" class="form-label">Kecamatan:</label>
            <select class="form-select" name="kecamatan_id" id="kecamatan" required>
                <option value="">-- Pilih Kecamatan --</option>
                @foreach($kecamatan as $item)
                    <option value="{{ $item->kecamatan_id }}">{{ $item->kecamatan_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kelurahan" class="form-label">Kelurahan:</label>
            <select class="form-select" name="kelurahan_id" id="kelurahan" required>
                <option value="">-- Pilih Kelurahan --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="purpose" class="form-label">Tujuan Kunjungan:</label>
            <select class="form-select" name="purpose_id" id="purpose" required>
                <option value="">-- Pilih Tujuan --</option>
                @foreach($purposes as $item)
                    <option value="{{ $item->purpose_id }}">{{ $item->purpose_name }}</option>
                @endforeach
            </select>
        </div>

        <div id="divLainnya" class="mb-3" style="display: none;">
            <label for="other_purpose_description" class="form-label">Tujuan Lainnya:</label>
            <input type="text" class="form-control" id="other_purpose_description" name="other_purpose_description">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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