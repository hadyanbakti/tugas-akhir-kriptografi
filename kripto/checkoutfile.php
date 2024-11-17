<?php
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['pdf_file'])) {
    $uploadDir = 'uploads/';  // Direktori tempat file akan disimpan
    $uploadedFile = $_FILES['pdf_file']['tmp_name'];  // Path file sementara yang di-upload
    $originalFileName = $_FILES['pdf_file']['name'];  // Nama file asli
    $encryptedFileName = 'encrypted_' . pathinfo($originalFileName, PATHINFO_FILENAME) . '.pdf';  // Nama file terenkripsi
    
    // Pastikan folder uploads ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Kunci enkripsi dan IV (Initialization Vector) untuk AES
    $key = 'your-256-bit-secret-key';  // Gantilah dengan kunci yang aman
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));  // Menghasilkan IV acak
    
    // Baca file yang di-upload
    $fileContents = file_get_contents($uploadedFile);

    // Enkripsi file
    $encryptedData = openssl_encrypt($fileContents, 'aes-256-cbc', $key, 0, $iv);
    
    // Gabungkan IV dan data terenkripsi (biasanya IV disimpan di awal file)
    $encryptedFileData = $iv . $encryptedData;

    // Simpan file terenkripsi ke folder uploads/
    $encryptedFilePath = $uploadDir . $encryptedFileName;
    if (file_put_contents($encryptedFilePath, $encryptedFileData)) {
        echo 'File berhasil terenkripsi dan disimpan sebagai ' . $encryptedFileName;
        echo '<br><a href="' . $encryptedFilePath . '" download>Download File Terenkripsi</a>';
    } else {
        echo 'Gagal menyimpan file terenkripsi.';
    }

    // Hapus file asli setelah terenkripsi (file asli yang di-upload dihapus di sini)
    unlink($uploadedFile);  // Menghapus file asli yang di-upload
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
      <h3 class="text-center text-primary mb-4">Check Out</h3>
      <div>
        <div class="mb-3">
            <form method="POST" enctype="multipart/form-data">
          <label class="form-label">Upload Bukti Pembayaran</label>
          <input class="form-control" type="file" name="pdf_file">

        </div>
        <a href="checkout.php?id=<?=$id?>" class="btn btn-primary">
        <button type = "submit" class="btn btn-primary action-button">Submit</button>
        </a>
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
