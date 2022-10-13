<?php require 'app/config.php';

$data = [
    'title' => 'Editar juego',

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
    <div class="w-100">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo URL; ?>"><i class="fa-solid fa-book-open-reader"></i> <?php echo COMPANY_NAME; ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor02">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Mis juegos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="juegos.php">Todos los juegos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./views/crear.php">Agregar nuevo juego</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!-- Termina Nav -->

    <!-- contenido -->
    <div class="container" style="padding: 150px 20px;">
        <div class="row">
            <div class="offset-xl-3 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-5"><?php echo $data['title']; ?></h2>
                        <form id="agregarJuego" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="titulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $data['juego']['titulo'] ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="genero" class="form-label">Genero</label>
                                <select type="" class="form-control form-select" id="genero" name="genero">
                                    <option value="" selected>Selecciona una opción...</option>
                                    <option value="1">Shooter</option>
                                    <option value="2">Aventura</option>
                                    <option value="3">RPG</option>
                                    <option value="4">Open World</option>
                                    <option value="5">Racing</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="plataforma" class="form-label">Plataforma</label>
                                <select type="" class="form-control form-select" id="plataforma" name="plataforma">
                                    <option value="" selected>Selecciona una opción...</option>
                                    <option value="1">PS5</option>
                                    <option value="2">Xbox One</option>
                                    <option value="3">Nintendo Switch</option>
                                    <option value="4">PC</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="calificacion" class="form-label">Calificación</label>
                                <input type="range" class="form-control form-range" min="1" max="5" value="1" id="calificacion" name="calificacion">
                            </div>
                            <div class="input-group mb-3">
                                <label for="portada" class="input-group-text">Portada del juego</label>
                                <input type="file" class="form-control" id="titulo" name="titulo" accept="image/*">
                            </div>
                            <div class="form-group mb-3">
                                <label for="opinion" class="form-label">Opinión</label>
                                <textarea name="opinion" id="opinion" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success float-end">Agregar</button>
                            <button type="reset" class="btn btn-danger">Cancelar</button>
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