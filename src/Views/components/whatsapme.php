<!-- WhatsApp Button Component -->
<a href="https://wa.me/6282394143812" target="_blank" class="whatsapp-button">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- CSS for WhatsApp Button -->
<style>
    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        background-color: #25D366;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    
    .whatsapp-button:hover {
        background-color: #20b857;
        transform: scale(1.1);
    }
</style>