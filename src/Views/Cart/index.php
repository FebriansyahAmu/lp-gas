<section class="d-flex justify-content-center align-items-start py-5" style="min-height: 100vh">
  <div class="container p-4 rounded shadow bg-light mt-5" style="min-height: 60vh; width: 100%; max-width: 800px;">
    
    <!-- Pilih Semua -->
    <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <input type="checkbox" id="selectAll"> 
        <label for="selectAll" class="fw-bold">Pilih Semua</label> 
    </div>

      <div class="mb-4">
            <select id="delivery-option" name="delivery_method" class="form-select" required>
              <option value="" disabled selected>
                Pilih metode pengambilan
              </option>
              <option value="regular">Ambil di tempat</option>
              <option value="delivery">Diantar langsung</option>
            </select>
            <div class="invalid-feedback">Silakan pilih metode pengambilan.</div>
          </div>
    </div>

    <!-- Card Keranjang 1 -->
    <div id="cart-container"></div>
    
    <!-- Ringkasan Belanja -->
    <div class="card shadow-sm mt-4" >
  <div class="card-body">
    <h5 class="card-title">Ringkasan belanja</h5>
    <div class="" id="d-alamat" style="display:none;">
        <h6>Dikirim Ke</h6>
        <i class="bi bi-geo-alt"></i> <span id="u-alamat">Jln Darussalam Kelurahan Motoboi Kecil...</span><a href="/account/alamat" class="text-decoration-none">Ganti Alamat?</a>
    </div>
    <div class="d-flex justify-content-between mt-4 ">
      <span>Biaya Delivery</span>
      <span id="delivery-cost">Rp -</span>
    </div>
    <div class="d-flex justify-content-between">
      <span>Total</span>
      <span id="total-cost">Rp -</span>
    </div>
    <hr>
    <button class="btn btn-success w-100">Beli</button>
  </div>
</div>

  </div>
</section>


<!-- Optional Bootstrap 5 and FontAwesome CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


<script>
  $(document).ready(function() {
    getAllCartUID();
    handleQtyButtonCart();
    handleDeliveryOption();
    $('#delivery-option').change(handleDeliveryOption);
    $('#selectAll').change(handleSelectAll);
    fetchAlamatCart();
});

