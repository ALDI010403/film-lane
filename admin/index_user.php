<!DOCTYPE html>
<?php 
// Memulai session yang disimpan pada browser
session_start();

// Cek apakah sesuai status sudah login? Jika belum akan kembali ke form login
if($_SESSION['status'] != "sudah_login"){
    // Melakukan pengalihan
    header("location:index.php?pesan=anda belum login.");
    exit(); // Keluar dari skrip setelah melakukan pengalihan
} 
?>

<html>
<head>
    <!-- Load file CSS Bootstrap offline -->
	<title>Membuat Menu Responsive dengan Bootstrap</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php include 'menu.php'; ?>

<div class="container">
    <br>
    <h4>Data User</h4>
	
    <?php
    include "../koneksi.php";

    // Cek apakah ada kiriman form dari method get
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);

        // Fungsi untuk hapus data
        $data_hapus_user = mysqli_query($kon,"SELECT * FROM user WHERE id = $id");
        $data_hapus = mysqli_fetch_array($data_hapus_user);

        $sql = "DELETE FROM user WHERE id='$id'";
        unlink('foto/'.$data_hapus['foto']);
        $hasil = mysqli_query($kon, $sql);

        // Kondisi apakah berhasil atau tidak
        if ($hasil) {
            echo "<div class='alert alert-success'>Data User Berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Data User Gagal dihapus.</div>";
        }
    }

    // Menu Pencarian
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
                <th>Id</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th>Foto</th>
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
            $d = mysqli_query($kon, "SELECT * FROM user");
            $jumlah_data = mysqli_num_rows($d);
            $total_halaman = ceil($jumlah_data / $batas);
            $data_user = mysqli_query($kon, "SELECT * FROM user ORDER BY id DESC LIMIT $halaman_awal, $batas");
            $nomor = $halaman_awal + 1;
        } else {
            $d = mysqli_query($kon, "SELECT * FROM user WHERE username = '$_SESSION[username]'");
            $jumlah_data = mysqli_num_rows($d);
            $total_halaman = ceil($jumlah_data / $batas);
            $data_user = mysqli_query($kon, "SELECT * FROM user WHERE username = '$_SESSION[username]' LIMIT $halaman_awal, $batas");
            $nomor = $halaman_awal + 1;
        }

        if (isset($_GET['cari'])){
            $d = mysqli_query($kon, "SELECT * FROM user WHERE nama LIKE '%".$_GET['cari']."%'");
            $jumlah_data = mysqli_num_rows($d);
            $total_halaman = ceil($jumlah_data / $batas);
            $data_user = mysqli_query($kon, "SELECT * FROM user WHERE nama LIKE '%".$_GET['cari']."%' LIMIT $halaman_awal, $batas");
            $nomor = $halaman_awal + 1; 
        }

        $no = 0;
        while ($data = mysqli_fetch_array($data_user)){
            $no++;
            ?>
            <tbody>
                <tr>
                    <td><?php echo $no;?></td>
                    <td><?php echo $data["id"]; ?></td>
                    <td><?php echo $data["nama"]; ?></td>
                    <td><?php echo $data["username"]; ?></td>
                    <td><?php echo $data["level"]; ?></td>
                    <td><img src="foto/<?php echo $data['foto']; ?>" width="100"/></td>
                    <td>
                        <a href="update_user.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                        
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
    <?php if($_SESSION['level'] == "ADMIN") { ?>
        <a href="create_user.php" class="btn btn-primary" role="button">Tambah Data</a>
    <?php } ?>

</div>

</body>
</html>
