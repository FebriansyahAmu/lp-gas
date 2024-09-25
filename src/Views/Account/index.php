<section class="d-flex justify-content-center align-items-center py-5" style="min-height: 100vh;">
    <div class="container p-4 rounded shadow bg-light mt-5" style="min-height: 60vh;">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-4" >
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#tab1" data-bs-toggle="tab">Riwayat Pembelian</a>
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
                                <th>Jenis Gas</th>
                                <th>Qty</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <!-- <th>Action</th> -->
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
</section>

<script>
    $(document).ready(function(){
        getHistoryUID();
    });

    function getHistoryUID(){
        $('#tabelRiwayatPembelian').DataTable({
            "responsive" : true,
            "scrollX": true,
            "ajax": {
                "url" : "/riwayat-pembelian",
                "dataSrc": "data",
            },
            "columns":[
                { "data": "id_Order"},
                { "data": "Jenis_gas"},
                { "data": "Qty"},
                { "data": "totalharga"},
                { 
                    "data": "status",
                        "render": function(data, type, row) {
                        if (data === 'pending') {
                            return '<span class="badge text-bg-warning">pending</span>';
                        } else if (data === 'paid') {
                            return '<span class="badge text-bg-success">success</span>';
                        }
                    }
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0 },  
                { "width": "5%", "targets": 1 },  
                { "width": "2%", "targets": 2 },  
                { "width": "2%", "targets": 3 },
                { "width": "2%", "targets": 4 }  
            ],
        })
    }

</script>
