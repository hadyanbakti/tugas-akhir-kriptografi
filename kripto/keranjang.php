<?php
  session_start();

  $username = $_SESSION['username'];

  if(empty($_SESSION['username'])){
    header("location: login_page.php?pesan=belum_login");
  }
  function decrypt_railfence($ciphertext, $rails) {
    $length = strlen($ciphertext);
    $rail = array_fill(0, $rails, array_fill(0, $length, "\n"));
    $dir_down = false;
    $row = 0;
    $col = 0;
  
    // Mark positions on rail array
    for ($i = 0; $i < $length; $i++) {
        if ($row == 0 || $row == $rails - 1) {
            $dir_down = !$dir_down;
        }
        $rail[$row][$col++] = '*';
        $row = $dir_down ? $row + 1 : $row - 1;
    }
  
    // Place ciphertext in marked positions
    $index = 0;
    for ($i = 0; $i < $rails; $i++) {
        for ($j = 0; $j < $length; $j++) {
            if ($rail[$i][$j] == '*' && $index < $length) {
                $rail[$i][$j] = $ciphertext[$index++];
            }
        }
    }
  
    // Read the message in zigzag order
    $result = '';
    $row = 0;
    $col = 0;
    for ($i = 0; $i < $length; $i++) {
        if ($row == 0 || $row == $rails - 1) {
            $dir_down = !$dir_down;
        }
        if ($rail[$row][$col] != '*') {
            $result .= $rail[$row][$col++];
        }
        $row = $dir_down ? $row + 1 : $row - 1;
    }
    return $result;
  }
  
  function decrypt_xor($ciphertext, $key) {
    $result = '';
    for ($i = 0; $i < strlen($ciphertext); $i += 2) {
        // Convert each pair of hex characters back to ASCII and XOR with the key
        $char = hexdec(substr($ciphertext, $i, 2)) ^ ord($key[($i / 2) % strlen($key)]);
        $result .= chr($char);
    }
    return $result;
  }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukan Bima</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap');

    body{
      font-family: 'Poppins', sans-serif;
    }
  </style>

  <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh; background-color: #61A3BA">
  <?php
    if(isset($_GET['ket'])){
      if($_GET['ket'] === 'success'){
        print'<div style="width: 60vh; margin-bottom: 16px; text-align: center; border-radius: 6px; background-color: #C7DCA7;">';
          print'<h5 class="p-2 m-0" style="font-size: 18px;">Checkout Berhasil!</h5>';
          print'</div>';
        } else {
          print'<div style="width: 60vh; margin-bottom: 16px; text-align: center; border-radius: 6px; background-color: #f7dddc;">';
          print'<h5 class="p-2 m-0" style="font-size: 18px;">Checkout Gagal!</h5>';
          print'</div>';
        }
      }
    ?>
    <div class="d-flex justify-content-center p-4 flex-column" style="border: 4px solid #D0D4CA; border-radius: 12px; background-color: white;">
      <h1 class="text-center mb-5"><b>Keranjang Anda</b></h1>
      <table class="table" style="width: 70vh;">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama barang</th>
            <th scope="col">Harga</th>
          </tr>
        </thead>
        <tbody>
          <?php
          include 'koneksi.php';
          $username = $_SESSION['username'];
          $sql_username = "SELECT * FROM user WHERE username = '$username'";
          $data_user = mysqli_query($connect, $sql_username) or die(mysqli_error($connect));
          while($row = $data_user->fetch_object()){
            $id_user = $row->user_id;
          }
          $sql = "SELECT * FROM cart WHERE user_id = $id_user";
          $data = mysqli_query($connect, $sql)or die(mysqli_error($connect));
          $count=1;
          $total=0;
          while($row = $data->fetch_object()){
            $xor_key = "forza"; // Kunci untuk XOR
          $rails = 3; // Jumlah rails untuk Rail Fence
          
          // Dekripsi nama produk
          $xor_decrypted = decrypt_xor($row->name, $xor_key);
          $decrypted_name = decrypt_railfence($xor_decrypted, $rails);
          ?>
          <tr>
            <th scope="row"><?php print $count++; ?></th>
            <td><?=$decrypted_name;?></td>
            <td>Rp<?=$row->price?></td>
          </tr>
          <?php
          $total += $row->price;
          }
          ?>
          <tr>
            <th scope="row"></th>
            <td><b class="fs-4">TOTAL HARGA</b></td>
            <td><b class="fs-4">Rp<?=$total?></b></td>
          </tr>
        </tbody>
      </table>
      <div class="d-flex align-items-center flex-column">
        <a href="checkoutimage.php?id=<?=$id_user?>" class="mt-3 w-100">
          <button type="submit" class="btn btn-primary logb w-100">CHECKOUT</button>
        </a>
        <a href="index.php" class="mt-2 d-flex justify-content-center text-decoration-none">
          <button type="submit" class="btn btn-outline-danger loga">Kembali</button>
        </a>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>