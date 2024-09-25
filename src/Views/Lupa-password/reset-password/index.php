<div class="container py-5 h-100">
  <div class="row d-flex justify-content-center align-items-center h-100">
    <div
      class="col-md-6 p-5 rounded text-white"
      style="background-color: rgba(0, 0, 0, 0.2)"
    >
      <h2 class="mb-4 text-center">Reset Password</h2>
      <form id="resetPasswordForm" class="needs-validation" novalidate>
        <div class="mb-3">
          <label for="password" class="form-label">Password Baru</label>
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

            <div class="invalid-feedback">Password tidak boleh kosong.</div>
          </div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Konfirmasi Password</label>
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
            <div class="invalid-feedback" id="confirmPasswordFeedback">
              Passwords do not match.
            </div>
          </div>
        </div>
        <input type="hidden" name="resToken" value="<?= htmlspecialchars($data['resToken']) ?>">
        <div class="text-center mb-4 mt-4">
          <button type="submit" class="btn btn-primary">Rest Password</button>
        </div>
      </form>
      <a href="/login" class="text-end text-decoration-none">Login sekarang</a>
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