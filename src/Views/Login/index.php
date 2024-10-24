
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<div class="container py-5 vh-100 ">
  
  <div class="row d-flex align-items-center justify-content-center h-100">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="d-flex justify-content-center ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Login</li>
    </ol>
  </nav>
    <div class="col-md-5">
      <img
        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
        class="img-fluid"
        alt="Phone image"
      />
    </div>
    
    <div class="col-md-8 col-lg-5 col-xl-5 offset-xl-1  p-5 rounded-2" style="background-color: rgba(0, 0, 0, 0.3)">
      <h2 class="mb-3 text-light">Log in</h2>
      <form novalidate id="flogin" class="needs-validation" novalidate>
        <!-- Email input -->
        <div class="col-12 text-light mb-4">
          <label for="email" class="form-label">Email Address</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
          />
        </div>

        <!-- Password input -->
        <div class="col-12 position-relative text-light mb-1">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              required
            />
            <span
              class="input-group-text"
              onclick="togglePassword('password', 'togglePasswordIcon')"
            >
              <i id="togglePasswordIcon" class="fas fa-eye"></i>
            </span>
          </div>
          <div class="invalid-feedback">Password tidak boleh kosong</div>
        </div>

        <?php
          $siteKey = $_ENV['SITE_KEY'];
          echo '<div class="g-recaptcha-wrapper">
                  <div class="mt-4 g-recaptcha" style="max-width:50px;" data-sitekey="' . htmlspecialchars($siteKey, ENT_QUOTES, 'UTF-8') . '"></div>
                </div>';
      ?>


        <!-- Submit button -->
        <button
          type="submit"
          class="btn btn-primary btn-md btn-block mt-3 px-4 py-2"
        >
          Log in
        </button>

        <p class="mt-2">
          Belum punya akun?
          <a href="/register" style="text-decoration: none">Daftar Sekarang</a>
        </p>
        <a href="/lupa-password" style="text-decoration: none"
          >Lupa Kata Sandi?</a
        >
      </form>
    </div>
  </div>
</div>

<script>
  (() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
  })()
</script>
<script>
  
 function togglePassword(fieldId, iconId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    if (passwordField && icon) {
      if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    } else {
      console.error("Element not found for IDs:", fieldId, iconId);
    }
  }
</script>

<script>
  $(document).ready(function(){
    login();
  })
</script>