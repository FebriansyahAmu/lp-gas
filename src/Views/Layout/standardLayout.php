<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/img/favicon.png" type="image/x-icon">
    <title>Pangkalan Gas Abdulah</title>

    <!--Bootstrap-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
      rel="stylesheet"
    />
      <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <?php component('spinners'); ?>
      <!-- <div class="container-fluid p-2 fixed-top mt-3" style="margin-left: 50px; margin-right: 50px">
          <a class="navbar-brand" href="#">
            <img src="/img/logo.png" alt="PK-GasAbdullah Logo" style="height: 40px;">
          </a>
      </div> -->
    <section
      class="vh-100 overflow-auto"
      style="
       
      "
    >
        <?php echo $content; ?>
    </section>
  </body>
  <style>
@media only screen and (max-width: 500px) {
    .g-recaptcha {
        transform:scale(0.82);
        transform-origin:0 0;
    }
}
</style>
  <script src="/js/pkabdullahreg.js"></script>





