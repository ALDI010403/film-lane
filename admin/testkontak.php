<?php 
session_start();

if($_SESSION['status']!="sudah_login"){
    //menambahkan pesan error jika pengguna belum login
    $_SESSION['error'] = "Anda belum login. Silakan login terlebih dahulu.";
    header("location:index.php");
    exit();
} 

?>

<h3 text align="center">Hallo! Selamat datang : <?php echo $_SESSION['nama']; ?></h3>


<!DOCTYPE html>
<html>
<head>
    <!-- Load file CSS Bootstrap offline -->
   
	 <title>Wewbsite Admin/Back end</title>
      <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
      <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
<?php include 'menu.php'; ?>


<div class="container">
    <br>
    <h4>Data Kontak</h4>

    <?php
    include "../koneksi.php";

    // Cek apakah ada kiriman form dari method get
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);

        // Fungsi untuk hapus data
        $data_hapus_contact = mysqli_query($kon,"SELECT * FROM contact WHERE id = $id");
        $data_hapus = mysqli_fetch_array($data_hapus_contact);

        $sql = "DELETE FROM contact WHERE id='$id'";
        $hasil = mysqli_query($kon, $sql);

        // Kondisi apakah berhasil atau tidak
        if ($hasil) {
            echo "<div class='alert alert-success'>Data User Berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Data User Gagal dihapus.</div>";
        }
    }

    ?>
	
	

<?php

?>

<form method="get" action="">
        <div class="form-group">
            <input type="text" class="form-control" name="cari" placeholder="Pencarian...." />
        </div>
    </form>
    <table class="table table-bordered table-hover">
        <br>
        <thead>
        <tr>
            <th>No</th>
            <th>id</th>
            <th>nama</th>
            <th>email</th>
            <th>no_tlp</th>
            <th>pesan</th>
            <th colspan='2'>Aksi</th>

        </tr>
        </thead>
        <?php
        $batas = 3;
        $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
        $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;
        $previous = $halaman - 1;
        $next = $halaman + 1;
        
        if ($_SESSION['level'] == "ADMIN") { 
            $d = mysqli_query($kon, "SELECT * FROM contact");
            $jumlah_data = mysqli_num_rows($d);
            $total_halaman = ceil($jumlah_data / $batas);
            $data_contact = mysqli_query($kon, "SELECT * FROM contact ORDER BY id DESC LIMIT $halaman_awal, $batas");
            $nomor = $halaman_awal + 1;
        } else {
            $d = mysqli_query($kon, "SELECT * FROM contact WHERE nama = '$_SESSION[nama]'");
            $jumlah_data = mysqli_num_rows($d);
            $total_halaman = ceil($jumlah_data / $batas);
            $data_contact = mysqli_query($kon, "SELECT * FROM contact WHERE nama = '$_SESSION[nama]' LIMIT $halaman_awal, $batas");
            $nomor = $halaman_awal + 1;
        }

        if (isset($_GET['cari'])){
            $d = mysqli_query($kon, "SELECT * FROM contact WHERE nama LIKE '%".$_GET['cari']."%'");
            $jumlah_data = mysqli_num_rows($d);
            $total_halaman = ceil($jumlah_data / $batas);
            $data_contact = mysqli_query($kon, "SELECT * FROM contact WHERE nama LIKE '%".$_GET['cari']."%' LIMIT $halaman_awal, $batas");
            $nomor = $halaman_awal + 1; 
        }


        $no = 0;
        while ($data = mysqli_fetch_array($data_contact)){
            $no++;
            ?>
            <tbody>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $data["id"]; ?></td>
                <td><?php echo $data["nama"];   ?></td>
                <td><?php echo $data["email"];   ?></td>
                <td><?php echo $data["no_tlp"];   ?></td>
                <td><?php echo $data["pesan"];  ?></td>
                <td>
                    <a href="update_kontak.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                    <?php if($_SESSION['level'] == "ADMIN") { ?>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus_<?php echo $data['id']; ?>">
                                Hapus
                            </button>
                            
                            <!-- Skrip bootstrap konfirmasi tombol - Modal -->
                            <div class="modal fade" id="hapus_<?php echo $data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Pesan Konfirmasi</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus data?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" data-dismiss="modal">Tidak</button>
                                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?id=<?php echo $data['id']; ?>" class="btn btn-danger" role="button">Ya, Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                </td>
            </tr>
            </tbody>
            <?php
        }
        ?>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
            </li>
            <?php 
            for($x=1;$x<=$total_halaman;$x++){
                ?> 
                <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                <?php
            }
            ?>              
            <li class="page-item">
                <a class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
            </li>
        </ul>
    </nav>

</div>

</body>
</html>





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

        $sql="select * from kontak where id=$id";
        $hasil=mysqli_query($kon,$sql);
        $data = mysqli_fetch_assoc($hasil);


    }

    //Cek apakah ada kiriman form dari method post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id=htmlspecialchars($_POST["id"]);
        $nama=input($_POST["nama"]);
        $email=input($_POST["email"]);
        $alamat=input($_POST["alamat"]);
        $pesan=input($_POST["pesan"]);
        

        //Query update data pada tabel anggota
        $sql="update kontak set
            id='$id',
            nama='$nama',
            email='$email',
            alamat='$alamat',
            pesan='$pesan'
            where id=$id";


        //Mengeksekusi atau menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:index_kontak.php");
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
            <label>alamat</label>
           <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat']; ?>"/>
		</div>
		
		<div class="form-group">
            <label>Pesan</label>
           <input type="text" name="pesan" class="form-control" value="<?php echo $data['pesan']; ?>"/>
		</div>

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>



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
        $whatsapp=input($_POST["whatsapp"]);
        $instagram=input($_POST["instagram"]);
    

        //Query update data pada tabel anggota
        $sql="update identitas set
            id='$id',
            nama='$nama',
            instagram='$instagram',
            whatsapp='$whatsapp'
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
            <label>instagram</label>
           <input type="text" name="instagram" class="form-control" value="<?php echo $data['instagram']; ?>"/>
		</div>
		
		<div class="form-group">
            <label>whatsapp</label>
           <input type="text" name="whatsapp" class="form-control" value="<?php echo $data['whatsapp']; ?>"/>
		</div>
		

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>