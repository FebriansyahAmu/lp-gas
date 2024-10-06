<section
  class="d-flex justify-content-center align-items-center py-5"
  style="min-height: 100vh"
>
  <div
    class="container p-4 rounded shadow bg-light mt-5"
    style="min-height: 60vh"
  >
    <div class="d-flex justify-content-end">
      <a
        class="btn btn-primary"
        href=""
        id="btnTambahAlamat"
        data-bs-toggle="modal"
        data-bs-target="#alamatModal"
      >
        <i class="fas fa-plus"></i> Tambah Alamat
      </a>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4">
      <li class="nav-item">
        <a
          class="nav-link active"
          aria-current="page"
          href="#tab1"
          data-bs-toggle="tab"
          >Alamat</a
        >
      </li>
    </ul>

    <!-- Modal -->
    <div
      class="modal fade"
      id="alamatModal"
      tabindex="-1"
      aria-labelledby="modalAlamatLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalAlamatLabel"></h1>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form id="formAlamat">
              <div class="mb-3">
                <label for="detailAlamat" class="form-label"
                  >Detail Alamat</label
                >
                <textarea
                  class="form-control"
                  id="detailAlamat"
                  name="Detail_alamat"
                  rows="3"
                  placeholder="Masukkan detail alamat lengkap"
                ></textarea>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea
                  class="form-control"
                  id="description"
                  rows="3"
                  name="Description"
                  placeholder="Masukkan deskripsi tambahan"
                ></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Batal
            </button>
            <button type="submit" class="btn btn-primary" id="submitAlamat">
              Simpan Alamat
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab content -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane fade show active" id="tab1">
        <h3>List Detail Alamat</h3>

        <div class="mt-4">
          <table id="tabelAlamat" class="display">
            <thead>
              <tr>
                <th>id</th>
                <th>Detail Alamat</th>
                <th>Description</th>
                <th>Action</th>
                <th>Alamat Utama</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $()
</script>