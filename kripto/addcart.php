<?php
  include 'koneksi.php';
  session_start();

  $username = $_SESSION['username'];

  $name = $_GET['name'];
  $price = $_GET['price'];
  $id = $_GET['id'];

  $sql_username = "SELECT * FROM user WHERE username = '$username'";

  $data_user = mysqli_query($connect, $sql_username) or die(mysqli_error($connect));
  while($row = $data_user->fetch_object()){
    $id_user = $row->user_id;
  }
  
  $sql_cart = "INSERT INTO cart VALUES ('$id_user', '$name', '$price')";
  $data_user = mysqli_query($connect, $sql_cart) or die(mysqli_error($connect));

  if($data_user){
    header("location: details.php?id=".$id."&ket=success");
  } else{
    header("location: details.php?id=".$id."&ket=gagal");
  }
?>