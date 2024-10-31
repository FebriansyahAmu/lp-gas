$(document).ready(function () {
  //Function halaman register
  submitRegister();
  //Function halaman login

  //Function untuk lupa password
  sendResetPassword();

  //function account
});
(() => {
  "use strict";

  const forms = document.querySelectorAll(".needs-validation");

  const validateInput = (input, isValid) => {
    if (isValid) {
      input.classList.remove("is-invalid");
      input.classList.add("is-valid");
    } else {
      input.classList.add("is-invalid");
      input.classList.remove("is-valid");
    }
  };

  const toggleFeedback = (feedbackElement, isVisible) => {
    feedbackElement.style.display = isVisible ? "block" : "none";
  };

  const setupRealTimeValidation = (input, feedbackElement, validator) => {
    input.addEventListener("input", () => {
      const isValid = validator(input);
      validateInput(input, isValid);
      toggleFeedback(feedbackElement, !isValid);
    });
  };

  const setupFormValidation = (form) => {
    const password = form.querySelector("#password");
    const confirmPassword = form.querySelector("#confirmPassword");
    const feedbackPassword = form.querySelector("#passwordFeedback");
    const feedbackConfirmPassword = form.querySelector(
      "#confirmPasswordFeedback"
    );
    const nameInput = form.querySelector("#namalengkap");
    const emailInput = form.querySelector("#email");
    const phoneInput = form.querySelector("#phone");

    // Real-time validations
    setupRealTimeValidation(
      nameInput,
      null,
      (input) => input.value.trim() !== ""
    );
    setupRealTimeValidation(emailInput, null, (input) => input.checkValidity());
    setupRealTimeValidation(phoneInput, null, (input) => input.checkValidity());

    // Password length validation
    setupRealTimeValidation(
      password,
      feedbackPassword,
      (input) => input.value.length >= 8
    );

    // Confirmation password validation considering the password field
    setupRealTimeValidation(
      confirmPassword,
      feedbackConfirmPassword,
      (input) => password.value.trim() !== "" && input.value === password.value
    );

    // Form submission validation
    form.addEventListener("submit", (event) => {
      const isLengthValid = password.value.length >= 8;
      const isPasswordMatch = confirmPassword.value === password.value;
      const isNameValid = nameInput.value.trim() !== "";
      const isEmailValid = emailInput.checkValidity();
      const isPhoneValid = phoneInput.checkValidity();

      // Prevent form submission if any field is invalid
      if (
        !form.checkValidity() ||
        !isLengthValid ||
        !isPasswordMatch ||
        !isNameValid ||
        !isEmailValid ||
        !isPhoneValid
      ) {
        event.preventDefault();
        event.stopPropagation();

        // Validate password
        validateInput(password, isLengthValid);
        toggleFeedback(feedbackPassword, !isLengthValid);

        // Validate confirmation password
        validateInput(
          confirmPassword,
          isPasswordMatch && password.value.trim() !== ""
        );
        toggleFeedback(
          feedbackConfirmPassword,
          !(isPasswordMatch && password.value.trim() !== "")
        );

        // Validate name
        validateInput(nameInput, isNameValid);

        // Validate email
        validateInput(emailInput, isEmailValid);

        // Validate phone
        validateInput(phoneInput, isPhoneValid);
      } else {
        form.classList.add("was-validated");
      }
    });
  };
  Array.from(forms).forEach(setupFormValidation);
})();

function submitRegister() {
  $("#fregister").submit(function (event) {
    event.preventDefault();
    const form = this;
    if (!form.checkValidity()) {
      return;
    }
    var formData = new FormData(this);
    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();

    if (password.length < 8) {
      return;
    }

    if (password !== confirmPassword) {
      Swal.fire("Error", "Password tidak cocok", "error");
      return;
    }

    const recaptcha = document.querySelector(".g-recaptcha-response").value;
    if (recaptcha === "") {
      event.preventDefault();
      Swal.fire("Error", "Please complete the reCAPTCHA.", "error");
      return;
    }

    $("#loading-spinner").removeClass("d-none");
    $.ajax({
      url: "/auth/register",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        $("#loading-spinner").addClass("d-none");
        if (response.status === "success") {
          Swal.fire("Success", response.message, "success").then(() => {
            window.location.href = "/login";
          });
        }
      },
      error: function (xhr, status, error) {
        Swal.fire("Error", xhr.responseJSON.message, "error");
      },
      complete: function () {
        $("#loading-spinner").addClass("d-none");
      },
    });
  });
}

