<!-- Section 1: Hero Section -->
<!-- style="background: radial-gradient(circle at right, #b8ced6, #3f3b3e)" -->
 <link rel="stylesheet" href="/css/homeAdditionalcss.css" />
 <style>
.home {
  position: relative;
  background-size: cover;
  background-attachment: fixed; /* Efek parallax */
  background-position: center;
  overflow: hidden;
}

/* Overlay pada section menggunakan pseudo-element */
.home::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7); /* Overlay dengan opasitas */
  z-index: 1; /* Overlay berada di belakang konten */
}

/* Konten harus berada di atas overlay */
.container {
  position: relative;
  z-index: 2; /* Konten di atas overlay */
  
}


  .green-purple-shadow {
  box-shadow: 0 4px 8px rgba(0, 255, 0, 0.5), 0 6px 20px rgba(128, 0, 128, 0.5);
}

.pink-shadow {
  box-shadow: 0 4px 8px rgba(255, 192, 203, 0.5), 0 6px 20px rgba(255, 105, 180, 0.5);
}

    
 </style>
 <script>
  window.addEventListener('scroll', function() {
    // Dapatkan posisi scroll
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    // Dapatkan elemen section dengan class 'home'
    let homeSection = document.querySelector('.home');
    
    // Ubah posisi background berdasarkan scroll (efek parallax)
    homeSection.style.backgroundPositionY = -(scrollTop * 0.3) + 'px';
  });
</script>

<section
  class="home w-100 vh-100 d-flex justify-content-center align-items-center"
  style="background-image: url('/img/bghome.png');"
>
  <div class="container">
    <div class="row d-flex justify-content-center text-center">
      <div class="col-md-7 col-12">
        <h1 class="display-4 fw-bold text-light" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">Pangkalan Gas Abdullah</h1>
        <p class="lead text-light" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
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
  data-bs-spy="scroll" data-bs-target="#navbar-scrolspy" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true"
>
  <div class="container" id="product">
    <div class="d-flex justify-content-center mb-4">
      <h1 class="text-black" data-aos="zoom-in"  data-aos-duration="800" >Produk Kami</h1>
    </div>
    <p class="mb-5 text-center" data-aos="zoom-in"  data-aos-duration="800" >
      Harap diperhatikan, stok produk dapat berubah sewaktu-waktu sesuai ketersediaan.
    </p>
    <div class="row" id="product-container" >
   
    </div>
  </div>

</section>


<!-- Section 3: About Us -->
<section
  class="w-100 bg-dark-subtle py-5 d-flex justify-content-center align-items-center"
  style="min-height: 100vh"
  data-bs-spy="scroll" data-bs-target="#navbar-scrolspy" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true"
  id="about"
  >
  <div class="container" >
    <div class="row align-items-center">
      <!-- Kolom kiri: About Us -->
      <div class="col-md-6 text-black mb-4 mb-md-0">
        <h2 class="mb-4" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800" >About Us</h2>
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

<section class="w-100 py-5" data-bs-spy="scroll" data-bs-target="#navbar-scrolspy"  data-bs-smooth-scroll="true" id="contact" >
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
        <h3 class="mb-3" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800" >Contact Us</h3>
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
<section class="w-100 py-5 bg-dark-subtle d-flex align-items-center" data-bs-smooth-scroll="true" id="testimonials" style="min-height: 60vh">
  <div class="container">
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <!-- Testimonial 1 -->
        
      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>
<script>
  $(document).ready(function(){
    fetchProducts();
    fetchUlasan();
  })

  function fetchUlasan(){
    $.ajax({
      url: '/data/ulasan',
      method: 'GET',
      success: function(response){
        tampilkanUlasan(response.data);
      }
    })
  }


function generateStars(rating) {
  let stars = '';
  for (let i = 1; i <= 5; i++) {
    if (i <= rating) {
      stars += '<i class="fas fa-star text-warning" style="margin-right: 10px;"></i>'; 
    } else {
      stars += '<i class="far fa-star text-warning" style="margin-right: 10px;"></i>'; 
    }
  }
  return stars;
}

function tampilkanUlasan(data) {
  const carouselInner = document.querySelector('.carousel-inner');
  carouselInner.innerHTML = '';

  data.forEach((ulasan, index) => {
    const isActive = index === 0 ? 'active' : '';

    const ulasanItem = `
      <div class="carousel-item ${isActive} text-center">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="testimonial">
              <p class="mb-4">"${ulasan.review_description}"</p>
              <h2 class="font-weight-bold">${ulasan.Nama_lengkap}</h2>
              <div class="stars mb-3">
                ${generateStars(ulasan.rating)}
              </div>
            </div>
          </div>
        </div>
      </div>
    `;

    carouselInner.innerHTML += ulasanItem;
  });
}
</script>