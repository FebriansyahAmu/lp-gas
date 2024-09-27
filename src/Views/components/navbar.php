<style>
  .navbar {
  transition: background-color 0.4s ease;
}

.navbar.bg-gray {
  background-color: rgba(128, 128, 128, 0.5); /* Warna abu-abu dengan sedikit transparansi */
  backdrop-filter: blur(10px); /* Efek blur pada background */
  -webkit-backdrop-filter: blur(10px); /* Untuk browser dengan prefix Webkit (Safari) */
  transition: background-color 0.4s ease, backdrop-filter 0.4s ease;
}

.navbar-nav .nav-link {
    color: white !important; /* Pastikan warna link putih */
  }

  .navbar-nav .nav-link:hover {
    color: #83C683 !important; /* Ubah warna menjadi merah saat hover, gunakan !important untuk memastikan */
    
}
  .navbar-nav .dropdown-menu .dropdown-item {
    color: black; /* Jika ingin dropdown item tetap hitam */
  }

  .navbar-nav .dropdown-menu .dropdown-item:hover {
    background-color: #e2e6ea; /* Mengubah warna background saat hover di dropdown */
    color: black; /* Tetap warna hitam untuk dropdown item */
  }
</style>

<nav class="navbar navbar-expand-lg bt-transparent fixed-top" id="navbar-scrolspy">
  <div class="container-fluid p-2" style="margin-left: 50px; margin-right: 50px">
    <a class="navbar-brand" href="#">
      <img src="/img/logo.png" alt="PK-GasAbdullah Logo" style="height: 40px;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4 text-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>

        <?php if ($_SERVER['REQUEST_URI'] === '/'): ?>
        <li class="nav-item">
          <a class="nav-link nav-hover" href="#product">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-hover" href="#about">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
        <?php endif; ?>

        <ul class="navbar-nav ">
          <?php if ($isLoggedIn): ?>
          <li class="nav-item dropdown">
            <a class="nav-link text-light dropdown-toggle" href="#" id="profileDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              Account
            </a>
            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="/account">Riwayat Pembelian</a></li>
              <li><a class="dropdown-item" href="/account/alamat">Alamat</a></li>
              <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
          </li>
          <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <?php endif; ?>
        </ul>
      </ul>
    </div>
  </div>
</nav>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector(".navbar");
    
    // Cek apakah URL saat ini adalah beranda
    const isHomePage = window.location.pathname === "/";

    if (isHomePage) {
      // Jika di halaman beranda, jalankan logika scroll untuk navbar transparan
      document.addEventListener("scroll", function () {
        if (window.scrollY > 50) { // Jika halaman di-scroll lebih dari 50px
          navbar.classList.add("bg-gray");
        } else {
          navbar.classList.remove("bg-gray");
        }
      });
    } else {
      // Jika bukan di halaman beranda, tambahkan langsung background
      navbar.classList.add("bg-gray");
    }
  });
</script>
