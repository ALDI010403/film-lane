<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Update data</title>
    <!-- Load file CSS Bootstrap offline -->
   <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

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
    //Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id_anggota
    if (isset($_GET['id'])) {
        $id=input($_GET["id"]);

        $sql="select * from identitas where id=$id";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_assoc($hasil);


    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id=htmlspecialchars($_POST["id"]);
        $nama=input($_POST["nama"]);
        $email=input($_POST["email"]);
        $facebook=input($_POST["facebook"]);
        $instagram=input($_POST["instagram"]);
        $linkedin=input($_POST["linkedin"]);

        //Query update data pada tabel anggota
        $sql="update identitas set
            id='$id',
            nama='$nama',
            email='$email',
            facebook='$facebook',
            instagram='$instagram',
            linkedin='$linkedin'
            where id=$id";


        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:home.php");
        }
        else {
            echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";

        }

    }

    ?>
    <h2>Update Data</h2>


    <form method="post">
        <div class="form-group">
            <label>Kode id:</label>
            <input type="number" name="id" class="form-control" disabled value="<?php echo $data['id']; ?>"/>

        </div>
        <div class="form-group">
            <label>nama</label>
           <input type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>"/>
		</div>
		
		<div class="form-group">
            <label>email</label>
           <input type="text" name="email" class="form-control" value="<?php echo $data['email']; ?>"/>
		</div>
		
		<div class="form-group">
            <label>facebook</label>
           <input type="text" name="facebook" class="form-control" value="<?php echo $data['facebook']; ?>"/>
		</div>
		
		<div class="form-group">
            <label>instagram</label>
           <input type="text" name="instagram" class="form-control" value="<?php echo $data['instagram']; ?>"/>
		</div>
		
		<div class="form-group">
            <label>linkedin</label>
           <input type="text" name="linkedin" class="form-control" value="<?php echo $data['linkedin']; ?>"/>
		</div>

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>