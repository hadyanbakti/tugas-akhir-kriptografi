<?php
include_once 'koneksi.php';
 session_start();
 $data=mysqli_query($connect, "SELECT * FROM user WHERE username='$username'")or die (mysqli_error($connect));
 $dt=mysqli_fetch_array($data);
 if(empty($_SESSION['username'])){
  header("location: login.php?pesan=belum_login");
 }
 if ($_GET['jenis']!='admin') {
  header("location: index.php");
  echo $_GET['jenis'];
 }
 function decryptrailFence($ciphertext, $rails) {
  // Length of the ciphertext
  $n = strlen($ciphertext);
  
  // Create a 2D array to represent the zigzag pattern
  $rail = array_fill(0, $rails, array_fill(0, $n, ' '));
  
  // Step 1: Find the pattern of the rails
  $direction = -1;  // Direction of the zigzag (-1 for down, 1 for up)
  $row = 0;
  
  // Fill the rail array with the positions of the ciphertext
  for ($i = 0; $i < $n; $i++) {
      $rail[$row][$i] = '*';
      
      // Change direction at the top and bottom
      if ($row == 0 || $row == $rails - 1) {
          $direction = -$direction;
      }
      
      // Move to the next row in the zigzag pattern
      $row += $direction;
  }
  
  // Step 2: Fill the rail array with the ciphertext characters
  $index = 0;
  for ($i = 0; $i < $rails; $i++) {
      for ($j = 0; $j < $n; $j++) {
          if ($rail[$i][$j] == '*' && $index < $n) {
              $rail[$i][$j] = $ciphertext[$index++];
          }
      }
  }
  
  // Step 3: Read the zigzag pattern to get the plaintext
  $plaintext = '';
  $row = 0;
  $direction = -1;
  for ($i = 0; $i < $n; $i++) {
      $plaintext .= $rail[$row][$i];
      
      // Change direction at the top and bottom
      if ($row == 0 || $row == $rails - 1) {
          $direction = -$direction;
      }
      
      // Move to the next row in the zigzag pattern
      $row += $direction;
  }
  
  return $plaintext;
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
//while ($row = $data->fetch_object()) {
    // Gunakan XOR decrypt terlebih dahulu, lalu Rail Fence
    //$xor_key = "forza"; // Kunci untuk XOR
    //$rails = 3; // Jumlah rails untuk Rail Fence
    
    // Dekripsi nama produk
    //$xor_decrypted = decrypt_xor($row->name, $xor_key);
    //$decrypted_name = decrypt_railfence($xor_decrypted, $rails);
    //echo $decrypted_name;
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SkincareIn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="./indexstyle.css">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary px-5 py-2 fs-5" style="background-color: #e3f2fd; box-shadow: 0px 8px 25px rgba(0,0,0,0.4); z-index: 1; position: fixed; width: 100%;">
    <div class="container-fluid justify-content-between">
      <a class="navbar-brand fs-3 text-primary" href="#"><b>SkinkerIn</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="d-flex mx-auto w-50" role="search" action="./indexadmin.php?jenis=admin&" method="GET">
        <input type="text" name="jenis" value="admin" style="display:none;">  
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
          <button class="btn btn-outline-secondary" type="submit">Search</button>
        </form>
        
        <div>
          <a href="./login.php" class="btn btn-outline-primary border-0" id="tombol-login">Login</a>
          <a href="./logout.php" class="btn btn-danger border-2" id="tombol-login">Logout</a>
        </div>
      </div>
    </div>
  </nav>
  
  <!-- Banner corousel (auto slide/geser sendiri wwkwk) -->
  <div id="carouselExampleCaptions" class="carousel slide z-0" style="" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://www.dior.com/on/demandware.static/-/Library-Sites-DiorSharedLibrary/default/dw0321ae2c/images/beauty/05-PRODUCTS/01-FRAGRANCES/SAUVAGE/Y0998004/RELAUNCH2023/SVG_S223_PDP_IngredientParfumNight_1850x2000.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h3>Dior Sauvage</h3>
          <p>Rasakan sensasi wewangian buaya aseli.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://cdn.shopify.com/s/files/1/1323/4713/products/Laneige-BTS-_-AMOREPACIFIC-Lip-Sleeping-Mask-Lip-_-Pop-Edition_800x.jpg?v=1680162633" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h3>Lip Balm</h3>
          <p>Bibir tampak cerah dan sehat.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="https://3.bp.blogspot.com/-H-COfkDpv5Y/WLgmCjgW7QI/AAAAAAAA95E/B1eT3I8BDCwwbI6gtJl7hyz3SUcWoR45ACLcB/s1600/2017-02-20%2B02.36.09%2B1.jpg" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block">
          <h3>Innisfree Serum</h3>
          <p>Mencerahkan, melembabkan, dan menyamarkan bekas jerawat.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- bungkus semua konten produk -->
  <div class="py-3 px-5">
    <h1 class="m-0 pb-2 border-bottom border-dark" style="font-size: 4rem;"><b class="disini-txts">‎</b></h1>

    <nav class="navbar navbar-expand-lg p-0">
      <div class="container-fluid p-0">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav fs-5 mb-4 gap-2">
            <a class="nav-link active ps-0" aria-current="page" href="./indexadmin.php?jenis=admin">All</a>
            <a class="nav-link" href="./indexadmin.php?kategori=1&jenis=admin">Perfume</a>
            <a class="nav-link cek" href="./indexadmin.php?kategori=2&jenis=admin">Skincare</a>
            <a class="nav-link" href="./indexadmin.php?kategori=3&jenis=admin">Makeup</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Kotak buat semua produk -->
    <div class="all-card d-flex flex-wrap gap-3 justify-content-center">
      <?php
        include 'koneksi.php';
        $sql = "SELECT * FROM products";

        if(isset($_GET['search'])){
          $searchParam = $_GET['search'];
          $sql = "SELECT * FROM products WHERE name LIKE '%$searchParam%'";
        }
        if(isset($_GET['kategori'])){
          $searchParam = $_GET['kategori'];
          $sql = "SELECT * FROM products WHERE category = $searchParam";
        }

        $data = mysqli_query($connect, $sql) or die(mysqli_error($connect));
        while($row = $data->fetch_object()){
    $xor_key = "forza"; // Kunci untuk XOR
    $rails = 3; // Jumlah rails untuk Rail Fence
    
    // Dekripsi nama produk
    $xor_decrypted = decrypt_xor($row->name, $xor_key);
    $decrypted_name = decryptrailFence($xor_decrypted, $rails);
      ?>
      <a href="detailsadmin.php?id=<?= $row->product_id ?>" class="text-muted text-decoration-none">
        <!-- produk satu satu (card) -->
        <div class="card" style="width: 18rem;" id="product-card">
          <img src="<?= $row->image ?>" class="card-img-top" alt="<?= $decrypted_name; ?>" style="object-fit: cover;">
          <div class="card-body py-2 px-3">
            <h5 class="card-title fs-4 mb-1"><?= $decrypted_name; ?></h5>
            <h5 class="card-title" style="font-size: 18px;">Rp<?= $row->price ?></h5>
            <div class="d-grid gap-2 d-md-block">
          <a role="button" class="btn btn-secondary" href="editdata.php?id=<?= $row->product_id?>">edit</a>
            <a role="button" class="btn btn-danger" href="hapus.php?id=<?= $row->product_id?>">hapus</a>
        </div>
          </div>
          
          </div>
      </a>
      <?php } ?>
      
    </div> <!-- akhir kotak semua produk -->
  </div> <!-- akhir bungkus semua konten produk -->

  <div class="d-flex flex-column gap-2" style="position: fixed; right: 0; bottom: 0; z-index: 2; margin-right: 70px; margin-bottom: 100px;">
    <a href="tambahdata.php?jenis=admin">
      <div class="d-flex justify-content-center align-items-center" style="width: 60px; Height: 60px; position: fixed; background-color: #316CF4; border-radius: 50%;" id="animasi">
        <h1 style="color: white; font-size: 42px; padding: 0;">+</h1>
      </div>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script src="main.js"></script>
  <script src="https://kit.fontawesome.com/626c318560.js" crossorigin="anonymous"></script>


</body>
</html>