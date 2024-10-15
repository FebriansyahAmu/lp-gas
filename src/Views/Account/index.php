<script
  type="text/javascript"
  src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key=""
></script>
<section
  class="d-flex justify-content-center align-items-center py-5"
  style="min-height: 100vh"
>
  <div
    class="container p-4 rounded shadow bg-light mt-5"
    style="min-height: 60vh"
  >
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4">
      <li class="nav-item">
        <a
          class="nav-link active"
          aria-current="page"
          href="#tab1"
          data-bs-toggle="tab"
          >Riwayat Pembelian</a
        >
      </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
      <div class="tab-pane fade show active" id="tab1">
        <h3>List Riwayat Pembelian</h3>
        <div class="mt-4">
          <table id="tabelRiwayatPembelian" class="display">
            <thead>
              <tr>
                <th>Order Id</th>
                <th>Total Qty</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
