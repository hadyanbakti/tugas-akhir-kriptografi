<?php
  session_start(); // memulai seesion
  session_destroy(); // menghapus semua session
  header("location: login.php?pesan=logout");
?>