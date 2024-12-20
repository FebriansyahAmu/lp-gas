<div class="app-content-header">
  <div class="container-fluid">
    <div class="row" style="margin-left: 34px">
      <div class="col-lg-3 col-6 mt-4">
        <!--begin::Small Box Widget 1-->
        <div class="small-box text-bg-primary">
          <div class="inner">
            <h3 id="totalOrders">0</h3>
            <p>Total Orders</p>
          </div>
          <svg
            class="small-box-icon"
            fill="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
            ></path>
          </svg>
          <a
            href="#"
            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
          >
            More info <i class="bi bi-link-45deg"></i>
          </a>
        </div>

        <!--end::Small Box Widget 1-->
      </div>
      <div class="col-lg-3 col-6 mt-4">
        <div class="small-box text-bg-warning">
          <div class="inner">
            <h3 id="totalUsers">0</h3>
            <p>Total Customers</p>
          </div>
          <svg
            class="small-box-icon"
            fill="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            aria-hidden="true"
          >
            <path
              d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
            ></path>
          </svg>
          <a
            href="/data-customer"
            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
          >
            More info <i class="bi bi-link-45deg"></i>
          </a>
        </div>
        <!--end::Small Box Widget 3-->
      </div>
    </div>
  </div>
</div>


<div
  class="modal fade"
  id="detailOrder"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1"
  aria-labelledby="staticBackdropLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="detailOrderModalLabel"></h1>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 ">
          <table id="tabelDetail" class="table table-striped">
                  <thead>
                    <tr>
                      <th>Jenis Gas LPG</th>
                      <th>Qty</th>
                      <th>Harga</th>
                      <th>Tanggal Pemesanan</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
              <div class="mt-5" id="alamatPengiriman"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary rounded-1"
          data-bs-dismiss="modal"
        >
          Kembali
        </button>

      </div>
    </div>
  </div>
</div>


<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class="card mb-4">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Riwayat Pembelian</h3>
            </div>
          </div>
          <div class="card-body">
          <div class="col-md-12 mx-auto">
              <table id="tabelRiwayatPembelianA" class="display">
                  <thead>
                    <tr>
                      <th>Order Id</th>
                      <th>Nama Lengkap</th>
                      <th>Qty</th>
                      <th>Metode Pengambilan</th>
                      <th>Delivery Fee</th>
                      <th>Total Harga</th>
                      <th>Status</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>