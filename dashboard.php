<?php
session_start();
require_once 'config.php';

if (!isset($_COOKIE['session_id'])) {
    header('Location: ./');
    exit;
}


$sql = "SELECT * FROM users WHERE cookie='" . $_COOKIE['session_id'] . "'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    header('Location: ./logout');
    exit;
}

$conn->close();
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Fundación Jóvenes Soñadores Por Talaigua - Pagina Oficial de nuestra fundación encaminada a ayudar a los pequeños y jóvenes, para que consigan explotar su potencial y ayudar a su comunidad velando por un mejor futuro para ellos, su familia y sus proximas generaciones.">
  <meta name="keywords" content="Fundación, Jóvenes, Soñadores, Talaigua">
  <meta name="author" content="Martin Avila Becerra">
  <meta name="robots" content="index,follow">
  <meta name="language" content="Spanish">
  <meta name="revisit-after" content="30 days">
  <link rel="canonical" href="https://youngdreamersfortalaigua.org/dashboard">
  <link rel="manifest" href="./manifest.json">
  <title>Inicio | Fundación Jóvenes Soñadores Por Talaigua</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <link href="./assets/css/main.css" rel="stylesheet">
</head>

<body class="mb-5">
  <div class="preloader" id="preloader">
    <div class="loader"></div>
  </div>
  <div class="conatiner-fluid p-4">
    <div class="row">
      <form class="form-group has-search col-10 pe-0" method="post" action="search">
        <input type="text" class="form-control backgroundalt searchhome" name="keyword" placeholder="Buscar eventos o información...">
      </form>
      <div class="notifications col-2 text-center">
        <div class="icon" data-bs-toggle="offcanvas" data-bs-target="#notificationCanva" aria-controls="notificationCanva">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="auto" fill="currentColor" class="bi bi-bell"
            viewBox="0 0 16 16">
            <path
              d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
          </svg>
        </div>
      </div>
    </div>
  </div>
  
  <div class="conatiner-fluid ps-4">
  <h2>Eventos</h2></div>
  <div id="homecarousel" class="carousel slide">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="container">
          <div class="row mx-1">
            <div class="col-6 col-md-6">
              <a href="./donations" class="linkcard text-decoration-none">
              <div class="card">
                <img class="card-img-top"
                  src="https://images.pexels.com/photos/551590/pexels-photo-551590.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                  alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Donaciones</h5>
                  <p class="card-text">Vestuario para niños y niñas.</p>
                </div>
              </div>
              </a>
            </div>
            <div class="col-6 col-md-6">
              <a href="./events?filter=volunteers" class="linkcard text-decoration-none">
              <div class="card">
                <img class="card-img-top"
                  src="https://images.pexels.com/photos/792043/pexels-photo-792043.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                  alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Voluntariados</h5>
                  <p class="card-text">Dar la mano para mejorar.</p>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container">
          <div class="row mx-1">
            <div class="col-6 col-md-6">
              <a href="./donations" class="linkcard text-decoration-none">
              <div class="card">
                <img class="card-img-top"
                  src="https://images.pexels.com/photos/1813504/pexels-photo-1813504.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                  alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">Donaciones</h5>
                  <p class="card-text">Alimentos no perecederos.</p>
                </div>
              </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev d-none d-sm-none d-md-block" type="button" data-bs-target="#carouselExample"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next d-none d-sm-none d-md-block" type="button" data-bs-target="#carouselExample"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <div class="conatiner-fluid p-4">
  <h2 class="mt-3">Noticias</h2>
  </div>
  <div class="offcanvas offcanvas-end" tabindex="-1" id="notificationCanva" aria-labelledby="notificationCanvaLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="notificationCanvaLabel">Notificaciones</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    ...
  </div>
</div>


  <nav class="nav nav-fill fixed-bottom backgroundalt pb-3">
    <a class="nav-link active" aria-current="page" href="./dashboard"><svg xmlns="http://www.w3.org/2000/svg"
        width="100%" height="100%" fill="currentColor" class="bi bi-house-heart" viewBox="0 0 16 16">
        <path d="M8 6.982C9.664 5.309 13.825 8.236 8 12 2.175 8.236 6.336 5.309 8 6.982Z" />
        <path
          d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.707L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.646a.5.5 0 0 0 .708-.707L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
      </svg>
      <div class="text-decoration-none text-center">Home</div>
    </a>
    <a class="nav-link" href="./aboutus"><svg xmlns="http://www.w3.org/2000/svg" width="100%" fill="currentColor"
        class="bi bi-people" viewBox="0 0 16 16">
        <path
          d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
      </svg>
      <div class="text-decoration-none text-center">Nosotros</div>
    </a>
    <a class="nav-link" href="./donations"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
        fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
        <path
          d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z" />
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
        <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" />
      </svg>
      <div class="text-decoration-none text-center">Donaciones</div>
    </a>
    <a class="nav-link" href="./account"><svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
        fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path
          d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
      </svg>
      <div class="text-decoration-none text-center">Cuenta</div>
    </a>
  </nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="./assets/js/app.js"></script>
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register('/sw.js')
        .then(function (registration) {
          console.log('Service worker registered successfully with scope: ', registration.scope);
        })
        .catch(function (error) {
          console.log('Service worker registration failed with error: ', error);
        });
    });
  }
</script>
<script>
  window.addEventListener("load", function () {
    const preloader = document.getElementById("preloader");
    preloader.classList.add("hide-preloader");
  });
</script>
<script>
  const myCarouselElement = document.querySelector('#homecarousel')

  const carousel = new bootstrap.Carousel(myCarouselElement, {
    interval: 2000,
    touch: true
  })
</script>
</body>
</html>