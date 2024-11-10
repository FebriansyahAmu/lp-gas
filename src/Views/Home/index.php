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
      <div class="col-md-8 col-12">
        <h1 class="display-4 fw-bold text-light" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          Pangkalan Gas Abdul Rahman
        </h1>
        <p class="lead text-light" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
          Di sini, anda akan menemukan solusi praktis untuk semua kebutuhan gas LPG anda.
        </p>
        <p class="text-light lead" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1200">
          <strong>Harga Terjangkau</strong>, <strong>Pengiriman Cepat</strong>, dan <strong>Pelayanan Terbaik</strong> untuk memenuhi kebutuhan energi keluarga Anda. Percayakan kami sebagai mitra andalan Anda dalam penyediaan LPG.
        </p>
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
        <h2 class="mb-4" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800" >Tentang Kami</h2>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          Kami adalah perusahaan yang bergerak di bidang distribusi gas,
          menyediakan berbagai jenis gas untuk kebutuhan rumah tangga dan
          industri. Kami berkomitmen untuk memberikan layanan dan pengalaman terbaik untuk anda.
        </p>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
        Kami juga memperluas jangkauan pelayanan dengan meningkatkan 
        kapasistas distribusi dan berkomitmen untuk menyediakan stok gas yang stabil bagi pelanggan.
        </p>

      </div>
      <!-- Kolom kanan: Gambar -->
      <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
        <img src="img/pangkalan-gas.jpeg" alt="About Us Image" class="img-fluid" />
      </div>
    </div>
  </div>
</section>

<section class="w-100 py-5" data-bs-spy="scroll" data-bs-target="#navbar-scrolspy" data-bs-smooth-scroll="true" id="contact">
  <div class="container">
    <div class="row align-items-center">
      <!-- Kolom kiri: Map -->
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
      <!-- Kolom kanan: Contact Details -->
      <div class="col-md-4">
        <h3 class="mb-3" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">Hubungi Kami</h3>
        <p data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          <strong>Pangkalan Gas Elpiji AbdulRahman</strong><br />
          Jalan Veteran, Kelurahan Motoboi Kecil<br />
          Kecamatan Kotamobagu Selatan<br />
        </p>
        <div class="" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          <p><strong>Email:</strong> <a href="mailto:info@pangkalangasabdulrahman.online">info@pangkalangasabdulrahman.online</a></p>
          <p><strong>Phone:</strong> +62 823 9414 3812</p>
        </div>
        <!-- Media Sosial -->
        <div class="social-media mt-4" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
          <h5>Ikuti Kami:</h5>
          <a href="https://facebook.com" target="_blank" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://instagram.com" target="_blank" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="w-100 py-5 bg-dark-subtle d-flex align-items-center" data-bs-smooth-scroll="true" id="testimonials" style="min-height: 60vh">
  <div class="container">
    <h2 class="mb-4 text-center" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">Testimonial</h2>
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="800">
      <div class="carousel-inner">
        
        <!-- Testimonial 1 -->
        <div class="carousel-item active text-center">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="testimonial">
                <img src="img/user.png" alt="Avatar User 1" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                <p class="mb-4">"Great service, very satisfied!"</p>
                <h2 class="font-weight-bold">John Doe</h2>
                <div class="stars mb-3">
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="far fa-star text-warning" style="margin-right: 15px;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="carousel-item text-center">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="testimonial">
                <img src="img/user.png" alt="Avatar User 2" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                <p class="mb-4">"Excellent quality and reliable."</p>
                <h2 class="font-weight-bold">Bagas</h2>
                <div class="stars mb-3">
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                  <i class="fas fa-star text-warning" style="margin-right: 15px;"></i>
                </div>
              </div>
            </div>
          </div>
        </div>


        <!-- Additional Testimonials Here -->
        
      </div>

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
    // fetchUlasan();
  })

//   function fetchUlasan(){
//     $.ajax({
//       url: '/data/ulasan',
//       method: 'GET',
//       success: function(response){
//         tampilkanUlasan(response.data);
//       }
//     })
//   }


// function generateStars(rating) {
//   let stars = '';
//   for (let i = 1; i <= 5; i++) {
//     if (i <= rating) {
//       stars += '<i class="fas fa-star text-warning" style="margin-right: 15px;"></i>'; 
//     } else {
//       stars += '<i class="far fa-star text-warning" style="margin-right: 15px;"></i>'; 
//     }
//   }
//   return stars;
// }

// function tampilkanUlasan(data) {
//   const carouselInner = document.querySelector('.carousel-inner');
//   carouselInner.innerHTML = '';

//   data.forEach((ulasan, index) => {
//     const isActive = index === 0 ? 'active' : '';

//     const ulasanItem = `
//       <div class="carousel-item ${isActive} text-center">
//         <div class="row justify-content-center">
//           <div class="col-md-8">
//             <div class="testimonial">
//               <img 
//                 src="${ulasan.foto_filepath || '/img/user.png'}" 
//                 alt="Avatar ${ulasan.Nama_lengkap}" 
//                 class="rounded-circle mb-3" 
//                 style="width: 80px; height: 80px; object-fit: cover;"
//               >
//               <p class="mb-4">"${ulasan.review_description}"</p>
//               <h2 class="font-weight-bold">${ulasan.Nama_lengkap}</h2>
//               <div class="stars mb-3">
//                 ${generateStars(ulasan.rating)}
//               </div>
//             </div>
//           </div>
//         </div>
//       </div>
//     `;

//     carouselInner.innerHTML += ulasanItem;
//   });
// }

</script>

<style>
  .social-media h5 {
  font-size: 1.2rem;
  font-weight: bold;
  color: #333;
}

.social-icon {
  font-size: 2.5rem; /* Ubah ukuran font untuk membuat ikon lebih besar */
  color: #333;
  margin-right: 20px;
  transition: color 0.3s ease;
}

.social-icon:hover {
  color: #007bff;
}

</style>