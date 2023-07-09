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
    function input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Cek apakah ada nilai yang dikirim menggunakan method GET dengan nama id_anggota
    if (isset($_GET['id'])) {
        $id = input($_GET["id"]);

        $sql = "SELECT * FROM user WHERE id=$id";
        $hasil = mysqli_query($kon, $sql);
        $data = mysqli_fetch_assoc($hasil);
    }

    //Cek apakah ada kiriman form dari method POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = htmlspecialchars($_POST["id"]);
        $nama = input($_POST["nama"]);
        $username = input($_POST["username"]);
        $level = input($_POST["level"]);

        // Query update data pada tabel anggota
        $sql = "UPDATE user SET
        id='$id',
        nama='$nama',
        username='$username',
        level='$level'
        WHERE id=$id";

        // Mengeksekusi atau menjalankan query diatas
        $hasil = mysqli_query($kon, $sql);

        // Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            // Periksa apakah ada file yang diunggah
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                // Mendapatkan informasi file
                $file_name = rand(0,9999).$_FILES['foto']['name'];
                $file_size = $_FILES['foto']['size'];
                $file_tmp = $_FILES['foto']['tmp_name'];
                $file_type = $_FILES['foto']['type'];

                // Tentukan direktori tempat menyimpan foto
                $upload_dir = 'foto/';

                // Pindahkan foto yang diunggah ke direktori tujuan
                move_uploaded_file($file_tmp, $upload_dir . $file_name);

                // Lakukan sesuatu dengan file yang telah diunggah, misalnya menyimpan nama file ke database
                $data_hapus_user = mysqli_query($kon,"select foto from user where id = $id");
                $data_hapus = mysqli_fetch_array($data_hapus_user);
                unlink('foto/'.$data_hapus['foto']);
                
                $sql_update_foto = "UPDATE user SET foto='$file_name' WHERE id=$id";
                $hasil_update_foto = mysqli_query($kon, $sql_update_foto);

                // Periksa apakah berhasil melakukan update
                if ($hasil_update_foto) {
                    echo "<div class='alert alert-success'>Foto berhasil diupdate.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Gagal mengupdate foto.</div>";
                }
            }

            header("Location:index_user.php");
        } else {
            echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
        }
    }
    ?>

    <h2>Update Data</h2>


    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>id:</label>
            <input type="number" name="id" class="form-control" disabled value="<?php echo $data['id']; ?>"/>
        </div>
        <div class="form-group">
            <label>nama</label>
            <input type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>"/>
        </div>
        <div class="form-group">
            <label>username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>"/>
        </div>
        <div class="form-group">
            <label>level</label>
            <input type="text" name="level" class="form-control" value="<?php echo $data['level']; ?>"/>
        </div>
        <div class="form-group">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control-file" accept="image/*" />
        </div>

        <input type="hidden" name="id" value="<?php echo $data['id']; ?>" />

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
</body>
</html>