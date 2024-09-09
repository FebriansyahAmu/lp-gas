<section class="home w-100 vh-100 d-flex justify-content-center align-items-center bg-cover-with-overlay">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-12 text-md-start text-center">
                <h1 class="display-4">Welcome to Our Website!</h1>
                <p class="lead">This is a simple responsive website template with a clean and modern design.</p>
                <a href="#" class="btn btn-primary">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</section>
<style>
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
</style>