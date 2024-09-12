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
    <section class=" d-flex justify-content-center align-items-center" >
        <div class="container" >
            <div class="row" style="padding:15px; margin-bottom: 150px; margin-top: 150px;">
                <!-- Kolom Kiri: Gambar Produk -->
                <div class="col-md-6 mb-4 p-5 d-flex justify-content-center">
                    <img src="https://via.placeholder.com/500" alt="Product Image" class="product-image">
                </div>

                <div class="col-md-6">
                <form action="/checkout" method="POST" id="checkout-form" class="needs-validation" novalidate>
                    <div class="col-md-10">
                        <h2 class="mb-3 mb-5">Gas Elpiji 8 KG</h2>

                        <div class="mb-4">
                            <h4>Quantity</h4>
                            <div class="quantity-controls d-flex">
                                <button type="button" id="decrement" class="btn btn-outline-secondary">-</button>
                                <input id="quantity" name="quantity" type="text" class="form-control mx-2 text-center" value="1" readonly required>
                                <button type="button" id="increment" class="btn btn-outline-secondary">+</button>
                                <div class="invalid-feedback">Jumlah harus minimal 1.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>Metode Pengambilan</h4>
                            <select id="delivery-option" name="delivery_method" class="form-select" required>
                                <option value="" disabled selected>Pilih metode pengambilan</option>
                                <option value="regular">Ambil di tempat</option>
                                <option value="delivery">Diantar langsung</option>
                            </select>
                            <div class="invalid-feedback">Silakan pilih metode pengambilan.</div>
                        </div>

                        <div class="delivery-info mb-4">
                            <p class="fst-italic">Ambil di tempat, Pemesan mengambil pesanan langsung di pangkalan</p>
                            <p class="fst-italic">Diantar langsung, kami akan mengantar di rumah anda dengan biaya per gas Rp.2000</p>
                        </div>

                        <div class="mb-4 ttl-hrga">
                            <h4>Harga</h4>
                            <p id="delivery-fee" style="display: none;">Biaya Delivery: Rp 0</p>
                            <p id="total-price">Rp 0</p>
                        </div>

                        <button type="submit" class="btn btn-primary">Checkout</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const decrementButton = document.getElementById('decrement');
            const incrementButton = document.getElementById('increment');
            const quantityInput = document.getElementById('quantity');
            const totalPriceElement = document.getElementById('total-price');
            const deliveryOptionSelect = document.getElementById('delivery-option');
            const deliveryFeeElement = document.getElementById('delivery-fee');

            let quantity = parseInt(quantityInput.value);
            const pricePerUnit = 18000; // Contoh harga per unit, ganti sesuai kebutuhan
            const deliveryFeePerUnit = 2000; // Biaya delivery per gas unit

            const updateTotalPrice = () => {
                const deliveryOption = deliveryOptionSelect.value;
                const isDelivery = deliveryOption === 'delivery';
                
                // Hitung harga total tanpa biaya pengiriman
                const totalPrice = quantity * pricePerUnit;
                
                // Hitung biaya pengiriman
                const deliveryFee = isDelivery ? quantity * deliveryFeePerUnit : 0;
                
                // Hitung total harga dengan biaya pengiriman
                const totalPriceWithDelivery = totalPrice + deliveryFee;
                
                // Tampilkan total harga dan biaya pengiriman
                totalPriceElement.textContent = `Total: Rp ${totalPriceWithDelivery.toLocaleString()}`;
                deliveryFeeElement.textContent = `Biaya Delivery: Rp ${deliveryFee.toLocaleString()}`;
                deliveryFeeElement.style.display = isDelivery ? 'block' : 'none';
            };


            decrementButton.addEventListener('click', () => {
                if (quantity > 1) {
                    quantity--;
                    quantityInput.value = quantity;
                    updateTotalPrice();
                }
            });

            incrementButton.addEventListener('click', () => {
                quantity++;
                quantityInput.value = quantity;
                updateTotalPrice();
            });

            deliveryOptionSelect.addEventListener('change', () => {
                updateTotalPrice();
            });

            updateTotalPrice();
        });
    </script>
