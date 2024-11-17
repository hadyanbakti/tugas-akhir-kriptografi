<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexstyle.css">
    <title>login</title>
</head>
<body class="bg">
<?php
session_start();
        $pesan;
        if(isset($_GET["pesan"])){
          if($_GET["pesan"] == "gagal"){
            $pesan = "Login gagal! Username atau Password salah";
          } else if($_GET["pesan"] == "logout"){
            $pesan = "Logout berhasil!";
          }
          else if($_GET["pesan"]=="belum_login")
          {$pesan="Silahkan Login terlebih dahulu";}

          print '<div class="alert alert-danger alerta" role="alert">';
          print '<p>'.$pesan;
          print '</p>';
          print '</div>';
        } ?>
    <center>

  <div class="card mt-5" style="background-color: white; width: 50vh; height: 60vh;">
    <div class="hal_log none">Halaman Login</div>
      <form style = "padding : 15px; color : white;" action="ceklog.php" method="post">
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label" style="color : black">Username</label>
          <input type="text" class="form-control logb" id="exampleInputEmail1" name="username">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label" style="color : black">Password</label>
          <input type="password" class="form-control logb" id="exampleInputPassword1" name="password">
        </div>
        <button type="submit" class="btn btn-primary logb">Login</button>
      </form>
      <p>Belum Memiliki Akun? <a href="register.php">Register</a> </p>
    </div>
    </center>
</body>
</html>