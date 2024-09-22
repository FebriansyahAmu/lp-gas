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


<div class="app-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-11 mx-auto">
        <div class="card mb-4">
          <div class="card-header border-0">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">List Data Customer</h3>
            </div>
          </div>
          <div class="card-body">
          <div class="col-md-12 mx-auto">
              <table id="tabelDataCustomer" class="display">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nama Lengkap</th>
                      <th>Email</th>
                      <th>No Hp</th>
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
    $(document).ready(function(){
      dataCustomer();
    })

    function dataCustomer(){
        $('#tabelDataCustomer').DataTable({
          "responsive": true,
          "scrollX": true,
          "ajax":{
            "url": "/data/customers",
            "dataSrc": "data",
          },
          "columns":[
            { "data": "user_id"},
            { "data": "Nama_lengkap"},
            { "data": "Email"},
            { "data": "No_Hp"},
          ]
        })
    }


</script>
