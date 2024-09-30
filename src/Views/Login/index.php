
<div class="container py-5 vh-100 overflow-hidden">
  
  <div class="row d-flex align-items-center justify-content-center h-100">
      <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="d-flex justify-content-center ">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Login</li>
    </ol>
  </nav>
    <div class="col-md-8 col-lg-7 col-xl-6">
      <img
        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
        class="img-fluid"
        alt="Phone image"
      />
    </div>
    
    <div class="col-md-7 col-lg-5 col-xl-4 offset-xl-1">
      <h2 class="mb-3 text-light">Log in</h2>
      <form novalidate id="flogin">
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
          <div class="invalid-feedback">Please provide valid email</div>
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
          <div class="invalid-feedback">Please provide a valid password.</div>
        </div>

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
  (function () {
    'use strict';
    var form = document.getElementById('loginForm');
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }

      form.classList.add('was-validated');
    }, false);
  })();
</script>
<script>
  $(document).ready(function(){
    function togglePassword(fieldId, iconId) {
      const passwordField = document.getElementById(fieldId);
      const icon = document.getElementById(iconId);

      if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  })
</script>

<script>
  $(document).ready(function(){
    login();
  })
</script>