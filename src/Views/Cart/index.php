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
<?php component('reviewmodal'); ?>
<section
  class="d-flex justify-content-center align-items-start py-5"
  style="min-height: 100vh"
>

  <div
    class="container p-4 rounded shadow bg-light mt-5"
    style="min-height: 60vh; width: 100%; max-width: 800px"
  >
    <!-- Pilih Semua -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <input type="checkbox" id="selectAll" />
        <label for="selectAll" class="fw-bold">Pilih Semua</label>
      </div>

      <div class="mb-4">
        <select
          id="delivery-option"
          name="delivery_method"
          class="form-select"
          required
        >
          <option value="" disabled selected>Pilih metode pengambilan</option>
          <option value="regular">Ambil di tempat</option>
          <option value="delivery">Diantar langsung</option>
        </select>
        <div class="invalid-feedback">Silakan pilih metode pengambilan.</div>
      </div>
    </div>

    <!-- Card Keranjang 1 -->
    <div id="cart-container"></div>

    <!-- Ringkasan Belanja -->
    <div class="card shadow-sm mt-4">
      <div class="card-body">
        <h5 class="card-title">Ringkasan belanja</h5>
        <div class="" id="d-alamat" style="display: none">
          <h6>Dikirim Ke</h6>
          <i class="bi bi-geo-alt"></i> <span id="u-alamat" data-id=""></span
          ><a href="/account/alamat" class="text-decoration-none"
            >Ganti Alamat?</a
          >
        </div>
        <div class="d-flex justify-content-between mt-4">
          <span>Biaya Delivery</span>
          <span id="delivery-cost">Rp -</span>
        </div>
        <div class="d-flex justify-content-between">
          <span>Total</span>
          <span id="total-cost">Rp -</span>
        </div>
        <hr />
        <button class="btn btn-success w-100" id="btn-beli">Beli</button>
      </div>
    </div>
  </div>
</section>
<!-- Optional Bootstrap 5 and FontAwesome CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="/js/pklelpijicart.js"></script>

