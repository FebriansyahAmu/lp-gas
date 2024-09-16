<style>
        .product-image {
            max-width: 300px;
            height: 300px;
            border-radius: 8px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        .quantity-controls button {
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 40px;
            height: 40px;
        }
        .quantity-controls input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            height: 40px;
            margin: 0 5px;
        }
        .checkout-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .checkout-btn:hover {
            background-color: #0056b3;
        }
        .delivery-info p {
            margin: 0;
        }
        .ttl-hrga p{
            margin: 0;
        }

        @media (max-width: 768px) {
        .col-lg-6, .col-md-12 {
            padding: 10px;
        }
        
    }
    </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key=""></script>

    <section class=" d-flex justify-content-center align-items-center" >


        <div class="container" >
            <div class="row" style="padding:15px; margin-bottom: 150px; margin-top: 150px;">
                <!-- Kolom Kiri: Gambar Produk -->
                <div class="col-md-6 mb-4 p-5 d-flex justify-content-center">
                    <img src="https://via.placeholder.com/500" alt="Product Image" class="product-image">
                </div>

                <div class="col-md-6">
                <form id="checkout-form" class="needs-validation" novalidate>
                    <div class="col-md-10">
                        <h2 class="mb-3" id="title-gas"></h2>
                        
                        <div class="mb-3">
                        <h5>Stok Tersedia: <span id="stok"></span></h5>
                        </div>
                        <div class="mb-4">
                            <h5>Quantity</h5>
                            <div class="quantity-controls d-flex">
                                <button type="button" id="decrement" class="btn btn-outline-secondary">-</button>
                                <input id="quantity" name="quantity" type="text" class="form-control mx-2 text-center" value="1" readonly required>
                                <button type="button" id="increment" class="btn btn-outline-secondary">+</button>
                                <div class="invalid-feedback">Jumlah harus minimal 1.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>Metode Pengambilan</h5>
                            <select id="delivery-option" name="delivery_method" class="form-select" required>
                                <option value="" disabled selected>Pilih metode pengambilan</option>
                                <option value="regular">Ambil di tempat</option>
                                <option value="delivery">Diantar langsung</option>
                            </select>
                            <div class="invalid-feedback">Silakan pilih metode pengambilan.</div>
                        </div>
                        
                        <div class="mb-4" id="address-option" style="display: none;">
                            <h5>Pilih Alamat</h5>
                            <select id="addr-select" name="alamat" class="form-select" required>
                                <option value="" disabled selected>Pilih Alamat</option>
                            </select>
                            <div class="invalid-feedback">Silakan pilih metode pengambilan.</div>
                        </div>

                        <!-- <div class="delivery-info mb-4">
                            <p class="fst-italic">Diantar langsung, kami akan mengantar di rumah anda dengan biaya per gas Rp.2000</p>
                        </div> -->

                        <div class="mb-4 ttl-hrga">
                            <h5>Harga</h5>
                            <p>Harga /tabung: Rp <span id="harga-gas"></span></p>
                            <p id="delive" style="display: none;">Biaya Delivery: Rp <span id="delivery-fee"></span></p>
                            
                            <div class="mt-2">
                            <p class="fw-bold fs-3" id="total-price">Rp 0</p>
                            </div>
                        </div>
                        
                        <button type="submit" id="pay-button" class="btn btn-primary">Checkout</button>
                    </div>
                </form>

                <script>
                    // Bootstrap's validation
                    (function () {
                        'use strict'
                        var forms = document.querySelectorAll('.needs-validation')

                        Array.prototype.slice.call(forms).forEach(function (form) {
                            form.addEventListener('submit', function (event) {
                                if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                }

                                form.classList.add('was-validated')
                            }, false)
                        })
                    })();
                </script>

            </div>
        </div>
    </section>

<script>
    $(document).ready(function(){
        handleProductData();
        checkAuth();
    });
</script>

