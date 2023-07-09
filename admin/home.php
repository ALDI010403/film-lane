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
    <h4>Website Admin/back end</h4>
	
	

<?php

?>


    <table class="table table-bordered table-hover">
        <br>
        <thead>
        <tr>
            <th>id</th>
            <th>nama</th>
            <th>email</th>
            <th>facebook</th>
            <th>instagram</th>
			<th>linkedin</th>
            <th colspan='2'>Aksi</th>

        </tr>
        </thead>
        <?php
        include "../koneksi.php";
        $sql="select * from identitas";
        $hasil=mysqli_query($kon,$sql);
        $no=0;
		
		
        while ($data = mysqli_fetch_array($hasil)) {
            $no++;

			
		
		
		
            ?>
            <tbody>
            <tr>
                <td><?php echo $data["id"]; ?></td>
                <td><?php echo $data["nama"];   ?></td>
                <td><?php echo $data["email"];   ?></td>
                <td><?php echo $data["facebook"];  ?></td>
				<td><?php echo $data["instagram"];  ?></td>
                <td><?php echo $data["linkedin"];   ?></td>
                <td>
                    <a href="update.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning" role="button">Update</a>
                </td>
            </tr>
            </tbody>
            <?php
        }
        ?>
    </table>

</div>

</body>
</html>
