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

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
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


<script>
$(document).ready(function(){
  submitFormDataGas();
  tabelDataGas();
  clearFormDataGas();
  getEditGas();
  deleteDataGas();
});

  function submitFormDataGas(){
    $('#formDataGas').submit(function(event){
      event.preventDefault();

      const idGas = $('#formDataGas').data('id'); 
      const url  = idGas ? '/gas/edit' : '/gas/create';
      // const method = idGas ? 'PUT' : 'POST';

      const formData = new FormData(this);

      if(idGas){
        formData.append('idGas', idGas);
      }

      if(idGas && $('#GambarGas').get(0).files.length === 0){
        formData.delete('gambarGas');
      }

      Swal.fire({
        title: "Konfirmasi",
        text: "Anda yakin ingin menyimpan data ini?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, simpan!'
      }).then((result)=>{
          if(result.isConfirmed){
            $.ajax({
              url: url,
              method: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(response){
                if(response.status === "success"){
                  Swal.fire('Success', response.message, 'success').then(()=>{
                    $('#tabelDataGas').DataTable().ajax.reload();
                  })
                }
              },
              error: function(xhr, status, error){
                Swal.fire('Error', xhr.responseJSON.message, 'error');
                
              }
          });
          }
      })
    });
  }

  

  function tabelDataGas(){
    $('#tabelDataGas').DataTable({
      "responsive": true,
      "scrollX": true,
      "ajax": {
        "url": "/api/products",
        "dataSrc": "data",
      },
      "columns":[
        { "data" : "id_gas"},
        { "data" : "Jenis_gas"},
        { "data" : "Harga_gas"},
        { "data" : "Stok"},
        { "data" : null,
          "render": function(data, type, row){
            return `
                  <button class="btn btn-sm btn-primary btn-edit" data-id="${data.id_gas}">
                        <i class="bi bi-pencil-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id_gas}">
                        <i class="bi bi-trash"></i>
                  </button>
            `;
          }
        }
      ]
    })
  }

  function clearFormDataGas(){
    $('#btnTambahGas').click(function(){
        // Reset form input
        $('#formDataGas')[0].reset();
        $('#dataGasModalLabel').text('Tambah Gas');
        
        // Reset image preview
        $('#gambarGasPreview').attr('src', '').hide(); 
    });
}


  function getEditGas(){
    $('#tabelDataGas').on('click', '.btn-edit', function(){
      const idGas = $(this).data('id');
      $('#formDataGas').data('id', idGas);
      $('#dataGasModalLabel').text('Edit Data Gas');

      $.ajax({
        url: '/api/product/' + idGas,
        method: 'GET',
        success: function(response){
          if(response.data){
            $('#JenisGas').val(response.data.Jenis_gas);
            $('#HargaGas').val(response.data.Harga_gas);
            $('#Stok').val(response.data.Stok);
            
            if(response.data.foto_gas){
            $('#gambarGasPreview').attr('src', response.data.foto_gas);
            $('#gambarGasPreview').show();  // Tampilkan gambar
            // $('#currentGambar').val(response.data.foto_gas);
            } else {
                $('#gambarGasPreview').hide();  // Sembunyikan gambar jika tidak ada
            }

            $('#dataGasModal').modal('show');
          }else{
            alert('Data Gas Tidak Ditemukan');
          }
        },
        error: function(xhr, status, error){
          
          alert('Terjadi Kesalahan', + error);
        }
      })
    })
  }

  function deleteDataGas(){
    $('#tabelDataGas').on('click', '.btn-delete', function(){
      const idGas = $(this).data('id');

      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Anda akan menghapus data ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus data'
      }).then((result)=>{
        if(result.isConfirmed){
          $.ajax({
            url: '/gas/delete/' + idGas,
            method: 'DELETE',
            success: function(response){
              if(response.status === "success"){
                Swal.fire('Deleted!', response.message, 'success').then(() =>{
                  $('#tabelDataGas').DataTable().ajax.reload();
                })
              }
            },
            error: function(xhr, status, error){
              Swal.fire('Error!', 'Terjadi kesalahan, silahkan coba lagi nanti', 'error');
            }
          })
        }
      })
    })
  }
</script>