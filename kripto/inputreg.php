<?php
include 'koneksi.php';

// Retrieve form data
$repassword = $_POST['repassword'];
$username = $_POST['username'];
$password = $_POST['password'];

// Rail Fence Cipher function
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
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
// Hash the password


if ($password === $repassword) {
    // Insert data into the database
    $konek = mysqli_query($connect, "INSERT INTO user (username, password, jenis) VALUES ('$encryptedUsername', '$hashedpassword', 'admin')") or die(mysqli_error($connect));
    header("location:login.php");
} else {
    header("location:register.php?pesan=gagal");
}
?>
