$(document).ready(function () {
  //function bagian home
  fetchProducts();

  //Function halaman register
  submitRegister();

  //Function halaman login
  login();

  //Function untuk lupa password
  sendResetLink();
  sendResetPassword();

  //function account
  getHistoryUID();
  tabelAlamats();
  clearFormAlamat();
  getEditAlamatData();
  submitFormAlamat();
  deleteAlamat();
});

//Submit form register
function submitRegister() {
  $("#fregister").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);

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

//Function untuk login
function login() {
  $("#flogin").submit(function (event) {
    event.preventDefault();
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

//bagian home, fetching data gas elpiji
function fetchProducts() {
  $.ajax({
    url: "/api/products",
    method: "GET",
    success: function (response) {
      if (response.status === "success") {
        displayProducts(response.data);
      }
    },
    error: function (xhr, status, error) {
      console.error(xhr.responseText);
    },
  });
}
//display gas elpiji
function displayProducts(products) {
  products.forEach((product, index) => {
    let productCard = `
        <div class="col-md-4 col-sm-6 col-12 mb-4" data-aos="fade-up" data-aos-delay="${
          index * 200
        }" data-aos-duration="800">
          <div class="card shadow-lg hover-shadow zoom-effect">
            <img class="card-img-top img-fluid" src="img/gas.jpeg" alt="${
              product.Jenis_gas
            }" />
            <div class="card-body">
              <div class="text-center">
                <span class="badge text-bg-success text-center fs-6">Rp.${
                  product.Harga_gas
                }</span>
              </div>
              <h5 class="card-title">${product.Jenis_gas}</h5>
              <p class="card-text">Stok: ${product.Stok}</p>
              <div class="d-flex justify-content-center mb-4">
                <a href="/product/${
                  product.id_gas
                }" class="btn btn-primary p-2">Pesan Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      `;
    $("#product-container").append(productCard);
  });
}

//Function untuk lupa password
function sendResetLink() {
  $("#forgotPasswordForm").submit(function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    console.log(formData);
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

//bagian Account
function getHistoryUID() {
  $("#tabelRiwayatPembelian").DataTable({
    destroy: true,
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/riwayat-pembelian",
      dataSrc: "data",
    },
    columns: [
      { data: "id_Order" },
      { data: "Jenis_gas" },
      { data: "Qty" },
      { data: "totalharga" },
      {
        data: "status",
        render: function (data, type, row) {
          if (data === "pending") {
            return '<span class="badge text-bg-warning">pending</span>';
          } else if (data === "paid") {
            return '<span class="badge text-bg-success">success</span>';
          }
        },
      },
    ],
    columnDefs: [
      { width: "5%", targets: 0 },
      { width: "5%", targets: 1 },
      { width: "2%", targets: 2 },
      { width: "2%", targets: 3 },
      { width: "2%", targets: 4 },
    ],
  });
}

//alamat
function tabelAlamats() {
  $("#tabelAlamat").DataTable({
    destroy: true,
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/Alamat",

      dataSrc: "data",
    },
    columns: [
      { data: "id_Alamat" },
      { data: "Detail_alamat" },
      { data: "Description" },
      {
        data: null,
        render: function (data, type, row) {
          return `
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${data.id_Alamat}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id_Alamat}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
        },
      },
    ],
    columnDefs: [
      { width: "5%", targets: 0 },
      { width: "40%", targets: 1 },
      { width: "30%", targets: 2 },
      { width: "5%", targets: 3 },
    ],
  });
}

function clearFormAlamat() {
  $("#btnTambahAlamat").click(function () {
    $("#formAlamat")[0].reset();
    $("#modalAlamatLabel").text("Tambah Data Alamat");

    $("#alamatModal").modal("show");
  });
}

function getEditAlamatData() {
  $("#tabelAlamat").on("click", ".btn-edit", function () {
    const idAlamat = $(this).data("id");
    $("#modalAlamatLabel").text("Edit Data Alamat");

    $.ajax({
      url: "/Alamat/" + idAlamat,
      type: "GET",
      success: function (response) {
        if (typeof response === "string") {
          try {
            response = JSON.parse(response);
          } catch (e) {
            console.error("Gagal parsing JSON:", e);
            return;
          }
        }

        if (response && response.data) {
          $("#detailAlamat").val(response.data.Detail_Alamat);
          $("#description").val(response.data.Description);

          $("#formAlamat").data("id", idAlamat);
          $("#modalAlamatLabel").text("Edit Data Alamat");

          $("#alamatModal").modal("show");
        } else {
          alert("Data tidak ditemukan");
        }
      },
      error: function (xhr, status, error) {
        alert("Terjadi kesalahan", +error);
      },
    });
  });
}

function deleteAlamat() {
  $("#tabelAlamat").on("click", ".btn-delete", function () {
    const idAlamat = $(this).data("id");

    Swal.fire({
      title: "Apakah Anda yakin?",
      text: "Anda akan menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/Alamat/Delete/" + idAlamat,
          method: "DELETE",
          success: function (response) {
            if (typeof response === "string") {
              response = JSON.parse(response);
            }
            if (response.status === "success") {
              Swal.fire(
                "Deleted!",
                "Your data has been deleted.",
                "success"
              ).then(() => {
                $("#tabelAlamat").DataTable().ajax.reload();
              });
            }
          },
          error: function (xhr, status, error) {
            alert("Terjadi kesalahan", +error);
          },
        });
      }
    });
  });
}

function submitFormAlamat() {
  $("#submitAlamat").click(function () {
    $("#formAlamat").submit();
  });

  $("#formAlamat").submit(function (event) {
    event.preventDefault();

    const idAlamat = $(this).data("id");

    const url = idAlamat ? `/Alamat/Edit` : "/Alamat/Create";
    const method = idAlamat ? "PUT" : "POST";

    const data = {
      Detail_alamat: $("#detailAlamat").val(),
      Description: $("#description").val(),
      id_Alamat: idAlamat,
    };

    $.ajax({
      url: url,
      method: method,
      contentType: "application/json",
      data: JSON.stringify(data),
      processData: false,
      success: function (response) {
        if (response.status === "success") {
          Swal.fire("Success", response.message, "success");
          $("#tabelAlamat").DataTable().ajax.reload();
        }
      },
      error: function (xhr, status, error) {
        alert("Terjadi kesalahan: " + error);
      },
    });
  });
}
