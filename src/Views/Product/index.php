<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100%;
            height: auto;
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
    </style>
</head>
<body>
    <section class="vh-100 d-flex justify-content-center align-items-center" style="min-height: 115vh;">
        <div class="container">
            <div class="row">
                <!-- Kolom Kiri: Gambar Produk -->
                <div class="col-md-6 mb-4">
                    <img src="https://via.placeholder.com/500" alt="Product Image" class="product-image">
                </div>

                <div class="col-md-6">
                    <h2 class="mb-3 mb-5">Gas Elpiji 8 KG</h2>
                    
                    <div class="mb-4">
                        <h4>Quantity</h4>
                        <div class="quantity-controls">
                            <button id="decrement">-</button>
                            <input id="quantity" type="text" value="1" readonly>
                            <button id="increment">+</button>
                        </div>
                    </div>
                    
                    <div class="">
                        <h4>Delivery Options</h4>
                        <select id="delivery-option" class="form-select">
                            <option value="regular">Regular</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>
                    
                    <div class="delivery-info mb-4">
                        <p class="fst-italic">*Regular, Pemesan mengambil pesanan langsung di pangkalan</p>
                        <p class="fst-italic">*Delivery, kami akan mengantar di rumah anda dengan biaya per gas Rp.2000</p>
                    </div>
                    
                    <div class="mb-4 ttl-hrga">
                        <h4>Harga</h4>
                        <p id="delivery-fee" style="display: none;">Biaya Delivery: Rp 0</p>
                        <p id="total-price">Rp 0</p>
                    </div>

                    <button class="checkout-btn">Checkout</button>
                </div>
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
</body>
</html>
