<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="container">
  <div class="row d-flex align-items-center justify-content-center vh-100 p-2">
    
    <div class="col-md-12 col-lg-5 col-xl-6 p-5 rounded" style="background-color: rgba(0, 0, 0, 0.3)">
      
      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb justify-content-center text-light">
          <li class="breadcrumb-item"><a href="/" class="text-primary text-decoration-none">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Register</li>
        </ol>
      </nav>

      <h2 class="mb-3 text-center text-light">Register</h2>
      <p class="text-light">Silahkan isi form ini dengan data yang valid</p>
      <form id="fregister" class="row g-3 needs-validation" novalidate>
        <div class="col-12 text-light">
          <label for="namalengkap" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="namalengkap" name="namalengkap" required autocomplete="off" />
          <div class="invalid-feedback">Nama tidak boleh kosong.</div>
        </div>

        <div class="col-12 text-light">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required autocomplete="off" />
          <div class="invalid-feedback">Mohon isikan email yang valid.</div>
        </div>

        <div class="col-12 text-light">
          <label for="nohp" class="form-label">No Hp</label>
          <input type="number" class="form-control" id="phone" name="phone" required autocomplete="off" />
          <div class="invalid-feedback">Mohon isikan nomor Hp yang valid.</div>
        </div>

        <div class="col-12 position-relative text-light">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" required autocomplete="off" />
            <span class="input-group-text" onclick="togglePassword('password', 'togglePasswordIcon')">
              <i id="togglePasswordIcon" class="fas fa-eye"></i>
            </span>
          </div>
          <div class="invalid-feedback" id="passwordFeedback">Password minimal harus 8 karakter.</div>
        </div>
        <div class="col-12 position-relative text-light">
          <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="confirmPassword" required autocomplete="off" />
            <span class="input-group-text" onclick="togglePassword('confirmPassword', 'toggleConfirmPasswordIcon')">
              <i id="toggleConfirmPasswordIcon" class="fas fa-eye"></i>
            </span>
          </div>
          <div class="invalid-feedback" id="confirmPasswordFeedback">Password tidak sesuai.</div>
        </div>

        <?php
          $siteKey = $_ENV['SITE_KEY'];
          echo '<div class="g-recaptcha-wrapper">
                  <div class="mt-4 g-recaptcha" style="max-width:50px;" data-sitekey="' . htmlspecialchars($siteKey, ENT_QUOTES, 'UTF-8') . '"></div>
                </div>';
      ?>


        <div class="col-12 d-flex justify-content-center mt-5">
          <button class="btn btn-md btn-primary px-4 py-2" type="submit">Register</button>
        </div>
        <p class="text-white">Sudah punya Akun?<a href="/login" class="text-decoration-none"> Login</a></p>
      </form>
    </div>
  </div>
</div>

<script>

  $(document).ready(function(){
    togglePassword();
  });

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
