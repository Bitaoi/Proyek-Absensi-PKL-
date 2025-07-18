<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    
    <div class="logo">
        <img src="{{ asset('image/fix_logo.png') }}" alt="Logo Perusahaan" class="logo-img img-fluid w-80 mb-4">
    </div>

    <div class="">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form_box p-4">
                    <h3 class="judul text-center"><b>DINKOP</b><br>LOGIN ADMIN</h3>
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
                            <label for="name" class="form-label">USERNAME</label>
                            <input type="text" id="name" name="name" class="form-control"
                                       placeholder="Masukkan Username Anda"
                                       autocomplete="off" 
                                       value="" 
                                       required autofocus>
                        </div>
                        
                        <div class="mb-4 position-relative">
                            <label for="password" class="form-label">PASSWORD</label>
                            <input type="password" id="password" name="password" class="form-control"
                                       placeholder="Masukkan Password Anda"
                                       autocomplete="new-password" 
                                       required>
                            <span id="togglePassword" style="position: absolute; right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn" id="loginButton">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function (e) {
        // ganti tipe input password
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // ganti ikon mata
        icon.classList.toggle('fa-eye'); // Hapus kelas fa-eye
        icon.classList.toggle('fa-eye-slash'); // Tambahkan atau hapus kelas fa-eye-slash
    });


    });
</script>

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