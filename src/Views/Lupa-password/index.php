<div class="container py-5 h-100" >
  <div class="row d-flex justify-content-center align-items-center h-100 p-2">
    <div class="col-md-6 p-5 rounded  text-white" style="background-color: rgba(0, 0, 0, 0.2)">
      <h2 class="mb-4 text-center">Lupa Password</h2>
      <form id="forgotPasswordForm" class="needs-validation" novalidate>
        <div class="mb-3 ">
          <label for="email" class="form-label">Alamat Email :</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            required
            autocomplete="off"
          />
          <div class="invalid-feedback">Silakan masukkan alamat email yang valid.</div>
        </div>
        <div class="text-center mb-4 mt-4">
            <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
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

$(document).ready(function(){
  sendResetLink();
});
</script>
