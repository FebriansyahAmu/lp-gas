$(document).ready(function () {
  //Function untuk Product gas elpiji
  handleProductData();
  checkAuth();
  checkoutProducts();
  showAlamat();
  addCart();
});

function handleProductData() {
  var id = getProductId();
  if (id) {
    getdatabyid(id);
  }
}

function getProductId() {
  return window.location.pathname.match(/\/product\/(\d+)/)?.[1];
}

let stok = 0;
function getdatabyid(id) {
  const productImage = document.getElementById("product-image");
  $.ajax({
    url: "/api/product/" + id,
    type: "GET",
    success: function (response) {
      if (response.status === "success") {
        // Mengisi data produk dari response
        $("#title-gas").text(response.data.Jenis_gas);
        $("#stok").text(response.data.Stok);
        $("#harga-gas").text(response.data.Harga_gas.toLocaleString());
        productImage.src = "../" + response.data.foto_gas;

        stok = parseInt(response.data.Stok);
        initializeAndSetupEvents();
        if (response.data.Stok === 0) {
          Swal.fire({
            icon: "error",
            title: "Produk Tidak Tersedia",
            text: "Maaf, produk ini sedang tidak tersedia.",
            confirmButtonText: "OK",
          });

          // Matikan tombol checkout
          document.getElementById("pay-button").disabled = true;
          document.getElementById("delivery-option").disabled = true;
        }
      }
    },
  });
}

function initializeAndSetupEvents() {
  const initializeVariable = () => {
    return {
      decrementButton: document.getElementById("decrement"),
      incrementButton: document.getElementById("increment"),
      quantityElement: document.getElementById("quantity"),
      totalPriceElement: document.getElementById("total-price"),
      deliveryOptionSelect: document.getElementById("delivery-option"),
      deliveryFeeElement: document.getElementById("delivery-fee"),
      delivElement: document.getElementById("delive"),
      quantity: parseInt(document.getElementById("quantity").value),
      pricePerUnit:
        parseFloat(
          document.getElementById("harga-gas").textContent.replace(/,/g, "")
        ) || 0, // Ambil harga dari elemen atau gunakan 0 jika kosong
      deliveryFeePerUnit: 2000,
    };
  };

  let vars = initializeVariable();

  const updateTotalPrice = () => {
    const deliveryOption = vars.deliveryOptionSelect.value;
    const isDelivery = deliveryOption === "delivery";

    // Hitung harga total tanpa biaya pengiriman
    const totalPrice = vars.quantity * vars.pricePerUnit;

    // Hitung biaya pengiriman
    const deliveryFee = isDelivery
      ? vars.quantity * vars.deliveryFeePerUnit
      : 0;

    // Hitung total harga dengan biaya pengiriman
    const totalPriceWithDelivery = totalPrice + deliveryFee;

    // Tampilkan total harga dan biaya pengiriman
    vars.totalPriceElement.textContent = `Total: Rp ${totalPriceWithDelivery.toLocaleString()}`;
    vars.deliveryFeeElement.textContent = `${deliveryFee.toLocaleString()}`;
    vars.delivElement.style.display = isDelivery ? "block" : "none";
  };

  // Tambahkan event listeners
  vars.decrementButton.addEventListener("click", () => {
    if (vars.quantity > 1) {
      vars.quantity--;
      vars.quantityElement.value = vars.quantity;
      updateTotalPrice();
    }
  });

  vars.incrementButton.addEventListener("click", () => {
    // Tambahkan pengecekan apakah quantity melebihi stok
    if (vars.quantity < stok) {
      vars.quantity++;
      vars.quantityElement.value = vars.quantity;
      updateTotalPrice();
    } else {
      alert("Jumlah tidak boleh melebihi stok yang tersedia.");
    }
  });

  vars.deliveryOptionSelect.addEventListener("change", () => {
    updateTotalPrice();
  });

  // Panggil updateTotalPrice pertama kali setelah semua event listener ditambahkan
  updateTotalPrice();
}

function checkoutProducts() {
  $("#checkout-form").on("submit", function (event) {
    event.preventDefault();

    //Validasi form
    const deliveryMethod = document.getElementById("delivery-option").value;
    const alamat = document.getElementById("addr-select").value;
    if (deliveryMethod === "") {
      event.preventDefault();
      return;
    }
    if (deliveryMethod === "delivery" && alamat === "") {
      event.preventDefault();
      return;
    }

    const idGas = getProductId();
    const deliveryfee = parseInt(
      document.getElementById("delivery-fee").textContent.replace(/[^\d]/g, "")
    );
    const totalPrice = parseInt(
      document.getElementById("total-price").textContent.replace(/[^\d]/g, "")
    );
    const titleGas = document.getElementById("title-gas").textContent;

    const formData = new FormData(this);

    // Menambahkan data tambahan ke formData
    formData.append("Id_gas", idGas);
    formData.append("jenis_gas", titleGas);
    formData.append("delivery_fee", deliveryfee);
    formData.append("total_harga", totalPrice);

    // Mengirim form menggunakan AJAX
    Swal.fire({
      title: "Konfirmasi Pesanan",
      text: "Apakah Anda yakin ingin melakukan checkout?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Lanjutkan",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/checkout", // Endpoint API untuk memproses pesanan
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            const token = response.token;
            if (token) {
              // Trigger snap popup dengan token yang diterima
              window.snap.pay(token, {
                onSuccess: function (result) {
                  console.log("Payment success:", result);
                  // Tangani hasil sukses pembayaran di sini
                },
                onPending: function (result) {
                  console.log("Waiting for payment:", result);
                  // Tangani jika pembayaran tertunda di sini
                },
                onError: function (result) {
                  console.log("Payment error:", result);
                  // Tangani jika ada error di sini
                },
              });
            } else {
              console.error("Failed to receive transaction token");
            }
          },
          error: function (xhr, status, error) {
            // Cek apakah status code 401
            if (xhr.status === 401) {
              Swal.fire({
                title: "Anda belum login",
                text: "Silahkan Login terlebih dahulu untuk membuat pesanan",
                icon: "error",
                confirmButtonText: "Login",
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "/login"; // Redirect ke halaman login
                }
              });
            } else {
              console.error("AJAX Error:", status, error);
            }
          },
        });
      }
    });
  });
}

