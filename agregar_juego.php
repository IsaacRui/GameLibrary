<?php require 'app/config.php';

// Aquí prácticamente se hace lo mismo que en las demás secciones...

session_start();

if (!logueado()) {
    redirect('registro');
}


$data = [
    'title' => 'Agregar nuevo juego',

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
                        <a class="nav-link" href="juegos.php">Mis juegos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active" href="agregar_juego.php">Agregar nuevo juego</a>
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
    <div class="container" style="padding: 150px 20px;">
        <div class="row">
            <div class="offset-xl-3 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-5"><?php echo $data['title']; ?></h2>
                        <form id="agregarJuego">
                            <div class="form-group mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo">
                            </div>
                            <div class="form-group mb-3">
                                <label for="id_genero" class="form-label">Genero</label>
                                <select class="form-control form-select" id="id_genero" name="id_genero">
                                    <option value="" selected>Selecciona una opción...</option>
                                    <?php foreach (obt_generos() as $genero) : ?>
                                        <option value="<?php echo $genero['id'] ?>"><?php echo $genero['genero'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="id_plataforma" class="form-label">Plataforma</label>
                                <select class="form-control form-select" id="id_plataforma" name="id_plataforma">
                                    <option value="" selected>Selecciona una opción...</option>
                                    <?php foreach (obt_plataformas() as $plataforma) : ?>
                                        <option value="<?php echo $plataforma['id'] ?>"><?php echo $plataforma['plataforma'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="calificacion" class="form-label">Calificación</label>
                                <input type="range" class="form-control form-range" min="1" max="5" value="1" id="calificacion" name="calificacion">
                            </div>
                            <div class="input-group mb-3">
                                <label for="portada" class="input-group-text">Portada del juego</label>
                                <input type="file" class="form-control" id="portada" name="portada" accept="image/*">
                            </div>
                            <div class="form-group mb-3">
                                <label for="opinion" class="form-label">Opinión</label>
                                <textarea name="opinion" id="opinion" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Agregar</button>
                            <button type="reset" class="btn btn-danger float-end">Cancelar</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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