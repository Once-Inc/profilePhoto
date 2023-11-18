<?php

// Koneksi
$koneksi = mysqli_connect('localhost','root','','profile'); // Nama Database : 'profile' | Ubah sesuai kebutuhan

// Nangkep $_POST[''] dari form dan ditampung di variabel
$username = $_POST['username'];
$password = $_POST['password'];
$id_user = $_POST['id_user'];

// Mengecek, jika input type='file' ada isinya/file, maka akan menjalankan IF condition
if (isset($_FILES['foto']['name']) && !empty($_FILES['foto']['name'])) {
	$rand = rand();
	$ekstensi = array('png','jpg','jpeg','gif');
	$filename = $_FILES['foto']['name'];
	$ukuran = $_FILES['foto']['size'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	// Mengecek Ekstensi
	if (!in_array($ext,$ekstensi)) {
		header('location: ..?profilePhotopesan=gagalEkstensi');
	}else{
		// Mengecek Ukuran
		if ($ukuran < 2044070) {
		// Jika ukurannya lebih kecil dari 2mb
			$xx = $rand.'_'.$filename;

			// Mengecek data di column 'foto' berdasakan id_user
			$data = mysqli_query($koneksi,"SELECT foto FROM user WHERE id_user='$id_user'");
			$d = mysqli_fetch_assoc($data)['foto'];

			// Jika bukan foto bawaan/default
			if ($d != 'default.png') {

				// Menghapus foto selain 'default.png'
				unlink('photo/'.$d);
			}

			// Menambah file ke dalam folder 'photo'
			move_uploaded_file($_FILES['foto']['tmp_name'],'photo/'.$rand.'_'.$filename);

			// Update data dari tabel 'user' berdasarkan id_user yang sudah ditampung
			mysqli_query($koneksi,"UPDATE user SET username='$username', password='$password', foto='$xx' WHERE id_user='$id_user'");

			// Mengalihkan ke halaman utama
			header('location:../profilePhoto?pesan=berhasilUpProfile');

		}else{
			// Jika ukurannya lebih besar dari sistem
			header('location:../profilePhoto?pesan=gagalUkuran');
		}
	}
}else{
	// Jika input type='file' tidak ada isinya/file
	mysqli_query($koneksi,"UPDATE user SET username='$username', password='$password' WHERE id_user='$id_user'");

	// Mengalihkan ke halaman utama
	header('location: ../profilePhoto?pesan=berhasilUpProfile');	
}


?>