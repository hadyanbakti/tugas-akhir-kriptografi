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

    .sidebar{
      height: 100%;
      width: 380px;
      background-color: #007bff;
      color: white;
    }

    .logo{
      display: flex;
      justify-content: center;
      align-items: center;
      padding:  16px 10px 16px 10px;
      gap: 6px;
    }
    
    .logo h2{
      padding: 0;
      margin: 0;
      font-weight: 600;
    }
    
    .logo img{
      width: 60px;
      height: 60px;
    }

    .account-info{
      display: flex;
      align-items: center;
      gap: 10px;
      padding:  16px 10px 16px 10px;
    }
    
    .image-info{ 
      width: 75px;
      height: 75px;
      border-radius: 50%;
      padding:  26px 10px 26px 10px;
    }
    
    .image-info img{ 
      width: 100%;
    }

    .welcome p{
      margin: 0;
    }

    .nav-link {
      font-size: 16px;
    }

    .navbar{
      padding: 0 5rem 0 5rem;
    }

    .content{
      height: 90vh;
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    
    .kosong{
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 70rem;
    }

    .kosong img{
      width: 20%;
      object-fit: cover;
      margin-bottom: 20px;
    }

    .kosong h2{
      text-align: center;
    }

    .table h1{
      text-align: center;
    }

    .table{
      padding: 4rem;
    }

    .ajust-font td{
      font-size: 26px;
    }
  </style>

  <div class="d-flex justify-content-center align-items-center flex-column" style="height: 100vh; background-color: #61A3BA">
  <?php
    if(isset($_GET['ket'])){
      if($_GET['ket'] === 'success'){
        print'<div style="width: 60vh; margin-bottom: 16px; text-align: center; border-radius: 6px; background-color: #C7DCA7;">';
        print'<h5 class="p-2 m-0" style="font-size: 18px;">Berhasil Ditambahkan!</h5>';
        print'</div>';
      } else {
        print'<div style="width: 60vh; margin-bottom: 16px; text-align: center; border-radius: 6px; background-color: #f7dddc;">';
        print'<h5 class="p-2 m-0" style="font-size: 18px;">Gagal Ditambahkan!</h5>';
        print'</div>';
      }
    }
  ?>
    <div class="d-flex justify-content-center p-4" style="border: 4px solid #D0D4CA; border-radius: 12px; background-color: white;">
      <div>
        <h1 class="text-center mb-5"><b>Tambah Data</b></h1>
          <form action="tambahin.php" method="POST" class="">
            <table class="d-flex" style="width: 70vh">
              <tr class="d-flex gap-5 fs-4 mb-3" style="width: 70vh;">
                <td class="w-50 fs-5">Nama product:</td>
                <td class="w-100">
                  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Masukan nama" name="name">
                </td>
              </tr>
              
              <tr class="d-flex gap-5 fs-4 mb-3">
                <td class="w-50 fs-5">Harga:</td>
                <td class="w-100">
                  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Masukan harga" name="price">
                </td>
              </tr>

              <tr class="d-flex gap-5 fs-4 mb-3">
                <td class="w-50 fs-5">Link Gambar:</td>
                <td class="w-100">
                  <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Link gambar" name="img">
                </td>
              </tr>
              
              <tr class="d-flex gap-5 fs-4 mb-3">
                <td class="w-50 fs-5">Category:</td>
                <td class="w-100">
                  <select class="form-select" aria-label="Default select example" name="category">
                    <option selected>Pilih Kategori</option>
                    <option value="1">Parfume</option>
                    <option value="2">Skincare</option>
                    <option value="3">MakeUp</option>
                  </select>
                </td>
              </tr>

              <tr class="d-flex gap-5 fs-4 mb-3">
                <td class="w-50 fs-5">Deskripsi:</td>
                <td class="w-100">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="desc"></textarea>
                </td>
              </tr>
            </table>
          <button type="submit" class="btn btn-primary">Simpan</button>

        </form>
        <a href="indexadmin.php?jenis=admin">
          <button class="btn btn-outline-danger mt-2">Kembali</button>
        </a>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>