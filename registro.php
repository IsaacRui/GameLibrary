<?php

require_once 'app/config.php';

// Con esto le digo que si está logueado lo redirija al index o sea a los juegos subidos

if (logueado()) {
  redirect('index');
}


$data = [
  'title' => 'REGISTRO'
];

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <base href="<?php echo BASEPATH; ?>">
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="<?php echo CSS . 'bootstrap.min.css' ?>">
  <link rel="icon" src="<?php echo IMAGENES . 'joystick.png' ?>">
  <link rel="stylesheet" href="<?php echo PLUGINS . 'waitMe/waitMe.min.css' ?>" />
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <title>Biblioteca de Juegos</title>
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
          <li class="nav-item">
            <a href="registro.php" class="nav-link active">Registro</a>
          </li>
          <li class="nav-item">
            <a href="login.php" class="nav-link">Iniciar Sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Termina Nav -->

  <!-- contenido -->
  <div class="container" style="padding: 150px 20px;">
    <div class="row">
      <div class="offset-xl-3 col-xl-6">
        <div class="card">
          <div class="card-body">
            <h2 class="text-center mb-5"><?php echo $data['title']; ?></h2>
            <form id="registro_usuario">
              <div class="form-group mb-3">
                <label for="usuario" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
              </div>
              <div class="form-group mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="form-group mb-3">
                <label for="pass" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
              </div>
              <div class="form-group mb-3">
                <label for="password_2" class="form-label">Confirma tu contraseña</label>
                <input type="password" class="form-control" id="password_2" name="password_2" required>
              </div>

              <button type="submit" class="btn btn-success float-end">Registrarse</button>

              <div class="form-group mb-3">
                <small class="text-muted">¿Ya tienes cuenta?, ingresa <a href="login.php">aquí</a></small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- acaba contenido -->

  <!-- Empieza footer -->
  <div class="container-fluid p-3 bg-secondary">
    <footer id="footer">
      <div class="col text-center">
        Desarrollado por <a href="#">Isaac Ruíz</a>.
      </div>
  </div>
  </footer>
  </div>
  <!-- Finaliza Footer -->

  <!-- JQuery de Bootstrap -->
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