<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Rail Fence Decryption function
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
$encryptedUsername = railFenceEncrypt($username, 3); // Choose 3 as number of rails
$encryptedUsername = xorEncrypt($encryptedUsername, 'forza'); // Replace 'secret_key' with your actual key
password_verify($password, $row['password']);
// Retrieve the data from the database using the decrypted username
$data = mysqli_query($connect, "SELECT * FROM user WHERE username='$encryptedUsername'") or die(mysqli_error($connect));
$dt = mysqli_fetch_array($data);
$cek = mysqli_num_rows($data);

// Check if a user with the decrypted username exists and verify the password
if ($cek > 0) {
    $_SESSION['username'] = $encryptedUsername;
    $_SESSION['status'] = "login";
    
    if ($dt['jenis'] == 'admin') {
        header("location:indexadmin.php?jenis=" . $dt['jenis']);
    } else {
        header("location:index.php");
    }
} else {
    header("location:login.php?pesan=gagal");
}
?>
