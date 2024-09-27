<link rel="stylesheet" href="/css/prodctAdditionalcss.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script
  type="text/javascript"
  src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key=""
></script>
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
            <h2 class="mb-3" id="title-gas"></h2>

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

            <button type="submit" id="pay-button" class="btn btn-primary">
              Checkout
            </button>
          </div>
        </form>
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
