<?php


require 'app/config.php';

// Utilizo el inicio de sesión para esa sección
session_start();


// Aquí indico que si no esta logueado lo redirija a registrarse
if (!logueado()) {
  redirect('registro');
}


// Cargar los juegos que tenga el usuario
$juegos = juegos_us(sesion()['id']);

$data = [
  'title' => 'MIS JUEGOS',
  'juegos' => $juegos

];

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <base href="<?php echo BASEPATH; ?>">
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" src="<?php echo IMAGENES . 'joystick.png' ?>">
  <link rel="stylesheet" href="<?php echo CSS . 'bootstrap.min.css' ?>">
  <link rel="stylesheet" href="<?php echo PLUGINS . 'waitMe/waitMe.min.css' ?>" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <title>B Gaming</title>
</head>

<body>
  <!-- Nav -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="<?php echo URL; ?>"><i class="fa-solid fa-book-open-reader"></i> <?php echo COMPANY_NAME; ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Todos los juegos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="juegos.php">Mis juegos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="agregar_juego.php">Agregar nuevo juego</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-md-auto">
          <!-- Aquí indicamos que si esta logueado algun usuario se muestre el nombre del usuario en la parte superior llamando a la función sesión -->
          <?php if (logueado()) : ?>
            <li class="nav-item">
              <a href="#" class="nav-link"><?php echo sesion()['nombre'] ?></a>
            </li>
            <li class="nav-item <?php echo (isset($data['active']) && $data['active'] == 'logout' ? 'active' : '') ?>">
              <a href="logout.php" class="nav-link">Cerrar sesión</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a href="registro.php" class="nav-link">Registro</a>
            </li>
            <li class="nav-item">
              <a href="login.php" class="nav-link">Iniciar Sesión</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>
  </nav>

  <!-- Termina Nav -->

  <!-- contenido -->

  <!-- Juegos -->
  <div class="container" style="padding: 150px 20px;">
    <div class="row">
      <h1 class="text-center mb-5"><?php echo $data['title']; ?></h1>
      <?php if ($data['juegos']) : ?>
        <div class="row">
          <?php foreach ($data['juegos'] as $j) : ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
              <div class="card">
                <img src="<?php echo obt_imagen('./assets/uploads/' . $j['portada']);  ?>" alt="" class="card-img-top" style="height: 400px; object-fit: cover;">
                <div class="container">
                  <div class="card-body text-start p-2">
                    <h5 class="card-title text-truncate"><?php echo $j['titulo']; ?></h5>
                    <p class="text-warning d-inline float-start">
                      <?php echo estrellas((int) $j['calificacion']) ?>
                    </p>
                    <button class="button btn btn-sm btn-success float-end juego_modal" data-id="<?php echo $j['id']; ?>" data-bs-toggle="tooltip" title="Ver juego">
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
          <!-- Esto es para generar la paginación de los videjuegos que tal vez más adelante lo haga ya que  -->
          <!-- <div class="col-xl-12 col-12 mt-5">
            <nav aria-label="Paginacion de videojuegos">
              <ul class="pagination justify-content-center">
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
            </nav>
          </div> -->
        <?php else : ?>

          <div class="text-center">
            <img class="img-fluid" src="<?php echo IMAGENES . 'game-controller.png' ?>" alt="No hay videojuegos" style="width: 120px;">
            <p class="mt-3 text-muted">No hay videojuegos guardados.</p>
            <div class="btn btn-primary btn-lg mt-5 mb-5">Agregar nuevo juego</div>
          </div>

        <?php endif; ?>

        </div>
    </div>
  </div>
  <!-- acaba contenido -->

  <!-- Modal de videojuego -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#juegoModal">
    Abrir Modal
  </button> -->

  <!-- Empieza footer -->
  <div class="container-fluid p-3 bg-secondary w-100">
    <footer id="footer">
      <div class="text-center">
        Desarrollado por <a href="#">Isaac Ruíz</a>.
      </div>
  </div>
  </footer>
  </div>
  <!-- Finaliza Footer -->

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

  <!-- Plugin de Sweet Alert para Alertas de mensaje -->

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Plugin de font awsome para iconos -->
  <script src="https://kit.fontawesome.com/87b3bcbd70.js" crossorigin="anonymous"></script>

  <!-- Plugin de js para utilizar animaciones de carga -->
  <script src="<?php echo PLUGINS . 'waitMe/waitMe.min.js' ?>"></script>

  <!-- Plugin de js para utilizar animaciones de notificación Toastr -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <!-- Lláma a la funciones de JS -->
  <script src="<?php echo JS . 'functions.js' ?>"></script>

  <!-- Lláma a main Js -->
  <script src="<?php echo JS . 'main.js' ?>"></script>
</body>

</html>