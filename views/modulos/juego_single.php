  <?php
    // Con esto hacemos que cada página tenga el inicio de sesión de un usuario, sin el no podemos bloquear paginas para usuarios no logueados
    session_start(); ?>

  <!-- Modal -->
  <!-- Esta ventana modal es para que ver la información de cada juego -->
  <div class="modal fade" id="modal_juego" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
      <div class="modal-lg modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
              <div class="modal-header">
                  <!-- Con esto pongo el nombre por el que fue subido el juego -->
                  <h5 class="modal-title" id="juegoModal">Información del Videjuego | <?php echo $juego['nombre'] ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                          <!-- con esto muestro las imágenes de cada juegop llamando a la ruta donde se encuentras las imágenes y mostrandolas con la variable juego -> portada -->
                          <img src="<?php echo './assets/uploads/' . $juego['portada'] ?> " alt="" class="image-fluid img-thumbnail">
                      </div>
                      <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                          <!-- Aquí llamo al título y a la plataforma de forma dinámica para cada juego -->
                          <h2><?php echo $juego['titulo'] ?> | <span class="text-muted"><?php echo $juego['plataforma'] ?></span></h2>
                          <p class="text-danger"><?php echo $juego['genero'] ?></p>
                          <p class="text-warning">
                              <!-- También para la calificación -->
                              <?php echo estrellas((int) $juego['calificacion'])  ?>
                          </p>
                          <p class="mt-3"><?php echo $juego['opinion'] ?></p>
                          <!-- Con este boolean le digo que si hay un usuario logueado muestre los botones de la modal "editar" y "eliminar" y si no hay un usuario logueado que no se muestren -->
                          <?php if (logueado() && $juego['id_usuario'] == sesion()['id']) : ?>
                              <div class="btn-group">
                                  <a class="btn btn-sm btn-success" href="<?php echo 'actualizar.php?id=' . $juego['id']; ?>" data-bs-toggle="tooltip" title="Editar juego"> <i class="fas fa-edit"></i> </a>
                              </div>
                              <button class="btn btn-sm btn-danger float-end borrar_juego" data-id="<?php echo $juego['id'] ?>"> <i class="fas fa-trash"></i> Eliminar juego </button>
                          <?php endif; ?>
                      </div>
                  </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
          </div>
      </div>
  </div>