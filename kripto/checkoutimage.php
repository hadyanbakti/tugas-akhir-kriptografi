<?php
  session_start();
  include 'koneksi.php';

  $username = $_SESSION['username'];

  if(empty($_SESSION['username'])){
    header("location: login_page.php?pesan=belum_login");
  }
  $id = $_GET['id'];
  ?>
  <!DOCTYPE html>
  <html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukan Bima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body style="background-color : blue;">
  <center>
  <div class="card mt-5" style="background-color: white; width: 50vh; height: 60vh;">
    <div class="hal_log none">Check Out</div>
      <form style = "padding : 15px; color : white;">
      <div class="mb-3">
        <label for="formFile" class="form-label">Bukti Pembayaran</label>
        <input class="form-control" type="file" id="encryption-key" accept="image/*">
      </div>
      <label for="pesan" class="form-label">Label</label>
      <input class="form-control" type="text" placeholder="Default input" aria-label="default input example" id="pesan">
      <div class="btn-group">
  <a href="checkoutimage.php" class="btn btn-primary active" aria-current="page">Image</a>
  <a href="checkoutfile.php?id=<?=$id?>" class="btn btn-primary">File</a>
  <a href="checkout.php?id=<?=$id?>" class="btn btn-primary">
  <button type="submit" onclick="encrypt()">  
  submit</a>
</button>
</div>
      </form>
</center>
</body>

      <script>
        // Fungsi untuk menyisipkan teks dalam gambar menggunakan LSB
        function encrypt() {
            const fileInput = document.getElementById('encryption-key');
            const plaintext = document.getElementById('pesan').value;
        
            if (!fileInput.files[0]) {
                alert("Please upload an image.");
                return;
            }
        
            if (plaintext.trim() === "") {
                alert("Please enter some text to encrypt.");
                return;
            }
        
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.src = e.target.result;
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
        
                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const binaryText = (plaintext + '\0').split('')
                    .map(char => char.charCodeAt(0).toString(2).padStart(8, '0'))
                    .join('');
        
                    if (binaryText.length > imageData.data.length / 4) {
                        alert("Teks terlalu panjang untuk disisipkan dalam gambar ini.");
                        return;
                    }
        
                    for (let i = 0, j = 0; i < binaryText.length; i++, j += 4) {
                        // Sisipkan satu bit teks pada komponen warna merah (R)
                        imageData.data[j] = (imageData.data[j] & 0xFE) | parseInt(binaryText[i], 2);
                    }
        
                    ctx.putImageData(imageData, 0, 0);
        
                    const link = document.createElement('a');
                    link.download = 'buktipembayaran.png';
                    link.href = canvas.toDataURL();
                    link.click();
                };
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
        </script>

