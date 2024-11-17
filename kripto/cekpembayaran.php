<?php
  session_start();
  include 'koneksi.php';

  $username = $_SESSION['username'];

  if (empty($_SESSION['username'])) {
    header("location: login_page.php?pesan=belum_login");
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
      <h3 class="text-center text-primary mb-4">Cek Pembayaran</h3>
      <div>
        <div class="mb-3">
          <label for="decryption-key" class="form-label">Upload Bukti Pembayaran</label>
          <input class="form-control" type="file" id="decryption-key" accept="image/*">
        </div>
        <div class="mb-3">
          <label for="ciphertext" class="form-label">Hasil Dekripsi</label>
          <textarea readonly class="form-control" id="ciphertext" placeholder="Hasil dekripsi akan tampil di sini"></textarea>
        </div>
        <button onclick="decrypt()" class="btn btn-primary action-button">Submit</button>
        <div class="mt-3 d-flex justify-content-between">
          <a href="index.php" class="btn btn-outline-danger w-45">kembali</a>
          <a href="cekfile.php" class="btn btn-outline-secondary w-45">Cek File</a>
        </div>
      </div>
    </div>
  </div>

  <script>
    function decrypt() {
      const fileInput = document.getElementById('decryption-key');

      if (!fileInput.files[0]) {
        alert("Silakan unggah gambar terenkripsi.");
        return;
      }

      const reader = new FileReader();
      reader.onload = function (e) {
        const img = new Image();
        img.src = e.target.result;
        img.onload = function () {
          const canvas = document.createElement('canvas');
          const ctx = canvas.getContext('2d');
          canvas.width = img.width;
          canvas.height = img.height;
          ctx.drawImage(img, 0, 0);

          const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
          let binaryText = "";

          for (let i = 0; i < imageData.data.length; i += 4) {
            binaryText += (imageData.data[i] & 1).toString();
          }

          let extractedText = "";
          for (let i = 0; i < binaryText.length; i += 8) {
            const byte = binaryText.slice(i, i + 8);
            if (byte === '00000000') break; // Akhiri saat menemukan null terminator
            extractedText += String.fromCharCode(parseInt(byte, 2));
          }

          document.getElementById('ciphertext').value = extractedText;
        };
      };
      reader.readAsDataURL(fileInput.files[0]);
    }
  </script>
</body>
</html>
