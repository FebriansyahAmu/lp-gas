<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pangkalan Gas Abdulah</title>

    <!--Bootstrap-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <section
      class="vh-100"
      style="background: radial-gradient(circle at right, #b8ced6 , #3f3b3e)"
    >
      <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100 ">
          <div class="col-md-8 col-lg-7 col-xl-6">
            <img
              src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
              class="img-fluid"
              alt="Phone image"
            />
          </div>
          <div class="col-md-7 col-lg-5 col-xl-4 offset-xl-1">
            <h2 class="mb-3 text-light ">Log in</h2>
            <form novalidate id="flogin">
              <!-- Email input -->
              <div class="col-12 text-light mb-4">
                <label for="email" class="form-label"
                  >Email Address</label
                >
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
                <div class="invalid-feedback">
                  Please provide a valid password.
                </div>
              </div>
              
              <!-- Submit button -->
              <button
                type="submit"
                class="btn btn-primary btn-md btn-block mt-3 px-4 py-2"
              >
                Log in
              </button>

              <p class="mt-2">
                Belum punya akun? <a href="/register" style="text-decoration:none;">Daftar Sekarang</a>
                
              </p>
              <a href="/forgot-password" style="text-decoration:none;">Lupa Kata Sandi?</a>
            </form>
          </div>
        </div>
      </div>
    </section>
  </body>
  <script>
  // Validasi form
  (function () {
    'use strict';

    // Ambil form
    var form = document.getElementById('loginForm');

    form.addEventListener('submit', function (event) {
      // Cek apakah form valid
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }

      form.classList.add('was-validated');
    }, false);
  })();
</script>
<script>
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
  </script>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>

<script>
  $(document).ready(function(){
    $("#flogin").submit(function(event){
      event.preventDefault();
      const formData = new FormData(this);

      $.ajax({
        url: '/auth/login',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response){
          window.location.href="/account";
        },
        error: function(xhr){
          const errorResponse = JSON.parse(xhr.responseText);
          Swal.fire('Error', errorResponse.message, 'error');
        }
      })
    })
  })
</script>
  </html>
