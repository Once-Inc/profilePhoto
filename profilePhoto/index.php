<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <!-- Style Bootstrap --> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <!-- Icon Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <title>Document</title>
</head>
<body>
  <!-- Mengambil code dari script jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php
  // Koneksi
  $koneksi = mysqli_connect('localhost','root','','profile'); // Nama Database : 'profile' | Ubah sesuai kebutuhan

  // Menampung id_user
  $idUser = 1; // 1 = Username : Me | 2 = Username : You | Ini yang ada di database
  
  // Menampilkan semua column dari tabel 'user' berdasarkan column 'id_user'
  $data = mysqli_query($koneksi,"SELECT * FROM user WHERE id_user = $idUser");
  while ($d = mysqli_fetch_array($data)) { ?>
    <script>
                // Membuat function foto() untuk preview foto ketika mengupload file
                function pripiw(){
                  // Untuk menangkap tag dengan id="foto" dan return files nya itu index/utama (0) ketika sudah di upload
                  var foto = document.getElementById("foto").files[0];
                  // Menangkap tag dengan id="preview" untuk melakukan preview sebuah foto
                  var preview = document.getElementById("preview");

                  
                  // Tanpa pake File API
                  if (foto) {
                    // Menambahkan atribut src pada tag yang id="preview" dengan valuenya ditangkap dari variabel foto
                    preview.src = URL.createObjectURL(foto);
                    // Membuat style id="preview" display="block" untuk di tampilkan
                    preview.style.display = "block";
                  }else{
                    // Jika tidak ada, maka src nya menjadi # dan display nya menjadi none, agar tidak di tampilkan
                    preview.src = "photo/<?= $d['foto']?>";
                    preview.style.display= "block";
                  }
                }
                // Function showPass yang baru
                $(document).ready(function() {
                // Ketika <a> yang didalam <div id="pw"> di click
                $("#pw a").on('click', function(event) {
                  // Membatalkan tindakan onclick (kalo di nonaktifin, href="" nya bakal jalan)
                  event.preventDefault();
                  // Jika <input type="text">
                  if($('#pw input').attr("type") == "text"){
                    // Mengubahnya menjadi "password"
                    $('#pw input').attr('type', 'password');
                    // Menambah class di <i> atau icon mata nya
                    $('#pw i').addClass( "bi-eye-slash" ); //Icon mata dicoret
                    // Menghapus class
                    $('#pw i').removeClass( "bi-eye" ); //Icon mata biasa
                    // Jika <input type="password">
                  }else if($('#pw input').attr("type") == "password"){
                    // Mengubahnya menjadi text
                    $('#pw input').attr('type', 'text');
                    // Menghapus class
                    $('#pw i').removeClass( "bi-eye-slash" );
                    // Menambah class
                    $('#pw i').addClass( "bi-eye" );
                  }
                });
              });
            </script>
            <div class="container">
              <!-- Card -->
              <div class="card position-absolute top-50 start-50 translate-middle text-center bordered border-dark mb-5" style="width: 22rem;">
                <div class="card-body">
                  <form action="proses.php" method="POST" enctype="multipart/form-data">
                    <table class="table table-bordered border-dar border-dark">
                      <tr>
                        <td colspan="2">
                          <!-- Gambar Preview -->
                          <img src="photo/<?= $d['foto']?>" id="preview" style="border-radius: 50%; object-fit: cover;" alt="foto profile" width="100" height="100" class="me-2 d-inline-block align-text-top"><br>
                          * Pastikan foto tidak lebih dari 2mb <!-- Opsional untuk dihapus -->
                        </td>
                      </tr>
                      <?php
                      // Jika file foto itu namanya bukan 'default.png', maka tombol untuk menghapus foto akan muncul
                      if ($d['foto'] != 'default.png') { ?>
                        <tr>
                          <td colspan="2"><a href="hapus.php?id_user=<?= $idUser?>&foto=<?= $d['foto']?>" type="button" class="btn btn-danger">Hapus Foto</a></td>
                        </tr>
                        <?php
                      }
                      ?>
                      <input type="hidden" name="id_user" value="<?= $idUser?>">
                      <tr>
                        <td>Upload Foto Baru</td>
                        <td><input type="file" name="foto" id="foto" onchange="pripiw()" class="form-control border-primary"></td>
                      </tr>
                      <tr>
                        <td>Username</td>
                        <td><input type="text" name="username" value="<?= $d['username']?>" class="form-control border-primary" required></td>
                      </tr>
                      <tr>
                        <td>Password</td>
                        <td class="input-group" id="pw">
                          <input type="password" name="password" value="<?= $d['password']?>" class="form-control border-primary" required>
                          <div class="input-group-text border-primary">
                            <a href="" style="color: #333"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td><input type="reset" value="Reset" class="btn btn-danger"> <input type="submit" value="Simpan" class="btn btn-success"></td>
                      </tr>
                    </table>
                  </form>
                  
                </div> 
              </div>
              <!-- Akhir Card -->
            </div>
          <?php } // <-- Penutup while() ?>
        </body>
        </html>