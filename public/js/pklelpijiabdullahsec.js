$(document).ready(function () {
  submitFormDataGas();
  tabelDataGas();
  clearFormDataGas();
  getEditGas();
  deleteDataGas();

  dataCustomer();
  getHistoryPembelian();
  getTotalUser();

  getDetailOrder();
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
                // $("#tabelDataGas").DataTable().ajax.reload();
                window.location.reload();
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
    $("#formDataGas").removeData("id");
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
  var table = $("#tabelRiwayatPembelianA").DataTable({
    responsive: true,
    scrollX: true,
    ajax: {
      url: "/data/riwayat-pembelian",
      dataSrc: "data",
      complete: function (response) {
        var totalOrders =
          response.responseJSON && response.responseJSON.data
            ? response.responseJSON.data.length
            : 0;
        $("#totalOrders").text(totalOrders);

        if (totalOrders === 0) {
          // Tampilkan pesan "Belum ada data" jika data kosong
          $("#tabelRiwayatPembelianA tbody").html(
            '<tr><td colspan="7" class="text-center">Belum ada data</td></tr>'
          );
        }
      },
      error: function (xhr, status, error) {},
    },
    columns: [
      { data: "id_Order" },
      { data: "Nama_lengkap" },
      { data: "total_qty" },
      { data: "delivery_method" },
      { data: "delivery_fee" },
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
        data: null,
        render: function (data, type, row) {
          return `
                          <button class="btn btn-sm btn-primary btn-detail" data-id="${data.id_Order}">
                                Detail
                          </button>
                    `;
        },
      },
    ],
    order: [[0, "desc"]],
    language: {
      emptyTable: "Belum ada data", // Tampilkan pesan khusus ketika tabel kosong
    },
  });
}

function getDetailOrder() {
  $("#tabelRiwayatPembelianA").on("click", ".btn-detail", function () {
    const orderId = $(this).data("id");

    console.log(orderId);

    // Ambil data detail order dari server
    $.ajax({
      url: "/data/detail-pembelian/" + orderId,
      method: "GET",
      success: function (response) {
        const data = response.data; // Ambil data dari response
        const $tbody = $("#tabelDetail tbody");

        // Kosongkan tabel sebelum mengisi
        $tbody.empty();

        // Tambahkan data ke tabel
        if (data.length > 0) {
          data.forEach((item) => {
            $tbody.append(`
                <tr>
                  <td>${item.Jenis_gas}</td>
                  <td>${item.Qty}</td>
                  <td>${item.totalharga}</td>
                  <td>${item.created_at}</td>
                </tr>
              `);
          });

          // Gabungkan alamat dan deskripsi atau tampilkan pesan jika alamat null
          let alamatLengkap;
          if (data[0].Detail_alamat) {
            alamatLengkap = `${data[0].Detail_alamat} - ${data[0].Description}`;
          } else {
            alamatLengkap =
              "Metode pengambilan Ambil ditempat, alamat tidak dipilih";
          }

          $("#alamatPengiriman").html(
            `<p><strong>Alamat Pengiriman:</strong> ${alamatLengkap}</p>`
          );
        } else {
          $tbody.append(
            '<tr><td colspan="4" class="text-center">Belum ada data</td></tr>'
          );
          $("#alamatPengiriman").html(""); // Kosongkan jika tidak ada data
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching order details:", error);
      },
    });

    $("#detailOrder").modal("show");
    $("#detailOrderModalLabel").text("Detail Order");
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
