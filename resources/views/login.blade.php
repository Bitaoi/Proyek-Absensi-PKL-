<?php
session_start();
require('database.php');

$base_url = "http://localhost/simple_login_php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email    = $_POST["email"];
  $password = $_POST["password"];

  $result_login = login($email, $password);

  if (count($result_login) > 0) {

    $_SESSION["data_login"] = $result_login;

    header("Location: /simple_login_php");
    die();
  } else {
    $message = "Email atau password salah <br>";
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  <style>
    body {
      text-align: center;
    }
    form {
      display: inline-block;
    }
  </style>
</head>
<body>
<form action="" method="post">
  <?php !empty($message) ? print $message : ""?>

  <label><h1>Login ke Akun</h1></label>

  <label>Email :</label>
  <input type="email" name="email">
  <br><br>

  <label>Password :</label>
  <input type="password" name="password">
  <br><br>

  <button type="submit">Login</button>
  <br>
  <br>

  <label>
    <a href="<?= $base_url . '/registration.php'?>">Daftar akun baru</a>
  </label>
</form>
</body>
</html>