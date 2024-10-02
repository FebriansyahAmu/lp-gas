<link rel="stylesheet" href="/css/nvStyle.css" />
<nav class="navbar navbar-expand-lg bt-transparent fixed-top" id="navbar-scrolspy">
  <div class="container-fluid p-2" style="margin-left: 3rem; margin-right: 3rem;">
    <a class="navbar-brand" href="#">
      <img src="/img/logo.png" alt="PK-GasAbdullah Logo" style="height: 2.5rem;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center " id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-center d-flex align-items-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>

        <?php if ($_SERVER['REQUEST_URI'] === '/'): ?>
        <li class="nav-item">
          <a class="nav-link nav-hover" href="#product">Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-hover" href="#about">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Kontak</a>
        </li>
        <?php endif; ?>

        <ul class="navbar-nav d-flex align-items-center" >
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
        <li class="nav-item ">
          <a class="nav-link" href="/cart">
            <i class="bi bi-cart4" style="font-size: 1.5rem; padding-top: 2;"></i>
          </a>
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
  const navbarToggler = document.querySelector(".navbar-toggler");
  const isHomePage = window.location.pathname === "/";
  if (isHomePage) {
    document.addEventListener("scroll", function () {
      if (window.scrollY > 50) {
        navbar.classList.add("bg-gray");
      } else {
        navbar.classList.remove("bg-gray");
      }
    });
  } else {
    navbar.classList.add("bg-gray");
  }
  navbarToggler.addEventListener("click", function () {
    if (!navbar.classList.contains("bg-gray") || navbar.classList.contains("bg-solid")) {
      navbar.classList.toggle("bg-solid");
    }
  });
  window.addEventListener("resize", function () {
    if (window.innerWidth < 768 && !navbar.classList.contains("bg-gray")) {
      navbar.classList.add("bg-solid");
    }
  });
});
</script>
