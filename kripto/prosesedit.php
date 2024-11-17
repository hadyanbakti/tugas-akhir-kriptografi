<?php
  include 'koneksi.php';
  $id_product=$_GET['id'];
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

  $konek= mysqli_query($connect, "UPDATE products SET product_id = '$id_product', name='$nameencrypt', image='$img', 
  price='$price', product_description='$descencrypt' WHERE product_id=$id_product; ") or die (mysqli_error($connect));

if($konek){
    header("location: indexadmin.php?jenis=admin");
  } else{
    header("location: indexadmin.php?jenis=admin");
  }
  ?>