<script>
    function handleProductData(){
        var id = getProductId();
        if(id){
            getdatabyid(id);
        } else {
            console.error("ID produk tidak ditemukan");
        }
    }

    function getProductId(){
        return window.location.pathname.match(/\/product\/(\d+)/)?.[1];
    }
</script>

<script>
    let stok = 0;
    function getdatabyid(id){
        $.ajax({
            url: '/api/product/' + id,
            type: 'GET',
            success: function(response){
                if(response.status === "success"){
                    // Mengisi data produk dari response
                    $("#title-gas").text(response.data.Jenis_gas);
                    $("#stok").text(response.data.Stok);
                    $("#harga-gas").text(response.data.Harga_gas.toLocaleString());

                    stok = parseInt(response.data.Stok);
                    initializeAndSetupEvents();
                    if(response.data.Stok === 0){
                        Swal.fire({
                        icon: 'error',
                        title: 'Produk Tidak Tersedia',
                        text: 'Maaf, produk ini sedang tidak tersedia.',
                        confirmButtonText: 'OK'
                    });

                    // Matikan tombol checkout
                    document.getElementById('pay-button').disabled = true;
                    document.getElementById('delivery-option').disabled = true;
                    }
                }
            }
        });
    }
</script>

<script>
    function initializeAndSetupEvents() {
        const initializeVariable = () => {
            return {
                decrementButton: document.getElementById("decrement"),
                incrementButton: document.getElementById("increment"),
                quantityElement: document.getElementById("quantity"),
                totalPriceElement: document.getElementById("total-price"),
                deliveryOptionSelect: document.getElementById("delivery-option"),
                deliveryFeeElement: document.getElementById("delivery-fee"),
                delivElement: document.getElementById("delive"),
                quantity: parseInt(document.getElementById('quantity').value),
                pricePerUnit: parseFloat(document.getElementById('harga-gas').textContent.replace(/,/g, '')) || 0, // Ambil harga dari elemen atau gunakan 0 jika kosong
                deliveryFeePerUnit: 2000,
            };
        };

        let vars = initializeVariable();

        const updateTotalPrice = () => {
            const deliveryOption = vars.deliveryOptionSelect.value;
            const isDelivery = deliveryOption === 'delivery';

            // Hitung harga total tanpa biaya pengiriman
            const totalPrice = vars.quantity * vars.pricePerUnit;
            
            // Hitung biaya pengiriman
            const deliveryFee = isDelivery ? vars.quantity * vars.deliveryFeePerUnit : 0;
            
            // Hitung total harga dengan biaya pengiriman
            const totalPriceWithDelivery = totalPrice + deliveryFee;
            
            // Tampilkan total harga dan biaya pengiriman
            vars.totalPriceElement.textContent = `Total: Rp ${totalPriceWithDelivery.toLocaleString()}`;
            vars.deliveryFeeElement.textContent = `${deliveryFee.toLocaleString()}`;
            vars.delivElement.style.display = isDelivery ? 'block' : 'none';
        };

        // Tambahkan event listeners
        vars.decrementButton.addEventListener('click', () => {
            if (vars.quantity > 1) {
                vars.quantity--;
                vars.quantityElement.value = vars.quantity;
                updateTotalPrice();
            }
        });

        vars.incrementButton.addEventListener('click', () => {
            // Tambahkan pengecekan apakah quantity melebihi stok
            if (vars.quantity < stok) {
                vars.quantity++;
                vars.quantityElement.value = vars.quantity;
                updateTotalPrice();
            } else {
                alert("Jumlah tidak boleh melebihi stok yang tersedia.");
            }
        });

        vars.deliveryOptionSelect.addEventListener('change', () => {
            updateTotalPrice();
        });

        // Panggil updateTotalPrice pertama kali setelah semua event listener ditambahkan
        updateTotalPrice();
    }
</script>


