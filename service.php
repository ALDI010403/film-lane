 <!--
  koneksi database
  -->
  <?php
  include "koneksi.php";
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
        $email=input($_POST["email"]);
        $pesan=input($_POST["pesan"]);
        
            //Query input menginput data kedalam tabel contact us
        $sql ="insert into kontak(nama,email,pesan) values
		('$nama','$email','$pesan')";
		//Mengeksekusi/menjalankan query diatas
        $hasil=mysqli_query($kon,$sql);
}
 $sql = "select * from identitas ";
 $hasil = mysqli_query($kon,$sql);
 $data = mysqli_fetch_assoc($hasil);
 
 ?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>movie</title>
  
  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body id="top">

  <!-- 
    - #HEADER
  -->

     <header class="header" data-header>
    <div class="container">

      <div class="overlay" data-overlay></div>

      <a href="./index.php" class="logo">
        <img src="./assets/images/logo.svg" alt="Filmlane logo">
      </a>

      <div class="header-actions">

        <button class="search-btn">
          <ion-icon name="search-outline"></ion-icon>
        </button>

        <div class="lang-wrapper">
          <label for="language">
            <ion-icon name="globe-outline"></ion-icon>
          </label>

          <select name="language" id="language">
            <option value="en">EN</option>
            <option value="au">AU</option>
            <option value="ar">AR</option>
            <option value="tu">TU</option>
          </select>
        </div>

        <button class="btn btn-primary">Sign in</button>

      </div>

      <button class="menu-open-btn" data-menu-open-btn>
        <ion-icon name="reorder-two"></ion-icon>
      </button>
      <nav class="navbar" data-navbar>

        <div class="navbar-top">

          <a href="./index.php" class="logo">
            <img src="./assets/images/logo.svg" alt="Filmlane logo">
          </a>

          <button class="menu-close-btn" data-menu-close-btn>
            <ion-icon name="close-outline"></ion-icon>
          </button>

        </div>

        <ul class="navbar-list">

          <li>
            <a href="./index.php" class="navbar-link">Beranda</a>
          </li>

          <li>
            <a href="./movie.php" class="navbar-link">Movie</a>
          </li>

          <li>
            <a href="./tvseries.php" class="navbar-link">Series TV</a>
          </li>

          <li>
            <a href="#" class="navbar-link">Web Series</a>
          </li>

          <li>
            <a href="./service.php" class="navbar-link">Layanan</a>
          </li>

        </ul>

        <ul class="navbar-social-list">

          <li>
            <a href="https://www.facebook.com/<?php echo $data['facebook']; ?>" class="navbar-social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://instagram.com/<?php echo $data['instagram']; ?>" class="navbar-social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>

          <li>
            <a href="https://www.linkedin.com/in/<?php echo $data['linkedin']; ?>" class="navbar-social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>

        </ul>

</nav>
    </div>
  </header>
  
<section class="service">
        <div class="container">

          <div class="service-banner">
            <figure>
              <img src="./assets/images/service-banner.jpg" alt="HD 4k resolution! only $3.99">
            </figure>

            <a href="./assets/images/service-banner.jpg" download class="service-btn">
              <span>Download</span>

              <ion-icon name="download-outline"></ion-icon>
            </a>
          </div>

          <div class="service-content">

            <p class="service-subtitle">Layanan</p>

            <h2 class="h2 service-title">Download Film Dan tonton secara Offline.</h2>

            <p class="service-text">
              Lorem ipsum dolor sit amet, consecetur adipiscing elseddo eiusmod tempor.There are many variations of
              passages of lorem
              Ipsum available, but the majority have suffered alteration in some injected humour.
            </p>

            <ul class="service-list">

              <li>
                <div class="service-card">

                  <div class="card-icon">
                    <ion-icon name="tv"></ion-icon>
                  </div>

                  <div class="card-content">
                    <h3 class="h3 card-title">Selamat menonton acara TV.</h3>

                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consecetur adipiscing elit, sed do eiusmod tempor.
                    </p>
                  </div>

                </div>
              </li>

              <li>
                <div class="service-card">

                  <div class="card-icon">
                    <ion-icon name="videocam"></ion-icon>
                  </div>

                  <div class="card-content">
                    <h3 class="h3 card-title">Tonton Kapan saja.</h3>

                    <p class="card-text">
                      Lorem ipsum dolor sit amet, consecetur adipiscing elit, sed do eiusmod tempor.
                    </p>
                  </div>

                </div>
              </li>

            </ul>

          </div>

        </div>
      </section>
      
      <!--
         kontak section start
      -->
      <style>

