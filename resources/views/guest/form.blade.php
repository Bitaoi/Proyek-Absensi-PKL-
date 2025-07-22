<!DOCTYPE html>
<html>
<head>
    <title>Form Buku Tamu</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>


<div class="logo pt-5 d-flex justify-content-center">
    <img src="{{ asset('image/fix_logo.png') }}" alt="Logo Perusahaan" class="logo-img img-fluid w-80">
</div>


<div class="mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-4 col-sm-8 form_box">
            <h2 class="judul mb-4">Formulir Buku Tamu</h2>

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('guest.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap Anda" required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Nomor HP:</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan Nomor HP Anda" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat:</label>
                    <textarea class="form-control" id="address" name="address" placeholder="Masukkan Alamat Anda" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan:</label>
                    <select class="form-select" name="kecamatan_id" id="kecamatan">
                        <option value="">Luar Kota / Tidak Ada</option>
                        @foreach($kecamatan as $item)
                            <option value="{{ $item->kecamatan_id }}">{{ $item->kecamatan_name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="kelurahan" class="form-label">Kelurahan:</label>
                    <select class="form-select" style="opacity:0.5;" name="kelurahan_id" id="kelurahan">
                        <option value="">Luar Kota / Tidak Ada</option>
                    </select>
                </div>



                <div class="mb-3">
                    <label for="purpose" class="form-label">Tujuan Kunjungan:</label>
                    <select class="form-select" name="purpose_id" id="purpose" required>
                        <option value=""> Pilih Tujuan </option>
                        @foreach($purposes as $item)
                            <option value="{{ $item->purpose_id }}">{{ $item->purpose_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="divLainnya" class="mb-3" style="display: none;">
                    <label for="other_purpose_description" class="form-label">Tujuan Lainnya:</label>
                    <input type="text" class="form-control" id="other_purpose_description" name="other_purpose_description">
                </div>

                <div class="d-grid gap-2 justify-content-end">
                    <button type="submit" class="btn">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        $('#kecamatan').on('change', function() {
            let id = $(this).val();
            if (id) {
                $.get('/kelurahan/' + id, function(data) {
                    $('#kelurahan').empty().append('<option value=""> Pilih Kelurahan </option>');
                    data.forEach(function(kel) {
                        $('#kelurahan').append('<option value="' + kel.kelurahan_id + '">' + kel.kelurahan_name + '</option>');
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Gagal memuat kelurahan: " + textStatus);
                });
            } else {
                $('#kelurahan').empty().append('<option value=""> Pilih Kelurahan </option>');
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


<script>
    $(document).ready(function () {

        $('#kecamatan').on('change', function() {
            let id = $(this).val();
            if (id) {
                // Set opacity kembali ke 1 saat kecamatan dipilih dan kelurahan akan dimuat
                $('#kelurahan').css('opacity', '1');
                $.get('/kelurahan/' + id, function(data) {
                    $('#kelurahan').empty().append('<option value=""> Pilih Kelurahan </option>');
                    data.forEach(function(kel) {
                        $('#kelurahan').append('<option value="' + kel.kelurahan_id + '">' + kel.kelurahan_name + '</option>');
                    });
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    alert("Gagal memuat kelurahan: " + textStatus);
                    $('#kelurahan').css('opacity', '0.5');
                });
            } else {
                $('#kelurahan').empty().append('<option value=""> Pilih Kelurahan </option>');
                $('#kelurahan').css('opacity', '0.5');
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



<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');

    *{
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }
    body{
        padding: 20px;
        background: aliceblue;
    }

    label{
        font-size: 15px;
        color: rgb(16, 80, 89);
    }

    .btn{
        background-color: #3b818a;
        color: whitesmoke;
        width: 100px;
        height: 50px;
        -webkit-border-radius: 25px;
        -moz-border-radius: 25px;
        border-radius: 25px;
    }

    /* .container {
        background-color: aliceblue; 
        padding: 20px; 
        border-radius: 10px;
    } */

    .judul{
        font-size: 50px;
        color: rgb(16, 80, 89);
        text-align: center;
        font-weight: 600;
    }

    .btn:hover {
        background-color:rgba(160, 181, 183, 0.21);
        color:rgb(27, 100, 110);
        transition: 0.5s;
    }

    #address{
        resize: none;
    }

    .form_box{
        background-color: #ffffff !important;
        padding: 30px !important;
        border-radius: 10px !important;
        box-shadow: 0 4px 12px rgba(107, 128, 124, 0.2) !important;
    }

    .form-label{
        font-size: 16px;
    }
    .form-control{
        font-size: 16px;
    }
    #logadmin{
        text-decoration: underline;
    }
</style>