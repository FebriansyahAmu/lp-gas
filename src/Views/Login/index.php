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
              <a href="/lupa-password" style="text-decoration:none;">Lupa Kata Sandi?</a>
            </form>
          </div>
        </div>
      </div>

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
<script>
  $(document).ready(function(){
    $("#flogin").submit(function(event){
      event.preventDefault();
      const formData = new FormData(this);
      $("#loading-spinner").removeClass("d-none");
      $.ajax({
        url: '/auth/login',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response){
          $("#loading-spinner").addClass("d-none");
           if (response.status === 'success') {
            if (response.redirect) {
                window.location.href = response.redirect;
            }
        }else if(response.status === 'unverified'){
            Swal.fire({
              icon: "error",
              title: "Error",
              text: response.message,
              footer: '<a href="" id="resend-verification-link">Kirim link verifikasi</a>'
            });

            $('#resend-verification-link').on('click', function(e){
              e.preventDefault();
              $("#loading-spinner").removeClass("d-none");
              $.ajax({
                url: '/auth/resend-verification',
                type: 'POST',
                data: {email: response.email},
                success: function(res){
                   $("#loading-spinner").addClass("d-none");
                  Swal.fire({
                    icon: "success",
                    title: "Link verifikasi dikrim",
                    text: "Silahkan cek email anda! "
                  });
                },
                error: function(xhr){
                  const errRes = JSON.parse(xhr.responseText);
                  Swal.fire('Error', errRes.message, 'error');
                },
                complete: function(){
                  $("#loading-spinner").addClass("d-none");
                }
              })
            })
          }
        },
        error: function(xhr){
          const errorResponse = JSON.parse(xhr.responseText);
          Swal.fire('Error', errorResponse.message, 'error');
        },
        complete: function(){
          $("#loading-spinner").addClass("d-none");
        }
      })
    })
  })
</script>