function checkAuth() {
  $.ajax({
    url: "/checkauth",
    type: "GET",
    success: function (response) {
      // Cek apakah pengguna terautentikasi
      const isAuthenticated = response.auth === true;

      // Tambahkan event listener untuk perubahan pada select
      document
        .getElementById("addr-select")
        .addEventListener("change", function () {
          if (this.value === "add-new") {
            if (isAuthenticated) {
              // Jika pengguna terautentikasi, arahkan ke halaman tambah alamat
              window.location.href = "/account/alamat";
            } else {
              // Jika pengguna tidak terautentikasi, tampilkan Swal
              Swal.fire({
                title: "Info",
                text: "Anda belum login, silahkan login untuk melanjutkan ordering",
                icon: "info",
                confirmButtonText: "Login",
              }).then((result) => {
                // Redirect ke halaman login setelah konfirmasi
                if (result.isConfirmed) {
                  window.location.href = "/login";
                }
              });
            }
          }
        });
    },
    error: function () {
      console.error("Gagal melakukan cek autentikasi");
    },
  });
}

function truncateText(text, maxLength) {
  if (text.length > maxLength) {
    return text.substring(0, maxLength) + "...";
  }
  return text;
}

function getAlamat() {
  // Menambahkan opsi "Tambah Alamat" terlebih dahulu
  var addressSelect = document.getElementById("addr-select");

  // Reset isi select terlebih dahulu
  addressSelect.innerHTML =
    '<option value="" disabled selected>Pilih Alamat</option>';

  // Tambahkan opsi "Tambah Alamat"
  const addOption = document.createElement("option");
  addOption.value = "add-new"; // Nilai unik untuk mendeteksi opsi ini
  addOption.classList.add("bg-primary");
  addOption.classList.add("text-center");
  addOption.textContent = "    + Tambah Alamat"; // Teks untuk opsi "Tambah Alamat"
  addressSelect.appendChild(addOption);

  // Menampilkan elemen div jika belum terlihat
  document.getElementById("address-option").style.display = "block";

  // Panggilan AJAX untuk mendapatkan alamat
  $.ajax({
    url: "/Alamat",
    type: "GET",
    success: function (response) {
      if (typeof response === "string") {
        try {
          response = JSON.parse(response); // Parsing jika respons berupa string JSON
        } catch (e) {
          console.error("Gagal parsing JSON:", e);
          return;
        }
      }

      // Pastikan response.data ada
      if (response && Array.isArray(response.data)) {
        const alamatArray = response.data;

        // Tambahkan opsi untuk setiap alamat dari respons
        alamatArray.forEach((alamat) => {
          const maxLength = 50;
          const fullText = `${alamat.Detail_alamat} - ${alamat.Description}`;
          const truncatedText = truncateText(fullText, maxLength);

          const option = document.createElement("option");
          option.value = alamat.id_Alamat;
          option.textContent = truncatedText;

          // Tambahkan ke select sebelum opsi "Tambah Alamat"
          addressSelect.insertBefore(option, addOption);
        });
      } else {
        console.error("Response tidak sesuai dengan format yang diharapkan.");
      }
    },
    error: function () {
      console.error("Gagal mendapatkan alamat");
    },
  });
}

// document.getElementById("addr-select").addEventListener("change", function () {
//   if (this.value === "add-new") {
//     window.location.href = "/account/alamat";
//   }
// });

function showAlamat() {
  $("#delivery-option").on("change", function () {
    const selectedOption = $(this).val();

    if (selectedOption === "delivery") {
      $("#address-option").show();
      getAlamat();
    } else {
      $("#address-option").hide();
    }
  });
}

function addCart() {
  $("#cart-button").on("click", function () {
    const idGas = getProductId();
    const titleGas = document.getElementById("title-gas").textContent;
    const priceGas = document.getElementById("harga-gas").textContent;
    const quantityGas = parseInt(document.getElementById("quantity").value);

    const formData = {
      id_gas: idGas,
      jenis_gas: titleGas,
      harga_gas: priceGas,
      qty: quantityGas,
    };

    const jsonData = JSON.stringify(formData);

    $.ajax({
      url: "/api/add-cart",
      method: "POST",
      data: jsonData,
      contentType: "application/json",
      success: function (response) {
        if (response.status === "success") {
          Swal.fire("Sukses", response.message, "success");
        }
      },
      error: function (xhr, status, err) {
        Swal.fire("Error", xhr.responseJSON.message, "error");
      },
    });
  });
}
