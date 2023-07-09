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
<h3>Yay! Selamat datang : <?php echo $_SESSION['nama']; ?> | <a href="logout.php">Logout</a></h3>
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
    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

       	$nama=input($_POST["nama"]);
        $username=input($_POST["username"]);
        $password=input($_POST["password"]);
	    $password2=input($_POST["password2"]);
	    $level=input($_POST["level"]);
    	$passwordenkrip=md5($password);
    	$temp = $_FILES['foto']['tmp_name'];
        $foto = rand(0,9999).$_FILES['foto']['name'];
        $size = $_FILES['foto']['size'];
        $type = $_FILES['foto']['type'];
        $folder = "foto/";
		
		
        
        //Cek nilai password sama dengan konfirmasi password
        if ($password == $password2) {
        
               
      //validasi duplikat username     
        $cek = mysqli_num_rows(mysqli_query($kon,"SELECT * FROM user WHERE username='$username'"));
        if ($cek > 0){
        echo "<div class='alert alert-danger'> Data username : $username sudah ada.</div>";
        }else {

           
	   if ($size < 2048000 and ($type =='image/jpeg' or $type == 'image/png' or $type == 'image/jpg')) {
        
        
        move_uploaded_file($temp, $folder . $foto);
		
        //Query input menginput data kedalam tabel anggota
        $sql="insert into user(nama,username,password,level,foto) values
		('$nama','$username','$passwordenkrip','$level','$foto')";

        //Mengeksekusi/menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);
        
	   } else {
	       
	        echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
	       
	   }
                        
                
        
                }
            }
         
        else  {
        echo "<div class='alert alert-danger'> Nilai Password Tidak Sama dengan Konfirmasi Password.</div>";
        }
        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index_user.php");
        }
        else {
             //echo "Error: " . $sql . "<br>" . $kon->error;
             echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
        }
        

    }
    ?>
    
    <?php 
    //Tampilan Form Input 
    ?>
    
    
    <h2>Input Data User</h2>


    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama :</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required />
        </div>
        
        <div class="form-group">
            <label>Username :</label>
            <input type="text" name="username" class="form-control" placeholder="Masukan username" required/>
		</div>
		
        <div class="form-group">
            <label>Password :</label>
            <input type="password" name="password" class="form-control" placeholder="Masukan Password" required/>
        </div>
        
        <div class="form-group">
            <label>Konfirmasi Password :</label>
            <input type="password" name="password2" class="form-control" placeholder="Masukan Konfirmasi Password" required/>
        </div>
        
         <div class="form-group">
            <label for="level">Pilih Level :</label>
            <select id="level" name="level" class="form-control">
                <option selected disabled>Pilih Level</option>
                <option value="ADMIN">ADMIN</option>
                <option value="USER">USER</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Upload Foto :</label>
            <input type="file" name="foto" class="form-control" placeholder="Masukan Foto" required/>
        </div>
        	

        <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
</body>
</html>
