<div class="container h-100">
        <div
          class="row d-flex align-items-center justify-content-center h-100 p-2"
        >
          <div
            class="col-md-12 col-lg-5 col-xl-6 p-5 rounded"
            style="background-color: rgba(0, 0, 0, 0.3); "
          >
            <h2 class="mb-3 text-center text-light">Register</h2>
            <p class="text-light">Silahkan isi form ini dengan data yang valid</p>
            <form id="fregister" class="row g-3 needs-validation" novalidate >
              <div class="col-12 text-light">
                <label for="namalengkap" class="form-label"
                  >Nama Lengkap</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="namalengkap"
                  name="namalengkap"
                  required
                  autocomplete="off"
                />
                <div class="invalid-feedback">Name Cannot be empty.</div>
              </div>

              <div class="col-12 text-light">
                <label for="email" class="form-label">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  required
                  autocomplete="off"
                />
                <div class="invalid-feedback">
                  Please provide a valid email.
                </div>
              </div>

              <div class="col-12 text-light">
                <label for="nohp" class="form-label">No Hp</label>
                <input
                  type="number"
                  class="form-control"
                  id="phone"
                  name="phone"
                  required
                  autocomplete="off"
                />
                <div class="invalid-feedback">
                  Please provide a valid phone number.
                </div>
              </div>

              
              <div class="col-12 position-relative text-light">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                  <input
                      type="password"
                      class="form-control"
                      id="password"
                      name="password"
                      required
                      autocomplete="off"
                  />
                  <span
                      class="input-group-text"
                      onclick="togglePassword('password', 'togglePasswordIcon')"
                  >
                      <i id="togglePasswordIcon" class="fas fa-eye"></i>
                  </span>
              </div>
              <div class="invalid-feedback" id="passwordFeedback">
                  Password must be at least 8 characters.
              </div>
          </div>

          <div class="col-12 position-relative text-light">
              <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
              <div class="input-group">
                  <input
                      type="password"
                      class="form-control"
                      id="confirmPassword"
                      required
                      autocomplete="off"
                  />
                  <span
                      class="input-group-text"
                      onclick="togglePassword('confirmPassword', 'toggleConfirmPasswordIcon')"
                  >
                      <i id="toggleConfirmPasswordIcon" class="fas fa-eye"></i>
                  </span>
              </div>
              <div class="invalid-feedback" id="confirmPasswordFeedback">
                  Passwords do not match.
              </div>
          </div>

              <div class="col-12 d-flex justify-content-center mt-5">
                <button class="btn btn-md btn-primary px-4 py-2" type="submit">
                  Register
                </button>
              </div>
              <p class="text-white">Sudah punya Akun?<a href="/login" class="text-decoration-none"> Login</a></p>
            </form>
          </div>
        </div>
      </div>

  

  <script>
    (() => {
      "use strict";
      const forms = document.querySelectorAll(".needs-validation");
      Array.from(forms).forEach((form) => {
        form.addEventListener(
          "submit",
          (event) => {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }

            form.classList.add("was-validated");
          },
          false
        );
      });
    })();
  </script>
  <script>
   $(document).ready(function(){
    togglePassword();
    submitRegister();
   })

  function togglePassword(fieldId, iconId) {
    const passwordField = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    
    console.log(passwordField, icon);  

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


   function submitRegister(){
    $("#fregister").submit(function(event){
        event.preventDefault();
        var formData = new FormData(this);

        var password  = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();

        if (password.length < 8) {
            Swal.fire('Error', 'Password harus minimal 8 karakter', 'error');
            return;
        }

        if (password !== confirmPassword) {
            Swal.fire('Error', 'Password tidak cocok', 'error');
            return;
        }
        $("#loading-spinner").removeClass("d-none");
        $.ajax({
          url: '/auth/register',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",
          success: function(response){
            $("#loading-spinner").addClass("d-none");
              if(response.status === 'success'){
                Swal.fire('Success', response.message, 'success');
              }
          },
          error: function(xhr, status, error){
            Swal.fire('Error', xhr.responseJSON.message, 'error');
          },
          complete: function(){
            $("#loading-spinner").addClass("d-none");
          }
        })
      })
   }

   
  </script>
</html>
