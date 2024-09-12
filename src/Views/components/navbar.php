<nav class="navbar navbar-expand-lg  fixed-top" style="background: radial-gradient(circle at right, #b8ced6 , #3f3b3e)">
  <div
    class="container-fluid p-2"
    style="margin-left: 50px; margin-right: 50px"
  >
    <a class="navbar-brand" href="#">PK-GasAbdullah</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div
      class="collapse navbar-collapse justify-content-center"
      id="navbarSupportedContent"
    >
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-4 text-center">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-hover" href="#">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <!-- <li class="nav-item">
          <a href="#" class="nav-link text-white">
            <i class="fa-solid fa-cart-shopping"></i>
          </a>
        </li> -->
        <!-- Login Link -->
        <ul class="navbar-nav ">
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="/purchase-history">Purchase History</a></li>
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
<!-- <style>
    .nav-hover:hover {
      color: red !important;
    }
  </style> -->
<style>
  /* Styling untuk dropdown menu */
.navbar .dropdown-menu {
    border-radius: 0.25rem;
    padding: 0;
    margin: 0;
}

.navbar .dropdown-menu .dropdown-item {
    padding: 0.5rem 1rem;
}

.navbar .dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;
}

</style>