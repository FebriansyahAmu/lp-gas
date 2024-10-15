$(document).ready(function () {
  submitFormDataGas();
  tabelDataGas();
  clearFormDataGas();
  getEditGas();
  deleteDataGas();

  dataCustomer();
  getHistoryPembelian();
  getTotalUser();
});
function submitFormDataGas() {
  $("#formDataGas").submit(function (event) {
    event.preventDefault();

    const idGas = $("#formDataGas").data("id");
    const url = idGas ? "/gas/edit" : "/gas/create";
    // const method = idGas ? 'PUT' : 'POST';

    const formData = new FormData(this);

    if (idGas) {
      formData.append("idGas", idGas);
    }

    if (idGas && $("#GambarGas").get(0).files.length === 0) {
      formData.delete("gambarGas");
    }

    Swal.fire({
      title: "Konfirmasi",
      text: "Anda yakin ingin menyimpan data ini?",
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, simpan!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: url,
          method: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            if (response.status === "success") {
              Swal.fire("Success", response.message, "success").then(() => {
                $("#tabelDataGas").DataTable().ajax.reload();
              });
            }
          },
          error: function (xhr, status, error) {
            Swal.fire("Error", xhr.responseJSON.message, "error");
          },
        });
      }
    });
  });
}

function tabelDataGas() {
  $("#tabelDataGas").DataTable({
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/api/products",
      dataSrc: "data",
    },
    columns: [
      { data: "id_gas" },
      { data: "Jenis_gas" },
      { data: "Harga_gas" },
      { data: "Stok" },
      {
        data: null,
        render: function (data, type, row) {
          return `
                  <button class="btn btn-sm btn-primary btn-edit" data-id="${data.id_gas}">
                        <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id_gas}">
                        <i class="bi bi-trash"></i>
                  </button>
            `;
        },
      },
    ],
  });
}

function clearFormDataGas() {
  $("#btnTambahGas").click(function () {
    // Reset form input
    $("#formDataGas")[0].reset();
    $("#dataGasModalLabel").text("Tambah Gas");

    // Reset image preview
    $("#gambarGasPreview").attr("src", "").hide();
  });
}

function getEditGas() {
  $("#tabelDataGas").on("click", ".btn-edit", function () {
    const idGas = $(this).data("id");
    $("#formDataGas").data("id", idGas);
    $("#dataGasModalLabel").text("Edit Data Gas");

    $.ajax({
      url: "/api/product/" + idGas,
      method: "GET",
      success: function (response) {
        if (response.data) {
          $("#JenisGas").val(response.data.Jenis_gas);
          $("#HargaGas").val(response.data.Harga_gas);
          $("#Stok").val(response.data.Stok);

          if (response.data.foto_gas) {
            $("#gambarGasPreview").attr("src", response.data.foto_gas);
            $("#gambarGasPreview").show(); // Tampilkan gambar
            // $('#currentGambar').val(response.data.foto_gas);
          } else {
            $("#gambarGasPreview").hide(); // Sembunyikan gambar jika tidak ada
          }

          $("#dataGasModal").modal("show");
        } else {
          alert("Data Gas Tidak Ditemukan");
        }
      },
      error: function (xhr, status, error) {
        alert("Terjadi Kesalahan", +error);
      },
    });
  });
}

function deleteDataGas() {
  $("#tabelDataGas").on("click", ".btn-delete", function () {
    const idGas = $(this).data("id");

    Swal.fire({
      title: "Apakah anda yakin?",
      text: "Anda akan menghapus data ini!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus data",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/gas/delete/" + idGas,
          method: "DELETE",
          success: function (response) {
            if (response.status === "success") {
              Swal.fire("Deleted!", response.message, "success").then(() => {
                $("#tabelDataGas").DataTable().ajax.reload();
              });
            }
          },
          error: function (xhr, status, error) {
            Swal.fire(
              "Error!",
              "Terjadi kesalahan, silahkan coba lagi nanti",
              "error"
            );
          },
        });
      }
    });
  });
}
function dataCustomer() {
  $("#tabelDataCustomer").DataTable({
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/data/customers",
      dataSrc: "data",
    },
    columns: [
      { data: "user_id" },
      { data: "Nama_lengkap" },
      { data: "Email" },
      { data: "No_Hp" },
    ],
  });
}

function getHistoryPembelian() {
  var table = $("#tabelRiwayatPembelian").DataTable({
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/data/riwayat-pembelian",
      dataSrc: "data",
      complete: function (response) {
        // Hitung jumlah data
        var totalOrders = response.responseJSON.data.length;
        // Update elemen h3 di dalam .small-box dengan jumlah pesanan
        $("#totalOrders").text(totalOrders);
      },
    },
    columns: [
      { data: "id_Order" },
      { data: "Nama_lengkap" },
      { data: "Jenis_gas" },
      { data: "Qty" },
      { data: "delivery_method" },
      { data: "delivery_fee" },
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
  });
}

function getTotalUser() {
  $.ajax({
    url: "/data/total-customer",
    method: "GET",
    success: function (response) {
      const totalUsers = response.data["count(user_id)"];
      $("#totalUsers").text(totalUsers);
    },
  });
}
