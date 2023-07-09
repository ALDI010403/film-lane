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
