<section
  class="d-flex justify-content-center align-items-center py-5"
  style="min-height: 100vh"
>
  <div
    class="container p-4 rounded shadow bg-light mt-5 col-lg-7 col-md-10 col-sm-12"
    style="min-height: 60vh;"
  >
    <ul class="nav nav-tabs mb-4">
      <li class="nav-item">
        <a
          class="nav-link active"
          aria-current="page"
          href="#tab1"
          data-bs-toggle="tab"
          >Pengaturan Akun</a
        >
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="tab1">
        <!-- Form Ubah Informasi Akun -->
        <form id="formProfile" enctype="multipart/form-data">
        <div class="mb-3 d-flex justify-content-center">
            <img
              id="profilePicturePreview"
              src="/img/Portrait_Placeholder.png" 
              alt="Preview Foto Profil"
              class="img-thumbnail"
              style="max-width: 200px; max-height: 200px;"
            />
          </div>
          <div class="mb-3">
            <label for="profilePicture" class="form-label">Foto Profil</label>
            <input
              type="file"
              class="form-control"
              id="profilePicture"
              name="profilePicture"
              accept="image/*"
              onchange="previewImage(event)"
            />
          </div>
          <!-- Tempat untuk Preview Gambar -->

          <div class="mb-3">
            <label for="fullName" class="form-label">Nama Lengkap</label>
            <input
              type="text"
              class="form-control"
              id="fullName"
              name="fullName"
              placeholder="Masukkan nama lengkap"
              required
            />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Masukkan email"
              
            />
          </div>
          <div class="mb-3">
            <label for="no_hp" class="form-label">Nomor Telepon</label>
            <input
              type="tel"
              class="form-control"
              id="no_hp"
              name="no_hp"
              placeholder="Masukkan nomor telepon"
            />
          </div>
          <div class="d-grid gap-2">
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              Ganti Password
            </button>
            <button type="submit" class="btn btn-success">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Modal untuk Ganti Password -->
<div
  class="modal fade"
  id="changePasswordModal"
  tabindex="-1"
  aria-labelledby="changePasswordModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Ganti Password</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form id="ubahPassForm">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Password Lama</label>
            <input
              type="password"
              class="form-control"
              id="currentPassword"
              name="currentPassword"
              placeholder="Masukkan password lama"
              required
            />
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Password Baru</label>
            <input
              type="password"
              class="form-control"
              id="newPassword"
              name="newPassword"
              placeholder="Masukkan password baru"
              required
            />
          </div>
          <div class="mb-3">
            <label for="confirmNewPassword" class="form-label">Konfirmasi Password Baru</label>
            <input
              type="password"
              class="form-control"
              id="confirmNewPassword"
              placeholder="Konfirmasi password baru"
              required
            />
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
              Simpan Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById("profilePicturePreview");

    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>


<script>
    $(document).ready(function() {
        getuserbyUID();
        ubahDataProfile();
        ubahPassword();
    });

    function getuserbyUID(){
      const preview = document.getElementById("profilePicturePreview");
        $.ajax({
            url: '/account/user-data',
            method: 'GET',
            success: function(response){
                if(response.status === 'success'){
                    $('#fullName').val(response.data.Nama_lengkap);
                    $('#email').val(response.data.Email);
                    $('#no_hp').val(response.data.No_Hp);
                    if(response.data.foto_filepath === null){
                      preview.src = "/img/Portrait_Placeholder.png";
                    }else{
                      preview.src = "../" + response.data.foto_filepath;
                    }
                    
                }
            },
            error: function(xhr, status, error){
                Swal.fire('Error', xhr.responseJSON.message, 'error');
            }
        });
    }

    function ubahDataProfile(){
      $('#formProfile').submit(function(event){
        event.preventDefault();

        const formData = new FormData(this);
        Swal.fire({
          title: 'Apakah anda yakin ingin mengubah data profile?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, Ubdah Data",
        }).then((result)=>{
          if(result.isConfirmed){
            $("#loading-spinner").removeClass("d-none");
            $.ajax({
              url: '/account/update-profile',
              method: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response){
                $("#loading-spinner").addClass("d-none");
                if(response.status === 'success'){
                  Swal.fire('Sukses', response.message, 'success');
                }
              },
              error: function(xhr, status, error){
                Swal.fire('Error', xhr.responseJSON.message, 'error');
              },
              complete: function () {
                $("#loading-spinner").addClass("d-none");
              },
            })
          }
        })
      })
    }

    function ubahPassword(){
      $("#ubahPassForm").submit(function(event){
        event.preventDefault();

        const newPassword = $('#newPassword').val();
        const konfirmasiPass = $('#confirmNewPassword').val();

        if(konfirmasiPass !== newPassword){
          Swal.fire('Error', 'Password tidak sesuai', 'error');
        }

        const formData = new FormData(this);
        Swal.fire({
          title: 'Apakah anda yakin ingin mengubah password?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, Ubah Password",
        }).then((result)=>{
          if(result.isConfirmed){
            $.ajax({
              url: "/account/ubah-password",
              method: "POST",
              data: formData,
              contentType: false,
              processData: false,
              success: function(response){
                if(response.status === 'success'){
                  Swal.fire('Sukses', response.message, 'success').then(()=>{
                    window.location.reload();
                  });
                }
              },
              error: function(xhr, status, error){
                Swal.fire('Error', xhr.responseJSON.message, 'error');
              }
            })
          }
        })
      })
    }
</script>