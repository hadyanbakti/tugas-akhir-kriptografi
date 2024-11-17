<?php
  include 'koneksi.php';

  $name = $_POST['name'];
  $price = $_POST['price'];
  $img = $_POST['img'];
  $category = $_POST['category'];
  $desc = $_POST['desc'];
  function railFenceEncrypt($text, $rails) {
    $fence = array_fill(0, $rails, []);
    $rail = 0;
    $direction = 1;

    // Build the rail pattern
    for ($i = 0; $i < strlen($text); $i++) {
        $fence[$rail][] = $text[$i];
        $rail += $direction;

        if ($rail == 0 || $rail == $rails - 1) {
            $direction *= -1;
        }
    }

    // Concatenate the characters from each rail
    $result = '';
    foreach ($fence as $line) {
        $result .= implode('', $line);
    }
    return $result;
}

// XOR Encryption function
function xorEncrypt($text, $key) {
    $result = '';
    for ($i = 0; $i < strlen($text); $i++) {
        // XOR each character and convert it to a hex representation
        $result .= sprintf("%02x", ord($text[$i]) ^ ord($key[$i % strlen($key)]));
    }
    return $result;
}

// Apply Rail Fence Cipher and XOR Encryption on Username
$descencrypt = railFenceEncrypt($desc, 3); // Choose 3 as number of rails
$descencrypt = xorEncrypt($descencrypt, 'forza'); // Replace 'secret_key' with your actual key
$nameencrypt = railFenceEncrypt($name, 3);
$nameencrypt = xorEncrypt($nameencrypt, 'forza');

  $sql = "INSERT INTO products VALUES ('', '$nameencrypt', '$img', '$category', '$price', '$descencrypt')";

  $data = mysqli_query($connect, $sql) or die(mysqli_error($connect));

  if($data){
    header("location: tambahdata.php?ket=success&jenis=admin");
  } else{
    header("location: tambahdata.php?ket=gagal&jenis=admin");
  }
?>