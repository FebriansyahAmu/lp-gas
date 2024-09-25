<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <!-- <h3 class="mb-0">Dashboard v3</h3> -->
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div
  class="modal fade"
  id="dataGasModal"
  data-bs-backdrop="static"
  data-bs-keyboard="false"
  tabindex="-1"
  aria-labelledby="staticBackdropLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="dataGasModalLabel"></h1>
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
          <form id="formDataGas" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
            <div class="col-md-6 mx-auto">
              <div class="mb-2">
                <label for="JenisGas" class="form-label">Jenis Gas</label>
                <input type="text" class="form-control" id="JenisGas" name="jenisGas" required/>
                <div class="invalid-feedback">Jenis gas tidak boleh kosong.</div>
              </div>

              <div class="mb-2">
                <label for="HargaGas" class="form-label">Harga Gas</label>
                <input type="number" name="hargaGas" class="form-control" id="HargaGas" required />
                <div class="invalid-feedback">Harga tidak boleh kosong</div>
              </div>

              <div class="mb-2">
                <label for="Stok" class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" id="Stok" required />
                <div class="invalid-feedback">Stok tidak boleh kosong</div>
              </div>

              <!-- Input untuk gambar -->
              <div class="mb-2">
                <label for="GambarGas" class="form-label">Upload Gambar Gas</label>
                
                <input type="file" name="gambarGas" class="form-control" id="GambarGas" accept="image/*" />
                <!-- <div class="invalid-feedback">Gambar tidak boleh kosong</div> -->
              </div>
              <!-- <input class="mt-3" type="text" name="currentGambar" id="currentGambar" value=""/> -->
                <img id="gambarGasPreview" src="" alt="Preview Gambar Gas" class="img-thumbnail mb-2" style="max-width: 150px; display: none;" />
            </div>
            <div class="mt-2 d-flex justify-content-center">
              <button type="submit" id="submitDataGas" class="btn btn-primary rounded-1">
                Simpan Data
              </button>
            </div>
          </form>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary rounded-1"
          data-bs-dismiss="modal"
        >
          Batal
        </button>

      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-11 mx-auto">
        <div class="card mb-4">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">List Gas</h3>
              <a href="" class="btn rounded-1 btn-primary" id="btnTambahGas" data-bs-toggle="modal" data-bs-target="#dataGasModal">
                <i class="bi bi-plus"></i> Tambah Gas
             </a>
            </div>
          </div>
          <div class="card-body">
          <div class="col-md-12 mx-auto">
              <table id="tabelDataGas" class="display">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Jenis Gas</th>
                      <th>Stok</th>
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

<script>
  (() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
