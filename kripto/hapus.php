<?php
  session_start();
  include 'koneksi.php';

  $username = $_SESSION['username'];

  if(empty($_SESSION['username'])){
    header("location: login_page.php?pesan=belum_login");
  }
  $id = $_GET['id'];

  $sql = "DELETE FROM products WHERE product_id = $id";

  $data = mysqli_query($connect, $sql)or die(mysqli_error($connect));

  if($data){
    header("location: indexadmin.php?jenis=admin");
  } else {
    header("location: indexadmin.php?jenis=admin");
  }
?>