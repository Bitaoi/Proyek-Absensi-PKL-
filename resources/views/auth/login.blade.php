<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body>

<div class="logo pt-5 d-flex justify-content-center">
    <img src="{{ asset('image/logo-pemkot.png') }}" alt="Logo Perusahaan" class="logo-img img-fluid w-80 mb-4">
</div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="form_box p-4">
                    <h3 class="judul text-center"><b>DINKOP</b><br>LOGIN ADMIN</h4>
                    <hr>
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <b>Opps!</b> {{session('error')}}
                    </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('admin.login.submit') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="username" class="form-label">USERNAME</label>
                            <input type="text" id="username" name="username" class="form-control"
                                   placeholder="Masukkan username Anda"
                                   autocomplete="off" 
                                   value="" 
                                   required autofocus>
                        </div>
                        <div class="mb-4">
                            <label for="password" class="form-label">PASSWORD</label>
                            <div class="mata" style="display: inline-block;">
                            <input type="password" id="password" name="password" class="form-control"
                                   placeholder="Masukkan password Anda"
                                   autocomplete="new-password" 
                                   required>

                                   <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                    <i class="fa-regular fa-eye"></i>
                                </span>

                            </div>


                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    @import url('https://fonts.googleapis.com/css?family=Poppins:400,700,900');

    *{
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }
        

    label{
        font-size: 15px;
        color: #3b818a;
    }

    body{
        padding: 20px;
        background: aliceblue;

    }

    .judul{
        font-size: 50px;
        color: rgb(16, 80, 89);
        text-align: center;
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

    .form_box {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(107, 128, 124, 0.2);
    }
    .form-label{
        font-size: 16px;
    }
    .form-control{
        font-size: 16px;
    }

</style>