// Render setiap item di cart
function renderCartItem(cart) {
    return `
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex flex-column flex-md-row align-items-center">
                <div class="me-3 mb-3 mb-md-0 d-flex align-items-center">
                    <input type="checkbox" class="cart-checkbox" data-id="${cart.cart_id}">
                </div>
                <div class="product-image me-3 mb-3 mb-md-0">
                    <img src="${cart.image}" class="img-fluid rounded" style="width: 80px;" alt="Product Image">
                </div>
                <div class="flex-grow-1 text-center text-md-start">
                    <h5 class="card-title mb-1">${cart.Jenis_gas}</h5>
                    <p class="card-text text-muted small">Stok : <span class="stok-title">${cart.Stok}</span></p>
                    <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                        <div class="mb-2 mb-md-0">
                            <span class="text-success fw-bold">Rp${cart.harga_unit}</span><br>
                        </div>
                        <div class="d-flex align-items-center mb-2 mb-md-0">
                            <button class="btn btn-outline-secondary btn-sm btn-decrease" data-id="${cart.cart_id}" data-stock="${cart.Stok}">-</button>
                            <input type="text" class="form-control text-center mx-2 cart-qty" id="cart-qty-${cart.cart_id}" data-id="${cart.cart_id}" value="${cart.Qty}" style="width: 50px;" readonly>
                            <button class="btn btn-outline-secondary btn-sm btn-increase" data-id="${cart.cart_id}" data-stock="${cart.Stok}">+</button>
                        </div>
                        <button class="btn btn-outline-danger btn-sm btn-delete" data-id="${cart.cart_id}"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Menangani perubahan kuantitas item di cart
function handleQtyButtonCart() {
    $(document).on('click', '.btn-increase', function() {
        let stock = $(this).data('stock');
        let qtyInput = $(this).siblings('.cart-qty');
        let currentQty = parseInt(qtyInput.val());

        if (currentQty < stock) {
            currentQty++;
            qtyInput.val(currentQty);
            $(this).closest('.card-body').find('.cart-checkbox').prop('checked', true);
            calculateTotalCost();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Jumlah melebihi stok!',
                text: 'Jumlah barang yang diminta melebihi stok yang tersedia.',
            });
        }
    });

    $(document).on('click', '.btn-decrease', function() {
        let qtyInput = $(this).siblings('.cart-qty');
        let currentQty = parseInt(qtyInput.val());

        if (currentQty > 1) {
            currentQty--;
            qtyInput.val(currentQty);
            $(this).closest('.card-body').find('.cart-checkbox').prop('checked', true);
            calculateTotalCost();
        }
    });

    $(document).on('change', '.cart-checkbox', function() {
        calculateTotalCost();
    });
}

// Mendapatkan data cart dari backend
function getAllCartUID() {
    $.ajax({
        url: '/api/carts',
        method: 'GET',
        success: function(response) {
            response.data.forEach(cart => {
                $('#cart-container').append(renderCartItem(cart));
            });
        }
    });
}

// Menangani opsi pengiriman
function handleDeliveryOption() {
    const selectedOption = $('#delivery-option').val();
    
    if (selectedOption === 'delivery') {
        $('#d-alamat').show();
        calculateTotalCost();
    } else {
        $('#d-alamat').hide();
        $('#delivery-cost').text('Rp -');
        calculateTotalCost(); // Mengatur ulang total biaya saat opsi berubah
    }
}

// Menangani checkbox "Pilih Semua"
function handleSelectAll() {
    const isChecked = $('#selectAll').is(':checked');
    $('.cart-checkbox').prop('checked', isChecked);
    calculateTotalCost();
}

// Mendapatkan alamat cart
function fetchAlamatCart() {
    $.ajax({
        url: '/Alamat',
        method: 'GET',
        success: function(response) {
            const alamat = response.data.alamat;
            $('#u-alamat').text(alamat.substring(0, 10) + '...');
        }
    });
}

// Menghitung total biaya
function calculateTotalCost() {
    let totalProductCost = 0;
    let deliveryCost = 0;
    const selectedOption = $('#delivery-option').val();

    // Hitung total biaya produk
    $('#cart-container input[type="checkbox"]:checked').each(function() {
        const cartId = $(this).data('id');
        const qty = parseInt($(`#cart-qty-${cartId}`).val());
        const price = parseFloat($(`#cart-qty-${cartId}`).closest('.card-body').find('.text-success').text().replace('Rp', '').replace(',', ''));
        totalProductCost += qty * price;
    });

    // Hitung biaya pengiriman jika opsi pengiriman adalah 'delivery'
    if (selectedOption === 'delivery') {
        $('#cart-container input[type="checkbox"]:checked').each(function() {
            const cartId = $(this).data('id');
            const qty = parseInt($(`#cart-qty-${cartId}`).val());
            deliveryCost += qty * 2000;
        });
    }

    $('#delivery-cost').text('Rp ' + deliveryCost.toLocaleString()); // Update biaya pengiriman
    $('#total-cost').text('Rp ' + (totalProductCost + deliveryCost).toLocaleString()); // Update total biaya
}

// Validasi form checkout
function validateCart() {
    const selectedOption = $('#delivery-option').val();
    if (!selectedOption) {
        Swal.fire('Warning', 'Pilih metode pengambilan', 'error');
        return;
    }
    calculateTotalCost();
}


$(document).on('click', '.btn-delete', function(){
    const cartId = $(this).data('id');
    deleteCartItem(cartId);
})

function deleteCartItem(cartId){
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Item ini akan dihapus dari keranjang!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        cancelButtonText: "Batal"
    }).then((result) => {
        if(result.isConfirmed){
            $.ajax({
                url: 'api/carts/' + cardId,
                method: 'DELETE',
                success: function(response){
                    $(`#cart-container .btn-delete[data-id="${cartId}"]`).closest('.card').remove();
                    calculateTotalCost();
                    Swal.fire('Dihapus', response.message, 'success');
                },
                error: function(xhr, status, error){
                    Swal.fire('Error', xhr.responseJSON.message, 'error');
                }
            });
        }
    });
}

</script>

