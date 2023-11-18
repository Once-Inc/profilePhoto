<?php

// Koneksi
$koneksi = mysqli_connect('localhost','root','','profile'); // Nama Database : 'profile' | Ubah sesuai kebutuhan

// Nangkep dari link dan ditampung di variabel
$id = $_GET['id_user'];
$foto = $_GET['foto'];

// Jika $foto bukan 'default.png' atau foto bawaan dari sistem
if ($foto != 'default.png') {
	// Mengecek data di column 'foto' berdasakan id_user
	$data = mysqli_query($koneksi,"SELECT foto FROM user WHERE id_user='$id'");
	$d = mysqli_fetch_assoc($data)['foto'];
	// Menghapus foto
	unlink('photo/'.$d);

	// Update foto menjadi bawaan 'default.png'
	mysqli_query($koneksi,"UPDATE user SET foto='default.png' WHERE id_user='$id'");

	// Mengalihkan ke halaman utama, jika berhasil
	header('location: index.php?pesan=berhasilUpProfile');
}else{
	// Mengalihkan ke halaman utama, jika gagal
	header('location: index.php?pesan=gagalHapusFotoDefault');
}


?>