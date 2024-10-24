<link rel="stylesheet" href="/css/prodctAdditionalcss.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
$clientKey = $_ENV['CLIENT_KEY'];
  echo '
  <script
    type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="' . $clientKey . '"
  ></script>
  ';
?>
<section class="d-flex justify-content-center align-items-center">
  <div class="container">
    <div
      class="row"
      style="padding: 15px; margin-bottom: 150px; margin-top: 150px"
    >
      <!-- Kolom Kiri: Gambar Produk -->
      <div class="col-md-6 mb-4 p-5 d-flex justify-content-center">
        <img
          src=""
          alt="Product Image"
          class="product-image"
          id="product-image"
        />
      </div>

      <div class="col-md-6">
        <form id="checkout-form" class="needs-validation" novalidate>
          <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 id="title-gas"></h2>

            </div>

            <div class="mb-3">
              <h5>Stok Tersedia: <span id="stok"></span></h5>
            </div>

            <div class="mb-4">
              <h5>Quantity</h5>
              <div class="quantity-controls d-flex">
                <button
                  type="button"
                  id="decrement"
                  class="btn btn-outline-secondary"
                >
                  -
                </button>
                <input
                  id="quantity"
                  name="quantity"
                  type="text"
                  class="form-control mx-2 text-center"
                  value="1"
                  readonly
                  required
                />
                <button
                  type="button"
                  id="increment"
                  class="btn btn-outline-secondary"
                >
                  +
                </button>
                <div class="invalid-feedback">Jumlah harus minimal 1.</div>
              </div>
            </div>

            <div class="mb-4">
              <h5>Metode Pengambilan</h5>
              <select
                id="delivery-option"
                name="delivery_method"
                class="form-select"
                required
              >
                <option value="" disabled selected>
                  Pilih metode pengambilan
                </option>
                <option value="regular">Ambil di tempat</option>
                <option value="delivery">Diantar langsung</option>
              </select>
              <div class="invalid-feedback">
                Silakan pilih metode pengambilan.
              </div>
            </div>

            <div class="mb-4" id="address-option" style="display: none">
              <h5>Pilih Alamat</h5>
              <select
                id="addr-select"
                name="alamat"
                class="form-select"
                required
              ></select>
              <div class="invalid-feedback">
                Silakan pilih metode pengambilan.
              </div>
            </div>

            <div class="mb-4 ttl-hrga">
              <h5>Harga</h5>
              <p>Harga /tabung: Rp <span id="harga-gas"></span></p>
              <p id="delive" style="display: none">
                Biaya Delivery: Rp <span id="delivery-fee"></span>
              </p>

              <div class="mt-2">
                <p class="fw-bold fs-3" id="total-price">Rp 0</p>
              </div>
            </div>

            <div class="d-flex align-items-center gap-2">
             <button type="button" id="cart-button" class="btn btn-secondary">
                <i class="fas fa-shopping-cart"></i> +Keranjang
              </button>
              <button type="submit" id="pay-button" class="btn btn-primary">
                Checkout
              </button>
            </div>
          </div>
        </form>
      </div>
      <!-- Modal untuk Menulis Ulasan -->
      <!-- Modal -->
      <div
        class="modal fade"
        id="reviewModal"
        tabindex="-1"
        aria-labelledby="reviewModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="reviewModalLabel">
                Bagikan Ulasan Anda
              </h5>
              <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body">
              <form id="reviewForm" class="needs-validation" novalidate>
                <div class="mb-3">
                  <label for="rating" class="form-label">Penilaian:</label>
                  <div class="star-rating d-flex gap-1">
                    <input
                      type="radio"
                      id="star5"
                      name="rating"
                      value="5"
                      required
                    />
                    <label for="star5" title="Sempurna">★</label>
                    <input
                      type="radio"
                      id="star4"
                      name="rating"
                      value="4"
                      required
                    />
                    <label for="star4" title="Bagus">★</label>
                    <input
                      type="radio"
                      id="star3"
                      name="rating"
                      value="3"
                      required
                    />
                    <label for="star3" title="Cukup">★</label>
                    <input
                      type="radio"
                      id="star2"
                      name="rating"
                      value="2"
                      required
                    />
                    <label for="star2" title="Kurang">★</label>
                    <input
                      type="radio"
                      id="star1"
                      name="rating"
                      value="1"
                      required
                    />
                    <label for="star1" title="Buruk">★</label>
                  </div>
                  <div class="invalid-feedback">Silakan pilih penilaian!</div>
                </div>
                <div class="mb-3">
                  <textarea
                    id="ulasan"
                    name="ulasan"
                    rows="4"
                    class="form-control"
                    placeholder="Tuliskan ulasan Anda contoh: 'Barang sesuai'"
                    required
                  ></textarea>
                  <div class="invalid-feedback">
                    Silakan tuliskan ulasan Anda!
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">
                  Kirim Ulasan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
(function () {
  "use strict";
  var forms = document.querySelectorAll(".needs-validation");

  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
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

<script src="/js/pkelpijiprodct.js"></script>
