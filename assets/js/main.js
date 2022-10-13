$(document).ready(function () {
  function init() {}
  init();

  // Funciones para mostrar notificaciones tipo toast

  // Creo un switch para poder darle un diferente anuncio con base a si hay "error - success - info - wargning"

  function toast(contenido, tipo = "success") {
    switch (tipo) {
      case "error":
        toastr.error(contenido, "Error");
        break;

      case "info":
        toastr.info(contenido, "Atención");
        break;

      case "warning":
        toastr.warning(contenido, "Falta Algo");
        break;

      default:
        toastr.success(contenido, "Bien hecho");
        break;
    }

    return true;
  }

  // -------------------------

  // Sesiones de Usuario

  // -------------------------
  // Registro de nuevo usuario

  // LLamo al id que puse para el registro de usuario, y que al hacer submit al botón active la función resigtro_us, esto lo hago practicamente con todas las acciones que se muestran debajo para hacer la conexión con ajax y jquery

  $("#registro_usuario").on("submit", registro_us);
  function registro_us(evento) {
    evento.preventDefault(); // prevenir el submit regular

    // genero unas vaiables para formulario data que es la informacion que quiero solicitar y una accion que es la que genere en el archivo ajax para cada acción del switch.
    var formulario = $(this),
      data = formulario.serialize(),
      action = "registro_us";

    // Validación antes de mandar la información
    // Creo booleans para validar de que en el campo de usuario se haya escrito algo si no marque error, igual con el email y con las contraseñas creo uno paara que valide si son iguales.

    if ($("#usuario").val() == "") {
      toast("Ingresa un nombre de usuario", "error");
      return false;
    }

    if ($("#email").val() == "") {
      toast("Ingresa un email", "error");
      return false;
    }

    if ($("#pass").val() !== $("#password_2").val()) {
      toast("Las contraseñas no son iguales", "error");
      return false;
    }

    // Mandar la petición a ajax.php
    // Con esto hago un conexion ajax llamando al archivo para poder generar el registro ed usuario, que sea tipo post para que se guarde en la base de datos tambien utilice el waitme para genear una animcion de carga al registrar el usuario

    $.ajax({
      url: "app/ajax.php",
      type: "POST",
      dataType: "JSON",
      data: {
        action,
        data,
      },
      beforeSend: function () {
        // antes de que se envie la solicitud genero la animación de carga
        $("body").waitMe();
      },
    })
      .done(function (resp) {
        // una vez que se haya realizado el registro creo un boolean para pasarle un registro con exito 201 y saldra un aviso que si registro se realizo correctamente, y puse un trigger para que despues de 4 segundos con el timeout lo redirija al login si no se hace el registro aparece un mesnaje de error.

        if (resp.status === 201) {
          toast(resp.msg, "Te has registrado con éxito");
          formulario.trigger("reset");
          setTimeout(() => {
            window.location = "login.php";
          }, 2000);
        } else {
          toast(resp.msg, "error");
        }
      })
      .fail(function (error) {})
      .always(function () {
        $("body").waitMe("hide");
      });
  }

  // -----------------------------------------------------------------------
  // Login de Usuarios

  $("#inicio_usuario").on("submit", login_us);
  function login_us(evento) {
    evento.preventDefault();

    var formulario = $(this),
      data = formulario.serialize(),
      action = "login_us";

    // Hacemos la petición a ajax para el login

    $.ajax({
      url: "app/ajax.php",
      type: "POST",
      dataType: "JSON",
      data: {
        action,
        data,
      },
      beforeSend: function () {
        // antes de que se envie la solicitud genero la animación de carga
        $("body").waitMe();
      },
    })
      .done(function (resp) {
        // una vez que se haya realizado el registro creo un boolean para pasarle un registro con exito 200 y saldra un aviso que si registro se realizo correctamente, y puse un trigger para que despues de 4 segundos con el timeout lo redirija al login si no se hace el registro aparece un mesnaje de error.

        if (resp.status === 200) {
          toast(resp.msg, "Has iniciado sesión con éxito");
          formulario.trigger("reset");
          setTimeout(() => {
            window.location = "index.php";
          }, 2000);
        } else {
          toast(resp.msg, "error");
        }
      })
      .fail(function (error) {
        toast("Hubo un error en iniciar sesión", "error");
        return;
      })
      .always(function () {
        $("body").waitMe("hide");
      });
  }

  // -------------------------

  // Videojuegos

  // -------------------------

  // Procesar el formulario de agregar nuevo juego

  $("#agregarJuego").on("submit", agr_juego);
  function agr_juego(evento) {
    evento.preventDefault();

    // Validar el título si el campo título está vacío o contiene menos de 3 caracteres, aparecerá un toast de warning.

    if ($("#titulo").val() == "" || $("#titulo").val().length < 3) {
      toast("Ingresa el título del juego", "warning");
      return;
    }

    // Validar el genero del videojuego

    if ($("#id_genero").val() == "") {
      toast("Selecciona un genero", "warning");
      return;
    }

    // Validar la plataforma

    if ($("#id_plataforma").val() == "") {
      toast("Selecciona una plataforma", "warning");
      return;
    }

    // Validar que la calificación no sea 0 ni mayor a 5

    if ($("#calificacion").val() == 0 || $("#calificacion").val() > 5) {
      toast("Ingresa una calificación", "warning");
      return;
    }

    // Validar la opinión

    if ($("#opinion").val() == "" || $("#opinion").val().length < 10) {
      toast(
        "Ingresa una opinión para el juego, debe contener al menos 10 caracteres",
        "warning"
      );
      return;
    }

    // Luego mandar la info a ajax y que regrese una respuesta.

    var formulario = $(this),
      data = new FormData($("form").get(0)),
      action = "agr_juego";

    // Agregar la action de data
    data.append("action", action);

    // Petición AJAX

    $.ajax({
      url: "app/ajax.php",
      type: "POST",
      dataType: "JSON",
      contentType: false,
      cache: false,
      processData: false,
      data: data,
      beforeSend: function () {
        formulario.waitMe();
      },
    })
      .done(function (resp) {
        if (resp.status === 201) {
          toast("Nuevo juego agregado");
          formulario.trigger("reset");
          setTimeout(() => {
            window.location = "index.php";
          }, 1500);
        } else {
          toast("No se pudo agregar el juego", "error");
          return false;
        }
      })
      .fail(function (error) {
        toast("Hubo un error, intenta de nuevo", "error");
      })
      .always(function () {
        formulario.waitMe("hide");
      });
  }

  // Cargar juego en ventada modal
  $(".juego_modal").on("click", juego_modal);
  function juego_modal(evento) {
    evento.preventDefault();
    var boton = $(this);
    (id = boton.data("id")), (action = "m_juego");

    // Petición para cargar la info
    $.ajax({
      url: "app/ajax.php",
      type: "POST",
      dataType: "JSON",
      data: {
        action,
        id,
      },
      beforeSend: function () {
        $("body").waitMe();
      },
    })
      .done(function (resp) {
        if (resp.status === 200) {
          $("#modal_juego").remove();

          $("body").append(resp.data);

          $("#modal_juego").modal("show");
        } else {
          toast(resp.msg, "error");
        }
      })
      .fail(function (error) {
        toast("Hubo un error, intenta de nuevo", "error");
      })
      .always(function () {
        $("body").waitMe("hide");
      });
  }

  // Actualizar videojuego
  $("#actualizarJuego").on("submit", actualizarJuego);
  function actualizarJuego(evento) {
    evento.preventDefault();

    // Validar el título si el campo título está vacío o contiene menos de 3 caracteres, aparecerá un toast de warning.

    if ($("#titulo").val() == "" || $("#titulo").val().length < 3) {
      toast("Ingresa el título del juego", "warning");
      return;
    }

    // Validar el genero del videojuego

    if ($("#id_genero").val() == "") {
      toast("Selecciona un genero", "warning");
      return;
    }

    // Validar la plataforma

    if ($("#id_plataforma").val() == "") {
      toast("Selecciona una plataforma", "warning");
      return;
    }

    // Validar que la calificación no sea 0 ni mayor a 5

    if ($("#calificacion").val() == 0 || $("#calificacion").val() > 5) {
      toast("Ingresa una calificación", "warning");
      return;
    }

    // Validar la opinión

    if ($("#opinion").val() == "" || $("#opinion").val().length < 10) {
      toast(
        "Ingresa una opinión para el juego, debe contener al menos 10 caracteres",
        "warning"
      );
      return;
    }

    // Luego mandar la info a ajax y que regrese una respuesta.

    var formulario = $(this),
      data = new FormData($("form").get(0)),
      submit = $("#btn_dis"),
      action = "act_juego";

    // Agregar la action de data
    data.append("action", action);

    // Petición AJAX

    $.ajax({
      url: "app/ajax.php",
      type: "POST",
      dataType: "JSON",
      contentType: false,
      cache: false,
      processData: false,
      data: data,
      beforeSend: function () {
        // Antes de que se envíe la información puse un deshabilitador de boton (submit), para que cuando den click en guardar se desactive en lo que lee la información y no puedan exixtir problemas de guardado por darle muchos clicks al guardar.
        submit.attr("disabled", true);
      },
    })
      .done(function (resp) {
        if (resp.status === 200) {
          toast("Juego Actualizado");
          setTimeout(() => {
            window.location = "index.php";
          }, 1500);
          return true;
        } else {
          toast("No se pudo actualizar el juego", "error");
          return false;
        }
      })
      .fail(function (error) {
        toast("Hubo un error, intenta de nuevo", "error");
      })
      .always(function () {
        // aquí lo vuelvo a activar despues de 2 segundos
        setTimeout(() => {
          submit.attr("disabled", false);
        }, 1500);
      });
  }

  // Borrar juegos
  $("body").on("click", ".borrar_juego", borrar_juego);
  function borrar_juego(evento) {
    evento.preventDefault();

    var confirmacion = confirm("¿Estás seguro?");

    if (!confirmacion) return false;

    // Variables
    var boton = $(this),
      id = boton.data("id"),
      action = "borrar_juego";

    // Petición a AJAX
    $.ajax({
      url: "app/ajax.php",
      type: "POST",
      dataType: "JSON",
      data: {
        action,
        id,
      },
      beforeSend: function () {
        $("body").waitMe();
        boton.attr("disabled", true);
      },
    })
      .done(function (resp) {
        if (resp.status === 200) {
          toast("Juego eliminado");
          setTimeout(() => {
            window.location.reload();
          }, 1500);
          return true;
        } else {
          toast("No se pudo borrar el juego", "error");
          return false;
        }
      })
      .fail(function (error) {
        toast("Hubo un error, intenta de nuevo", "error");
      })
      .always(function () {
        $("body").waitMe("hide");
        // aquí lo vuelvo a activar despues de 2 segundos
        setTimeout(() => {
          boton.attr("disabled", false);
        }, 1500);
      });
  }
});