//Function untuk login
function login() {
  $("#flogin").submit(function (event) {
    event.preventDefault();
    const form = this;
    var recaptcha = document.querySelector(".g-recaptcha-response").value;

    const loginVal = $("#password").val();
    if (loginVal === "" || loginVal.length < 8) {
      return;
    }

    // Check if reCAPTCHA is fille
    if (recaptcha === "") {
      event.preventDefault();
      Swal.fire("Error", "Please complete the reCAPTCHA.", "error");
      return;
    }

    if (!form.checkValidity()) {
      event.preventDefault();
      return;
    }

    const formData = new FormData(this);
    $("#loading-spinner").removeClass("d-none");
    $.ajax({
      url: "/auth/login",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        $("#loading-spinner").addClass("d-none");
        if (response.status === "success") {
          if (response.redirect) {
            window.location.href = response.redirect;
          }
        } else if (response.status === "unverified") {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
            footer:
              '<a href="" id="resend-verification-link">Kirim link verifikasi</a>',
          });

          $("#resend-verification-link").on("click", function (e) {
            e.preventDefault();
            $("#loading-spinner").removeClass("d-none");
            $.ajax({
              url: "/auth/resend-verification",
              type: "POST",
              data: { email: response.email },
              success: function (res) {
                $("#loading-spinner").addClass("d-none");
                Swal.fire({
                  icon: "success",
                  title: "Link verifikasi dikrim",
                  text: "Silahkan cek email anda! ",
                });
              },
              error: function (xhr) {
                const errRes = JSON.parse(xhr.responseText);
                Swal.fire("Error", errRes.message, "error");
              },
              complete: function () {
                $("#loading-spinner").addClass("d-none");
              },
            });
          });
        }
      },
      error: function (xhr) {
        const errorResponse = JSON.parse(xhr.responseText);
        Swal.fire("Error", errorResponse.message, "error");
      },
      complete: function () {
        $("#loading-spinner").addClass("d-none");
      },
    });
  });
}

function sendResetPassword() {
  $("#resetPasswordForm").submit(function (event) {
    event.preventDefault();

    var password = $("#password").val();
    var confirmPassword = $("#confirmPassword").val();

    if (password.length < 8) {
      Swal.fire("Error", "Password harus minimal 8 karakter", "error");
      return;
    }

    if (password !== confirmPassword) {
      Swal.fire("Error", "Password tidak cocok", "error");
      return;
    }

    const formData = new FormData(this);

    $("#loading-spinner").removeClass("d-none");
    $.ajax({
      url: "/auth/new-password",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $("#loading-spinner").addClass("d-none");
        if (response.status === "success") {
          Swal.fire("Success", response.message, "success").then(() => {
            window.location.href = "/login";
          });
        }
      },
      error: function (xhr, status, error) {
        Swal.fire("Error", xhr.responseJSON.message, "error");
      },
      complete: function () {
        $("#loading-spinner").addClass("d-none");
      },
    });
  });
}

function sendResetLink() {
  $("#forgotPasswordForm").submit(function (event) {
    event.preventDefault();

    const form = this;
    if (!form.checkValidity()) {
      return;
    }

    const recaptcha = document.querySelector(".g-recaptcha-response").value;
    if (recaptcha === "") {
      event.preventDefault(); // Stop form submission
      Swal.fire("Error", "Please complete the reCAPTCHA.", "error");
      return;
    }

    const formData = new FormData(this);
    $("#loading-spinner").removeClass("d-none");
    $.ajax({
      url: "/auth/password-reset",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        $("#loading-spinner").addClass("d-none");
        if (response.status === "success") {
          Swal.fire("Success", response.message, "success");
        }
      },
      error: function (xhr, status, error) {
        Swal.fire("Error", xhr.responseJSON.message, "error");
      },
      complete: function () {
        $("#loading-spinner").addClass("d-none");
      },
    });
  });
}