.kontak h2 {
  text-align: center;
  color: white; 
}

.kontak label {
  color: white; 
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 5px;
  font-size: 16px;
}

.form-group textarea {
  height: 100px;
}

.form-group button {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  background-color: #FFFF00;
  color: black;
  border: none;
  cursor: pointer;
}
</style>
<div class="kontak">
<h2>Form Kontak</h2>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
  <div class="form-group">
    <label for="nama">Nama:</label>
    <input type="text" id="nama" name="nama" required>
  </div>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
  </div>
  <div class="form-group">
    <label for="pesan">Pesan:</label>
    <textarea id="pesan" name="pesan" required></textarea>
  </div>
  <div class="form-group">
    <button type="submit">Kirim</button>
  </div>
</form>
</div>

      <!--
        kontak section end
      -->
 <!-- 
    - #FOOTER
  -->

      <footer class="footer">

    <div class="footer-top">
      <div class="container">

        <div class="footer-brand-wrapper">

          <a href="./index.html" class="logo">
            <img src="./assets/images/logo.svg" alt="Filmlane logo">
          </a>

          <ul class="footer-list">

            <li>
            <a href="./index.php" class="navbar-link">Beranda</a>
          </li>

          <li>
            <a href="./movie.php" class="navbar-link">Movie</a>
          </li>

          <li>
            <a href="./tvseries.php" class="navbar-link">Series TV</a>
          </li>

          <li>
            <a href="#" class="navbar-link">Web Series</a>
          </li>

          <li>
            <a href="./service.php" class="navbar-link">Layanan</a>
          </li>

          </ul>

        </div>

        <div class="divider"></div>

        <div class="quicklink-wrapper">

          <ul class="quicklink-list">

            <li>
              <a href="#" class="quicklink-link">Faq</a>
            </li>

            <li>
              <a href="#" class="quicklink-link">Bantuan</a>
            </li>

            <li>
              <a href="#" class="quicklink-link">Terms of use</a>
            </li>

            <li>
              <a href="#" class="quicklink-link">Privacy</a>
            </li>

          </ul>

          <ul class="social-list">

            <li>
              <a href="https://www.facebook.com/<?php echo $data['facebook']; ?>" class="social-link">
                <ion-icon name="logo-facebook"></ion-icon>
              </a>
            </li>

            <li>
              <a href="https://instagram.com/<?php echo $data['instagram']; ?>" class="social-link">
                <ion-icon name="logo-instagram"></ion-icon>
              </a>
            </li>
            <li>
              <a href="https://www.linkedin.com/in/<?php echo $data['linkedin']; ?>" class="social-link">
                <ion-icon name="logo-linkedin"></ion-icon>
              </a>
            </li>

          </ul>

        </div>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">

        <p class="copyright">
          &copy; 2023 <a href="#">Aldi</a>. All Rights Reserved
        </p>

        <img src="./assets/images/footer-bottom-img.png" alt="Online banking companies logo" class="footer-bottom-img">

      </div>
    </div>

  </footer>
<!-- 
    - #GO TO TOP
  -->

  <a href="#top" class="go-top" data-go-top>
    <ion-icon name="chevron-up"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>