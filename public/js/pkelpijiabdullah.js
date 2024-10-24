$(document).ready(function () {
  //function bagian home

  getHistoryUID();
  tabelAlamats();
  clearFormAlamat();
  getEditAlamatData();
  submitFormAlamat();
  pilihAlamat();
  deleteAlamat();
  selesaikanPemesanana();
});

//Submit form register

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
    // Tentukan warna shadow berdasarkan index
    let shadowColor = index === 0 ? "green-purple-shadow" : "pink-shadow";

    // Tentukan apakah produk stoknya 0, jika iya maka tambahkan class disabled
    let isDisabled = product.Stok == 0 ? "disabled" : "";
    let disableMessage =
      product.Stok == 0 ? "<span class='text-danger'>Stok Habis</span>" : "";

    let productCard = `
        <div class="col-md-4 col-sm-6 col-12 mb-4" data-aos="fade-up" data-aos-delay="${
          index * 200
        }" data-aos-duration="800">
          <div class="card hover-shadow zoom-effect ${shadowColor}">
            <img class="card-img-top img-fluid" src="${
              product.foto_gas
            }" alt="${product.Jenis_gas}" />
            <div class="card-body">
              <div class="text-center">
                <span class="badge text-bg-success text-center fs-6">Rp.${
                  product.Harga_gas
                }</span>
              </div>
              <h5 class="card-title">${product.Jenis_gas}</h5>
              
              <p class="card-text">Stok: ${product.Stok} ${disableMessage}</p>
               <!-- Tampilkan pesan stok habis jika stoknya 0 -->
              <div class="d-flex justify-content-center mb-4">
                <a href="/product/${
                  product.id_gas
                }" class="btn btn-primary p-2 ${isDisabled}">Pesan Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      `;
    $("#product-container").append(productCard);
  });
}

//Function untuk lupa password

//bagian Account
function getHistoryUID() {
  $("#tabelRiwayatPembelian").DataTable({
    destroy: true,
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/riwayat-pembelian",
      dataSrc: "data",
      error: function (xhr, error, thrown) {
        // Kosongkan tabel jika ada kesalahan
        $("#tabelRiwayatPembelian").DataTable().clear().draw();

        // Tampilkan pesan no data found
        $("#tabelRiwayatPembelian tbody").html(
          '<tr><td colspan="5" class="text-center">No data found</td></tr>'
        );
      },
    },
    columns: [
      { data: "id_Order" },
      { data: "total_qty" },
      { data: "total_harga" },
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
      {
        data: null, // Kolom untuk tombol 'Selesaikan Pemesanan'
        render: function (data, type, row) {
          // Jika ada snap_token, tampilkan tombol 'Selesaikan Pemesanan'
          if (row.snap_token) {
            return (
              '<button class="btn btn-primary btn-sm complete-order" data-order-id="' +
              row.id_Order +
              '" data-token="' +
              row.snap_token +
              '">Selesaikan Pemesanan</button>'
            );
          }
          return "";
        },
      },
    ],
    columnDefs: [
      { width: "5%", targets: 0 },
      { width: "2%", targets: 1 },
      { width: "2%", targets: 2 },
      { width: "2%", targets: 3 },
      { width: "2%", targets: 4 },
    ],
    order: [[0, "desc"]],
  });
}

//selesaikan pemesanana menggunakan snapToken;
function selesaikanPemesanana() {
  $("#tabelRiwayatPembelian").on("click", ".complete-order", function () {
    var snapToken = $(this).data("token");

    window.snap.pay(snapToken, {
      onSuccess: function (result) {
        Swal.fire("Success", "Pemesanan berhasil", "success");
        $("#tabelRiwayatPembelian").DataTable().ajax.reload();
      },
      onPending: function (result) {
        Swal.fire("Pending", "Menunggu Pembayaran", "warning");
      },
      onError: function (result) {
        Swal.fire("Error", "Pemesanan gagal", "error");
      },
    });
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
      error: function (xhr, error, thrown) {
        // Kosongkan tabel jika ada kesalahan
        $("#tabelAlamat").DataTable().clear().draw();

        // Tampilkan pesan no data found
        $("#tabelAlamat tbody").html(
          '<tr><td colspan="5" class="text-center">Belum ada alamat</td></tr>'
        );
      },
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
      {
        data: null,
        className: "text-center",
        render: function (data, type, row) {
          return `
                            <button class="btn btn-sm  btn-success btn-pAlamat" data-id="${data.id_Alamat}">
                                Pilih Alamat
                            </button>
                        `;
        },
      },
      {
        data: "Status",
        className: "text-center",
        render: function (data, type, row) {
          if (data === "secondary") {
            return '<span class="badge bg-warning">Secondary</span>';
          } else if (data === "utama") {
            return '<span class="badge bg-success">Utama</span>';
          } else {
            return '<span class="badge bg-secondary">Unknown</span>'; // Jika ada status lain
          }
        },
      },
    ],
    columnDefs: [
      { width: "5%", targets: 0 },
      { width: "40%", targets: 1 },
      { width: "30%", targets: 2 },
      { width: "5%", targets: 3 },
      { width: "15%", targets: 4 },
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

function pilihAlamat() {
  $("#tabelAlamat").on("click", ".btn-pAlamat", function () {
    const idAlamat = $(this).data("id");

    $.ajax({
      url: "/Alamat/pilih-alamat/" + idAlamat,
      method: "POST",
      success: function (response) {
        if (response.status === "success") {
          Swal.fire("Sukses", response.message, "success").then(() => {
            $("#tabelAlamat").DataTable().ajax.reload();
          });
        }
      },
      error: function (xhr, status, error) {
        Swal.fire("Error", xhr.responseJSON.message, "error");
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
    $("#loading-spinner").removeClass("d-none");
    $.ajax({
      url: url,
      method: method,
      contentType: "application/json",
      data: JSON.stringify(data),
      processData: false,
      success: function (response) {
        $("#loading-spinner").addClass("d-none");
        if (response.status === "success") {
          Swal.fire("Success", response.message, "success");
          // $("#tabelAlamat").DataTable().ajax.reload();
          window.location.reload();
        }
      },
      error: function (xhr, status, error) {
        alert("Terjadi kesalahan: " + error);
      },
      complete: function () {
        $("#loading-spinner").addClass("d-none");
      },
    });
  });
}
