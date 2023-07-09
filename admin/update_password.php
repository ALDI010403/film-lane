<!DOCTYPE html>
<?php 
//memulai session yang disimpan pada browser
session_start();

//cek apakah sesuai status sudah login? kalau belum akan kembali ke form login
if($_SESSION['status']!="sudah_login"){
    
//melakukan pengalihan
header("location:index.php?pesan=anda belum login.");
} 

?>
<h3 text align="center">Yay! Selamat datang : <?php echo $_SESSION['nama']; ?> | <a href="logout.php">Logout</a></h3>

<html>
<head>
    <title>Form Pendaftaran User</title>
    <!-- Load file CSS Bootstrap offline -->
   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<?php include 'menu.php'; ?>

<div class="container">
    <?php

    //Include file koneksi, untuk koneksikan ke database
    include "../koneksi.php";
    
    //Fungsi untuk mencegah inputan karakter yang tidak sesuai
    function input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }   
    
    //Cek koneksi tabel didatabase
    
        $sql="select * from user where username='$_SESSION[username]'";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_assoc($hasil);
        
    //Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id_anggota
    if (isset($_GET['username'])) {
        $username=input($_GET["username"]);
    }
    
    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username=htmlspecialchars($_POST["username"]);
        $passwordlama  = $_POST['oldPass'];
        $passwordbaru1 = $_POST['newPass1'];
        $passwordbaru2 = $_POST['newPass2'];
		       

    //Query update data pada tabel user
    
        if ($data['password'] == md5($passwordlama)) {
    // jika password lama benar, maka cek kesesuaian password baru 1 dan 2
        if ($passwordbaru1 == $passwordbaru2) {
        // jika password baru 1 dan 2 sama, maka proses update password dilakukan
         
        // enkripsi password baru sebelum disimpan ke db
            $passwordbaruenkrip = md5($passwordbaru1);
        
			$sql="update user set
			password = '$passwordbaruenkrip'
			where username='$_SESSION[username]'";
			
		

        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
       if ($hasil) echo "<div class='alert alert-success'> Rubah Password Sukses.</div>";

    }
    else echo "<div class='alert alert-danger'> Password Baru Tidak Sama.</div>";

}
else echo "<div class='alert alert-danger'> Password Lama Salah.</div>";

 

        }

    
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" readonly value="<?php echo $data['username']; ?>" placeholder="Masukan Username" required />
        </div>
        
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" class="form-control" readonly value="<?php echo $data['nama']; ?>" placeholder="Masukan Nama" required/>
        </div>
        
         <div class="form-group">
            <label>Masukan Password Lama :</label>
            <input type="password" name="oldPass" class="form-control" placeholder="Masukan Password Lama" required/>
        </div>
        
         <div class="form-group">
            <label>Masukan Password Baru :</label>
            <input type="password" name="newPass1" class="form-control" placeholder="Masukan Password Baru" required/>
        </div>
        
         <div class="form-group">
            <label>Konfirmasi Password Baru :</label>
            <input type="password" name="newPass2" class="form-control" placeholder="Konfirmasi Password Baru" required/>
        </div>
       
       
        

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

</body>
</html>