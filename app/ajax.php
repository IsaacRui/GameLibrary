<?php
require_once 'config.php';


// Que tipo de petición esta solicitando ajax
if (!isset($_POST['action'])) {
    json_encode(403);
}

// voy a pasarle una variable ajax y si no existe sera un error automaticamente, si existe debe entrar en el switch
$action = $_POST['action'];

// GET
// voy a pasarle "accion" que tenga el valor de registro_usuario para que entre en el primer case, si no coincide con nigun case se va a default y automaticamente maraca un error 403

switch ($action) {
    case 'registro_us':
        if (!isset($_POST['data'])) {
            json_output(400);
        }

        // Si si esta aceptada

        parse_str($_POST['data'], $data);

        // Valiación de correo email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            json_output(400, 'El email es incorrecto');
        }

        // Validar que el correo ya existe, con un boolean si el correo ya existe agarrando la información de $data'email' que revise en la base dedatos si el correo ya existe muestro un toast de que ya existe ese correo.
        if (nombre_us($data['email'])) {
            json_output(400, 'El email ya está registrado');
        }

        // Segunda validación

        if (strlen($data['pass']) < 5) {
            json_output(400, 'Contraseña insegura, ingresa mínimo 5 caracteres');
        }

        if ($data['pass'] !== $data['password_2']) {
            json_output(400, 'Tus contraseñas no coinciden');
        }

        // Guardar usuario en la base de datos

        $usuario =
            [
                'nombre' => trim($data['usuario']),
                'email' => trim($data['email']),
                'pass' => password_hash($data['pass'] . AGREGAR, PASSWORD_DEFAULT),
                'creado' => fecha()

            ];

        // Insertar el registro de usuario

        if (!ins_columna('usuarios', $usuario)) {
            json_output(400, 'Hubo un problema, intenta de nuevo');
        }

        json_output(201);

        break;

        // Case para el Login de usuario

    case 'login_us':
        if (!isset($_POST['data'])) {
            json_output(400);
        }

        // Si si esta aceptada

        parse_str($_POST['data'], $data);

        // Valiación de correo email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            json_output(400, 'El email es incorrecto');
        }

        // Segunda validación

        if (strlen($data['pass']) < 5) {
            json_output(400, 'Contraseña incorrecta');
        }

        // ---------------------------------------------------
        // Información de usuario 
        // Buscar en la BD si existe el email
        // Si no existe no hay usuario y no es válido, creo una variable con el nombre de usuario que sea igual a el nombre de usuario que tenga el mail correcto.
        $usuario = nombre_us($data['email']);
        // con este boolean pregunto si no existe usuario que arroje el toast 'el usuario no existe'.
        if (!$usuario) {
            json_output(400, 'El usuario no existe');
        }

        // Si existe, cargamos la información para validar su contraseña, valido que la contraseña sea correcta con if !(not)password_verify(osea si la contraseña no es correcta o válida, de la información de $data'pass'.AGRERAR con lo que esta en la base de datos osea $usuario'pass'), mando mensaje de 'la contraseña es incorrecta', de lo contrario, 'bienvenido de nuevo', mostrando el nombre de usuario de la base de datos. 
        if (!password_verify($data['pass'] . AGREGAR, $usuario['pass'])) {
            json_output(400, 'La contraseña es incorrecta');
        }

        // Inicializar la sesión del usuario
        sesion_usuario($usuario);


        json_output(200, 'Bienvenido de nuevo ' . $usuario['nombre']);

        break;

    case 'agr_juego':
        // if (!isset($_POST['titulo'], $POST['id_genero'], $_POST['id_plataforma'], $POST['calificacion'], $_POST['opinion'])) {
        //     json_output(400, 'Completa el formulario');
        // }

        //  Crear un array del nuevo juego
        // con la variable nuevo juego generamos un array de todos los datos que hay en la base de datos, entonces llamados al id usuario, título, etc. is_array sirve para que el array que llame de la base de datos verifique si es un array y si es que lo muestre como array de lo contrario si llamo direco a la funcion sesion()['id'] me arroja un error que dice: 'Trying to access array offset on value of type bool' 

        $nv_juego =
            [
                'id_usuario'    =>  is_array(sesion()) ? sesion()['id'] : true,
                'titulo'        =>  trim($_POST['titulo']),
                'id_genero'     =>  $_POST['id_genero'],
                'id_plataforma' =>  $_POST['id_plataforma'],
                'calificacion'  =>  $_POST['calificacion'],
                'opinion'       =>  trim($_POST['opinion']),
                'creado'        =>  fecha()

            ];




        // Si el usuario subió una imagen procesarla, pongo 4 porque significa que no se subío ningún archivo, osea si existe la portada dentro de files y no es 4 se subió la imgen de forma correcta 

        if (isset($_FILES['portada']) && $_FILES['portada']['error'] !== 4) {
            // Primero vamos almacenarla en una variable
            $img = $_FILES['portada'];
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);

            // Después vamos a renombrarla
            $nv_nombre = generar_archivo() . '.' . $ext;

            // Después vamos a guardarla en nuestro SERVIDOR dentro de UPLOADS
            if (!move_uploaded_file($img['tmp_name'], UPLOADS . $nv_nombre)) {
                json_output(400, 'Hubo un error al guardar la imagen, intenta de nuevo');
            }

            $nv_juego['portada'] = $nv_nombre;
        }




        // // Guardar en la base de datos
        if (!ins_columna('juegos', $nv_juego)) {
            json_output(400, 'Hubo un error, intenta de nuevo');
        }

        json_output(201, 'Nuevo juego agregado con éxito');


        break;

    case 'm_juego':
        if (!isset($_POST['id'])) {
            json_output(403, 'Hubo un error, intenta de nuevo');
        }

        // ID del juego que queremos ver
        $id = (int) $_POST['id'];

        // Cargar la info del juego
        $juego = juego_id($id);

        // Validar si existe o no el juego
        if (!$juego) {
            json_output(400, 'El juego no existe, intenta de nuevo');
        }


        // Cargar el html formatearlo
        ob_start();
        require_once '../views/modulos/juego_single.php';
        $output = ob_get_clean();



        // Regresar el JSON con la info del html
        json_output(200, 'Ok', $output);

        break;

    case 'act_juego':
        // Hay que validar que existan esos campos del juego para poder pasar la información

        // if (!isset($_POST['id'], $_POST['titulo'], $POST['id_genero'], $_POST['id_plataforma'], $POST['calificacion'], $_POST['opinion'])) {
        //     json_output(400, 'Completa el formulario');
        // }

        //  Crear un array del nuevo juego

        $id = (int) $_POST['id'];

        $juego =
            [

                'titulo'        =>  trim($_POST['titulo']),
                'id_genero'     =>  $_POST['id_genero'],
                'id_plataforma' =>  $_POST['id_plataforma'],
                'calificacion'  =>  $_POST['calificacion'],
                'opinion'       =>  trim($_POST['opinion'])


            ];

        // Si el usuario subió una imagen procesarla, pongo 4 porque significa que no se subío ningún archivo, osea si existe la portada dentro de files y no es 4 se subió la imgen de forma correcta 

        if (isset($_FILES['portada']) && $_FILES['portada']['error'] !== 4) {
            // Obtener la imagen anterior si existe
            $port_anterior = $_POST['port_anterior'];

            // Primero vamos almacenarla en una variable
            $img = $_FILES['portada'];
            $ext = pathinfo($img['name'], PATHINFO_EXTENSION);

            // Después vamos a renombrarla
            $nv_nombre = generar_archivo() . '.' . $ext;

            // Después vamos a guardarla en nuestro SERVIDOR dentro de UPLOADS
            if (!move_uploaded_file($img['tmp_name'], UPLOADS . $nv_nombre)) {
                json_output(400, 'Hubo un error al guardar la imagen, intenta de nuevo');
            }

            $juego['portada'] = $nv_nombre;
        }

        // Antes de regresar la respuesta debo borrar la imagen anterior
        if (isset($nv_nombre) && is_file(UPLOADS . $nv_nombre)) {
            if (is_file(UPLOADS . $port_anterior)) {

                unlink(UPLOADS . $port_anterior);
            }
        }


        // // Guardar en la base de datos
        if (!actualizar('juegos', ['id' => $id], $juego)) {
            json_output(400, 'Hubo un error, intenta de nuevo');
        }

        json_output(200, 'Cambios guardados con éxito');
        break;

    case 'borrar_juego':
        if (!isset($_POST['id'])) {
            json_output(403, 'Acceso denegado');
        }

        $id = (int) $_POST['id'];

        // Validar que el juego es del usuario loggeado
        if (!$juego = juego_id($id)) {
            json_output(400, 'El juego no existe, intenta de nuevo');
        }

        // El usuario debe ser el mismo al id del registro
        if (is_array(sesion())) {
            if ((int) $juego['id_usuario'] !== sesion()['id']) {
                json_output(403, 'Acceso denegado');
            }
        }



        // Borro el registro
        if (!borrar_registro('juegos', ['id' => $id])) {
            json_output(400, 'Error, intenta de nuevo');
        }

        // Borrar la imagen del registro
        if (is_file(UPLOADS . $juego['portada'])) {
            unlink(UPLOADS . $juego['portada']);
        }

        json_output(200, 'Juego borrado con éxito');

        break;
    default:
        json_output(403);
        break;
}
