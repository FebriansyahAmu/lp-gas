<section class="d-flex justify-content-center align-items-center py-5" style="min-height: 100vh;">
    <div class="container p-4 rounded shadow bg-light mt-5" style="min-height: 60vh;">

    <div class="d-flex justify-content-end">
        <a class="btn btn-primary" href="" id="btnTambahAlamat" data-bs-toggle="modal" data-bs-target="#alamatModal">
            <i class="fas fa-plus"></i> Tambah Alamat
        </a>
    </div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-4" >
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#tab1" data-bs-toggle="tab">Alamat</a>
                
            </li>
        </ul>

        <!-- Modal -->
        <div class="modal fade" id="alamatModal" tabindex="-1" aria-labelledby="modalAlamatLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAlamatLabel"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAlamat">
                            <div class="mb-3">
                                <label for="detailAlamat" class="form-label">Detail Alamat</label>
                                <textarea class="form-control" id="detailAlamat" name="Detail_alamat" rows="3" placeholder="Masukkan detail alamat lengkap"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" rows="3" name="Description" placeholder="Masukkan deskripsi tambahan"></textarea>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submitAlamat">Simpan Alamat</button>
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
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        tabelAlamats();
        clearFormAlamat();
        getEditAlamatData();
        // submitFormAlamat();
        submitFormAlamat();
        deleteAlamat();
    });

    function tabelAlamats(){
        $('#tabelAlamat').DataTable({
            "responsive" : true,
            "ajax" : {
                "url" : "/Alamat",
                
                "dataSrc": "data",
            },
            "columns":[
                { "data": "id_Alamat" },
                { "data": "Detail_alamat" },
                { "data": "Description" },
                { "data": null,
                  "render" : function(data, type, row){
                    return `
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${data.id_Alamat}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id_Alamat}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                  }
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0 },  // Mengatur lebar kolom id
                { "width": "40%", "targets": 1 },  // Mengatur lebar kolom Detail Alamat
                { "width": "30%", "targets": 2 },  // Mengatur lebar kolom Description
                { "width": "5%", "targets": 3 }   // Mengatur lebar kolom Action
            ],
             // Nonaktifkan lebar otomatis
        });
    }
</script>

<script>
    function clearFormAlamat(){
        $('#btnTambahAlamat').click(function() {
            $('#formAlamat')[0].reset();
            $('#modalAlamatLabel').text('Tambah Data Alamat');

            $('#alamatModal').modal('show');
        })
    }

    function getEditAlamatData(){
        $('#tabelAlamat').on('click', '.btn-edit', function(){
            const idAlamat = $(this).data('id');
            $('#modalAlamatLabel').text('Edit Data Alamat');

            $.ajax({
                url: '/Alamat/' + idAlamat,
                type: 'GET',
                success: function(response){
                    if(typeof response === "string"){
                        try{
                            response = JSON.parse(response);
                        }catch(e){
                            console.error("Gagal parsing JSON:",e);
                            return;
                        }
                    }


                    if(response && response.data){
                        $('#detailAlamat').val(response.data.Detail_Alamat);
                        $('#description').val(response.data.Description);

                        $('#formAlamat').data('id', idAlamat);
                        $('#modalAlamatLabel').text('Edit Data Alamat');

                        $('#alamatModal').modal('show');
                    }else{
                        alert("Data tidak ditemukan");
                    }
                },
                error: function(xhr, status, error){
                    alert('Terjadi kesalahan', + error);
                }
            });
        });
    }


    function deleteAlamat(){
        $("#tabelAlamat").on('click', '.btn-delete', function(){
            const idAlamat = $(this).data('id');

            $.ajax({
                url: '/Alamat/Delete/' + idAlamat,
                method: 'DELETE',
                success: function(response){
                    alert('Alamat berhasil dihapus');
                    $('#tabelAlamat').DataTable().ajax.reload();
                },
                error: function(xhr, status, error){
                    alert('Terjadi kesalahan', + error);
                }
            })
        })
    }

    function submitFormAlamat(){
        $('#submitAlamat').click(function(){
            $('#formAlamat').submit();
        });

        $('#formAlamat').submit(function(event){
            event.preventDefault();

            const idAlamat = $(this).data('id');

            const url = idAlamat ? `/Alamat/Edit` : '/Alamat/Create';
            const method = idAlamat ? 'PUT' : 'POST';

            const data = {
                Detail_alamat: $('#detailAlamat').val(),
                Description: $('#description').val(),
                id_Alamat: idAlamat
            };

           $.ajax({
                url: url,
                method: method,
                contentType: 'application/json',
                data: JSON.stringify(data),
                processData: false,
                success: function(response) {
                    alert('Alamat berhasil' + (idAlamat ? 'diperbarui' : 'ditambahkan'));
                    $('#alamatModal').hide('hide');
                    $('#tabelAlamat').DataTable().ajax.reload(); 
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        })
    }

</script>


