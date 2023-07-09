<?php 
// mengaktifkan session php
session_start();
 
// menghubungkan dengan koneksi
include '../koneksi.php';
 
// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = md5($_POST['password']);
 
// menyeleksi data user dengan username dan password yang sesuai
$result = mysqli_query($kon,"SELECT * FROM user where username='$username' and password='$password'");

$cek = mysqli_num_rows($result);
 
if($cek > 0) {
	$data = mysqli_fetch_assoc($result);
	
	
	//menyimpan session user, nama, status dan id login
	$_SESSION['username'] = $username;
	$_SESSION['nama'] = $data['nama'];
	$_SESSION['status'] = "sudah_login";
	$_SESSION['id_login'] = $data['id'];
	$_SESSION['level'] = $data['level'];
	header("location:home.php");
} else {
	header("location:index.php?pesan=gagal login data tidak ditemukan.");
}
?>