<script>
  function checkoutProducts() {
    $("#checkout-form").on('submit', function(event){
        event.preventDefault();  // Mencegah form submit normal

        //Validasi form
        const deliveryMethod = document.getElementById('delivery-option').value;
        const alamat = document.getElementById('addr-select').value;
        if (deliveryMethod === "") {
            event.preventDefault();  
            return; 
        }
        if(deliveryMethod === "delivery" && alamat === ""){
            event.preventDefault();  
            return;
        }


        const idGas = getProductId();
        const deliveryfee = parseInt(document.getElementById('delivery-fee').textContent.replace(/[^\d]/g, ''));
        const totalPrice = parseInt(document.getElementById('total-price').textContent.replace(/[^\d]/g, ''));

        console.log("Delivery Fee:", deliveryfee);
        console.log("Total Price:", totalPrice);

        const formData = new FormData(this);

        // Menambahkan data tambahan ke formData
        formData.append('Id_gas', idGas);
        formData.append('delivery_fee', deliveryfee);
        formData.append('total_harga', totalPrice);

        // Mengirim form menggunakan AJAX
        Swal.fire({
            title: 'Konfirmasi Pesanan',
            text: "Apakah Anda yakin ingin melakukan checkout?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Lanjutkan'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: '/checkout',  // Endpoint API untuk memproses pesanan
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {   
                        const token = response.token;
                        if (token) {
                            // Trigger snap popup dengan token yang diterima
                            window.snap.pay(token, {
                                onSuccess: function(result) {
                                    console.log('Payment success:', result);
                                    // Tangani hasil sukses pembayaran di sini
                                },
                                onPending: function(result) {
                                    console.log('Waiting for payment:', result);
                                    // Tangani jika pembayaran tertunda di sini
                                },
                                onError: function(result) {
                                    console.log('Payment error:', result);
                                    // Tangani jika ada error di sini
                                }
                            });
                        } else {
                            console.error('Failed to receive transaction token');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }
        })
    });
}


</script>

<script>
    function checkAuth(){
        $.ajax({
            url: '/checkauth',
            type: 'GET',
            success: function(response){
                if(response.auth = true){
                    showAlamat();
                    checkoutProducts();
                }
            }
        })
    }

    function truncateText(text, maxLength) {
    if (text.length > maxLength) {
        return text.substring(0, maxLength) + '...';  // Potong teks dan tambahkan "..."
    }
    return text;
}

    function getAlamat(){
    $.ajax({
        url : '/Alamat',
        type: 'GET',
        success: function(response){
            console.log(response);  // Debugging untuk melihat data alamat yang diterima

            if (typeof response === "string") {
                try {
                    response = JSON.parse(response);  // Parsing jika respons berupa string JSON
                } catch (e) {
                    console.error("Gagal parsing JSON:", e);
                    return;
                }
            }
            // Pastikan response.data ada
            if (response && response.data) {
                var addressSelect = document.getElementById('addr-select');
                const alamat = response.data;

                // Buat option baru
                const maxLength = 50;
                const fullText = `${alamat.Detail_alamat} - ${alamat.Description}`;
                const truncatedText = truncateText(fullText, maxLength);


                const option = document.createElement('option');
                option.value = alamat.id_Alamat;  // Mengambil id_Alamat dari response.data
                option.textContent = truncatedText;  // Menggabungkan Detail_alamat dan Description

                // Tambahkan ke select
                addressSelect.appendChild(option);

                // Menampilkan elemen div jika belum terlihat
                document.getElementById('address-option').style.display = 'block';
            } else {
                console.error("Response tidak sesuai dengan format yang diharapkan.");
            }
        },
        error: function() {
            console.error("Gagal mendapatkan alamat");
        }
    });
}



    function showAlamat(){
        $("#delivery-option").on('change', function(){
            const selectedOption = $(this).val();

            if(selectedOption === 'delivery'){
                $('#address-option').show();
                getAlamat();
            }else{
                $('#address-option').hide();
            }
        })
    }

</script>