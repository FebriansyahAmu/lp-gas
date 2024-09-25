<!-- Section 1: Hero Section -->
<section
  class="home w-100 vh-100 d-flex justify-content-center align-items-center bg-cover-with-overlay"
  style="background: radial-gradient(circle at right, #b8ced6, #3f3b3e)"
>
  <div class="container">
    <div class="row d-flex justify-content-center text-center">
      <div class="col-md-7 col-12">
        <h1 class="display-4 fw-bold text-light" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">Pangkalan Gas Abdullah</h1>
        <p class="lead" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
        Di sini, Anda akan menemukan solusi praktis untuk semua kebutuhan gas Anda.
        </p>
        <a href="/register" class="btn btn-md rounded-1 btn-primary mt-4" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1200">Daftar Sekarang</a>
      </div>
    </div>
  </div>
</section>

<!-- Section 2: List Gas -->
<section
  class="d-flex justify-content-center align-items-center py-5"
  style="background-color: #f9f9f9; min-height: 120vh"
>
  <div class="container">
    <div class="d-flex justify-content-center mb-4">
      <h1 class="text-black" data-aos="zoom-in"  data-aos-duration="800">In Sale</h1>
    </div>
    <p class="mb-5 text-center" data-aos="zoom-in"  data-aos-duration="800">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus ab
      velit est! Accusantium vitae ex provident, a.
    </p>
    <div class="row" id="product-container" >
   
    </div>
  </div>
</section>

<!-- Section 3: About Us -->
<section
  class="w-100 bg-dark-subtle py-5 d-flex justify-content-center align-items-center"
  style="min-height: 100vh"
>
  <div class="container">
    <div class="row align-items-center">
      <!-- Kolom kiri: About Us -->
      <div class="col-md-6 text-black mb-4 mb-md-0">
        <h2 class="mb-4" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">About Us</h2>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          Kami adalah perusahaan yang bergerak di bidang distribusi gas,
          menyediakan berbagai jenis gas untuk kebutuhan rumah tangga dan
          industri. Kami berkomitmen untuk memberikan layanan terbaik dengan
          produk berkualitas tinggi.
        </p>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus,
          itaque. Amet asperiores odio illum aliquam incidunt ex unde aperiam
          dicta, autem est explicabo ipsa exercitationem nihil soluta odit
          consequuntur accusamus.
        </p>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum
          molestiae nesciunt accusamus non quis ad officia nisi! Nam, sunt ipsum
          at, deleniti pariatur perspiciatis beatae ratione velit nisi officiis
          repellat.
        </p>
      </div>
      <!-- Kolom kanan: Gambar -->
      <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
        <img src="img/lpg-gas.jpg" alt="About Us Image" class="img-fluid" />
      </div>
    </div>
  </div>
</section>

<section class="w-100 py-5">
  <div class="container">
    <div class="row align-items-center">
      <!-- Kolom kiri: About Us -->
      <div class="col-md-8 text-black mb-4 mb-md-0" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d296.52111372334923!2d124.30035815544517!3d0.7275439208993522!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x327e3d119fd60439%3A0x567152c26e8947ae!2sPangkalan%20Gas%20Elpiji%20Abdul%20Rahman!5e0!3m2!1sid!2sid!4v1725873169895!5m2!1sid!2sid"
          height="450"
          style="border: 0; width: 100%"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
      </div>
      <!-- Kolom kanan: Gambar -->
      <div class="col-md-4">
        <h3 class="mb-3" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">Contact Us</h3>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          <strong>Pangkalan Gas Elpiji AbdulRahman</strong><br />
          Jalan Veteran, Kelurahan Motoboi Kecil<br />
          Kecamatan Kotamobagu Selatan<br />
        </p>
        <div class="" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          <p>
            <strong>Email:</strong>
            <a href="mailto:contact@example.com">contact@example.com</a>
          </p>
          <p><strong>Phone:</strong> +62 812 3456 7890</p>
        </div>
      </div>
    </div>
  </div>
</section>

<
<script>
  function fetchProducts(){
    $.ajax({
        url: '/api/products',
        method: 'GET',
        success: function(response){
            if(response.status === 'success'){
                displayProducts(response.data);
            }
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        }
    })
  }

  function displayProducts(products) {
    products.forEach((product, index) => {
      let productCard = `
        <div class="col-md-4 col-sm-6 col-12 mb-4" data-aos="fade-up" data-aos-delay="${index * 200}" data-aos-duration="800">
          <div class="card shadow-lg hover-shadow zoom-effect">
            <img class="card-img-top img-fluid" src="img/gas.jpeg" alt="${product.Jenis_gas}" />
            <div class="card-body">
              <div class="text-center">
                <span class="badge text-bg-success text-center fs-6">Rp.${product.Harga_gas}</span>
              </div>
              <h5 class="card-title">${product.Jenis_gas}</h5>
              <p class="card-text">Stok: ${product.Stok}</p>
              <div class="d-flex justify-content-center mb-4">
                <a href="/product/${product.id_gas}" class="btn btn-primary p-2">Pesan Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      `;
      $('#product-container').append(productCard);
    });
}

  $(document).ready(function() {
    fetchProducts();
  });
</script>



<style>
.card-img-top {
        width: 200%;
        height: 200px; /* Adjust the height as needed */
        object-fit: cover;
         /* Ensure the image covers the area while maintaining aspect ratio */
    }
    
    .zoom-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .zoom-effect:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
</style>




<!-- <style>
  .bg-cover-with-overlay {
      position: relative;
      background-image: url('/img/lpg-gas.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
  }

  .bg-cover-with-overlay::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); 
      z-index: 1;
  }

  .bg-cover-with-overlay > * {
      position: relative;
      z-index: 2;
      color: white; 
  }
</style> -->