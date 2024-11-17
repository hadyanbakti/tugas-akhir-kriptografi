<?php
  session_start();
  include 'koneksi.php';

  $username = $_SESSION['username'];

  if (empty($_SESSION['username'])) {
    header("location: login_page.php?pesan=belum_login");
  }
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['encrypted_pdf'])) {
    $uploadDir = 'uploads/';  // Direktori tempat file akan disimpan
    $encryptedFile = $_FILES['encrypted_pdf']['tmp_name'];  // Path file sementara yang di-upload
    $encryptedFileName = $_FILES['encrypted_pdf']['name'];  // Nama file terenkripsi
    $decryptedFileName = 'decrypted_' . pathinfo($encryptedFileName, PATHINFO_FILENAME) . '.pdf';  // Nama file hasil dekripsi
    
    // Kunci enkripsi dan IV (Initialization Vector) untuk AES yang sama dengan saat enkripsi
    $key = 'your-256-bit-secret-key';  // Gantilah dengan kunci yang aman
    
    // Pastikan folder uploads ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Baca file terenkripsi
    $encryptedData = file_get_contents($encryptedFile);

    // Ambil IV yang disimpan di awal file terenkripsi
    $ivLength = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($encryptedData, 0, $ivLength);  // IV adalah bagian pertama dari data terenkripsi
    $encryptedData = substr($encryptedData, $ivLength);  // Data terenkripsi tanpa IV

    // Dekripsi data
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
    
    if ($decryptedData === false) {
        echo 'Gagal mendekripsi file.';
    } else {
        // Simpan file hasil dekripsi ke folder uploads/
        $decryptedFilePath = $uploadDir . $decryptedFileName;
        if (file_put_contents($decryptedFilePath, $decryptedData)) {
            echo 'File berhasil didekripsi!';
            echo '<br><a href="' . $decryptedFilePath . '" download>Download File Didekripsi</a>';
        } else {
            echo 'Gagal menyimpan file hasil dekripsi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukan Bima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    body {
      background-color: #007bff; /* Blue background */
      color: white;
    }
    .card {
      width: 50vh;
      padding: 20px;
      margin-top: 50px;
      border-radius: 15px;
    }
    textarea {
      resize: none;
      height: 100px;
      background-color: #f8f9fa;
      color: #212529;
    }
    .btn-primary {
      width: 100%;
      margin-top: 10px;
    }
    .form-label {
      font-weight: bold;
      color: #212529;
    }
    .action-button {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow bg-white">
      <h3 class="text-center text-primary mb-4">Cek Pembayaran (File)</h3>
      <div>
        <div class="mb-3">
            <form method="POST" enctype="multipart/form-data">
          <label class="form-label">Upload Bukti Pembayaran</label>
          <input class="form-control" type="file" name="encrypted_pdf">

        </div>
        <button type = "submit" class="btn btn-primary action-button">Submit</button>
            </form>
        
        <div class="mt-3 d-flex justify-content-between">
          <a href="index.php" class="btn btn-outline-danger w-45">kembali</a>
          <a href="cekpembayaran.php" class="btn btn-outline-secondary w-45">Cek Image</a>
        </div>
      </div>
    </div>
  </div>

  <script>
   
  </script>
</body>
</html>
