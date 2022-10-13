<?php
require 'app/config.php';

// Con esto hacemos que cada pagina tenga el inicio de sesion de un usuario, sin el no podemos bloquear paginas para usuarios no logueados
session_start();

// Cargar los juegos que tenga el usuario
$juegos = obt_juegos();

// Con esta variable generamos el titulo de la pagina y llamamos a los juegos para que se puedan ver en el el contenido
$data = [
  'title' => 'TODOS LOS JUEGOS',
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
            <a class="nav-link  active" href="index.php">Todos los juegos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="juegos.php">Mis juegos</a>
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
      <!-- Aquí meto el data de título para que se muestre en nombre de la sección -->
      <h1 class="text-center mb-5"><?php echo $data['title']; ?></h1>
      <!-- Con esto hago un boolean para que se muestren los juegos y si no hay que se muestre un mensaje de que no hay juegos que mostrar y que aparezca un boton de agregar uno si es que un usuario está logueado o que se registre si es un usuario que no existe -->
      <?php if ($data['juegos']) : ?>
        <div class="row">
          <!-- este foreach sirve para que se muestre cada uno de los videjuegos -->
          <?php foreach ($data['juegos'] as $j) : ?>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb-3">
              <div class="card">
                <img src="<?php echo obt_imagen('./assets/uploads/' . $j['portada']);  ?>" alt="" class="card-img-top" style="height: 400px;  object-fit: cover;">
                <div class="container">
                  <div class="card-body text-start">
                    <h5 class="card-title text-truncate m-0"><?php echo $j['titulo']; ?></h5>
                    <button class="button btn btn-sm btn-success float-end juego_modal" data-id="<?php echo $j['id']; ?>" data-bs-toggle="tooltip" title="Ver juego">
                      <i class="fas fa-eye"></i>
                    </button>
                    <!-- Con esta función de estrella le indico que se muestre la calificación de cada juego -->
                    <p class="text-warning">
                      <?php echo estrellas((int) $j['calificacion']) ?>
                    </p>
                    <!-- Aquí hago que se muestre el nombre po el que fue subido el juego y la fecha de creación -->
                    <small class="d-block text-muted"><?php echo 'Por ' . $j['nombre'] ?> | <?php echo formato_fecha($j['creado']); ?></small>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <!-- Esto es para generear una numeración de páginas si es que hay muchos juegos dividirla en páginas -->

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
            <img class="img-fluid" src="<?php echo IMAGENES . 'winner.png' ?>" alt="No hay videojuegos" style="width: 120px;">
            <p class="mt-3 text-muted">No hay videojuegos.</p>
            <?php if (logueado()) : ?>
              <a href="agregar_juego.php">
                <div class="btn btn-primary btn-lg mt-5 mb-5">Agregar nuevo juego</div>
              </a>
            <?php else : ?>
              <a href="registro.php">
                <div class="btn btn-primary btn-lg mt-5 mb-5 text-white">Registrate gratis</div>
              </a>
            <?php endif; ?>
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