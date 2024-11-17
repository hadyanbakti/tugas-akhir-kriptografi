<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="indexstyle.css">
    <title>Register</title>
</head>
<body class="bg">
<?php 
session_start();   
$pesan;
if(isset($_GET["pesan"])){
          if($_GET["pesan"] == "gagal"){
            $pesan = "Register gagal, silahkan ulangi";}} ?>
<center>
    <div class="cardd">
        <div class="hal_log">Register</div>
        <form style = "padding : 15px; color : black;" action="inputreg.php" method="post">
  <div class="mb-3" >
    <label for="exampleInputEmail1" class="form-label">Username</label>
    <input type="text" class="form-control logb" id="exampleInputEmail1" aria-describedby="emailHelp" name="username">
    <div id="emailHelp" class="form-text"></div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control logb" id="exampleInputPassword1" name="password">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Re-Password</label>
    <input type="password" class="form-control logb" id="exampleInputPassword1" name="repassword">
  </div>
  <div>
  </div>

  <?php
  $pesan;
if(isset($_GET["pesan"])){
          if($_GET["pesan"] == "gagal"){
            $pesan = "Register gagal, silahkan ulangi";}
 print '<p>'.$pesan;
 print '</p>';}
 ?>
  <br>
  <button type="submit" class="btn btn-primary logb">Register</button><br>
  
</form>
<a class="btn btn-outline-primary logb" href="login.php" role="button">Login</a>
    </div>
    </center>
</body>
</html>