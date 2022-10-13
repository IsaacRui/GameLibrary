<?php

// ------------------------------------------------
// Funciones Generales
// Estas son todas mis funciones generales para todo el sitio
// ------------------------------------------------

function obt_generos()
{
    //  con esta función llamo al los generos de todos los juegos, genero una variable llamada parametros que seleccionen desdela base de datos de la tabla gener y los ordene por su id de foprma descendiente
    $parametros = 'SELECT * FROM generos ORDER BY id DESC';
    // Aquí retorno la variable filas que es un boolean que indica que si hay parametros, los meta en filas si no que lo marque como falso osea que no meta nada
    return ($filas = query_db($parametros)) ? $filas : false;
}

function obt_plataformas()
{
    // Aquí pasa lo mismo pero con las plataformas 
    $parametros = 'SELECT * FROM plataformas ORDER BY id DESC';

    return ($filas = query_db($parametros)) ? $filas : false;
}


function json_output($status = 200, $msg = '', $data = [])
{
    // Con esta funcíon creo un status, mensaje y data para que pueda indicar a cada accion de jquery si se esta generando correctamente cada accíon o no y me indique cual es el status, mensaje y data de cada cosa.
    //http_response_code($status);
    $respuesta =
        [
            'status' => $status,
            'msg'    => $msg,
            'data'   => $data
        ];
    echo json_encode($respuesta);
    die;
}

function fecha()
{
    // con esta función muestro la fecha de creado desde la base de datos
    return date('Y-m-d h:i:sa');
}

function redirect($url)
{
    // con esta redirijo a diferentes secciones si es que el usuario esta logueado o no 
    header('Location: ' . URL . $url . '.php');
    die;
}

function generar_archivo($lng = 8, $span = 2)
{
    // con esta función la idea es generar un numero de 2 elementos con 8 digitos, para poder renombrar las imágenes, osea que si el lenght no es integro de 8 digitos que lo genere
    if (!is_integer($lng)) {
        $lng = 8;
    }
    // si no es intrego de dos elemtos, que los genere
    if (!is_integer($span)) {
        $span = 2;
    }

    // si el span es mayor a 5 elementos que los que los guarde si no que represente el mismo span 
    $span = ($span > 5 ? 5 : $span);

    // creo unas varibles vacias para poder generar el loop
    $archivo = '';
    $min = '';
    $max = '';

    // si i es igual a 0 y tambien i es mayor a 8 osae el lenght que i vaya añadiendo 1 con las variables contcatenamos y genero una minima de 1 y una maxima de 9 para que siempre se generen 8 digitos
    for ($i = 0; $i < $lng; $i++) {
        $min .= '1';
        $max .= '9';
    }

    // y con esto uno los valores con un guión bajo entre los dos elementos
    for ($i = 0; $i < $span; $i++) {
        $archivo .= rand((int) $min, (int) $max) . '_';
    }

    // Al final retornamos el string del nuevo nombre generado para las imágenes con numero y eliminamos el último digito para que pueda meter el .jpg o .png sin problemas  
    return substr($archivo, 0, -1);
}

function obt_imagen($path)
{
    if (!is_file($path)) {
        return IMAGENES . 'broken-image.png';
    }

    return URL . $path;
}

function estrellas($rating)
{
    // con esto genero la calificación de cada juego, si rating es integro que lo respresente si no que sea un 3
    $rating = (is_integer($rating) ? $rating : 3);

    $empty = '<i class="fa-regular fa-star"></i>';
    $full = '<i class="fa-solid fa-star"></i>';
    $output = '';
    $min = 1;
    $max = 5;

    // Entonces si rating es mayor a i que represente las estrellas rellenas si no que las represente sin relleno
    for ($i = 0; $i < $max; $i++) {
        if ($rating > $i) {
            $output .= $full;
        } else {
            $output .= $empty;
        }
    }
    return $output;
}

function formato_fecha($fecha)
{
    // con esta función genero un formato de fecha para que se vea como lo indico 'd/m/y' en la parte de todos los juegos
    return date('d/m/y', strtotime($fecha));
}

// ------------------------------------------------
// Funciones para sesión de usuario
// ------------------------------------------------

// Crear la sesión de usuario
// Cuando llame a la función sesion_us y le pase la info de info_usuario se iniciara una sesión guardando toda la información del $usuario y se guarda en el sevidor.
function sesion_usuario($info_usuario)
{

    // Cargar la informacion del usuario desde la base de datos
    // Nombre, email, navbar_color, creado. Validamos con boolean si la sesión ya existe, regreso un false porque ya esta iniciada la sesión.

    session_start();
    if (isset($_SESSION['us_activo'])) {
        return false;
    };



    // si no esta iniciada creamos un array de información que concuerde, si está activa esa información que la guarde como activa de lo contrario que sea nulo. Al final creo una variable activa para que regrese un true si es que esta activa.
    $usuario =
        [
            'id'             => (isset($info_usuario['id']) ? $info_usuario['id'] : NULL),
            'nombre'         => (isset($info_usuario['nombre']) ? $info_usuario['nombre'] : NULL),
            'email'          => (isset($info_usuario['email']) ? $info_usuario['email'] : NULL),
            'navbar_color'   => (isset($info_usuario['navbar_color']) ? $info_usuario['navbar_color'] : NULL),
            'creado'         => (isset($info_usuario['creado']) ? $info_usuario['creado'] : NULL),
            'active'         => TRUE
        ];

    $_SESSION['us_activo'] = $usuario;
    return true;
}

// Para verifcar si esta activa
function logueado()
{

    if (!isset($_SESSION['us_activo'])) {
        return false;
    }

    if (!isset($_SESSION['us_activo']['active'])) {
        return false;
    }

    $us_activo = $_SESSION['us_activo'];

    if ($us_activo['active'] !== TRUE) {
        return false;
    }

    return true;
}

// Cargar la informacion del usuario
function sesion()
{
    if (!logueado()) {
        return false;
    }

    return $_SESSION['us_activo'];
}

// para destruir la sesión
function destruir_sesion()
{
    unset($_SESSION['us_activo']);
    session_destroy();
    return true;
}


// ------------------------------------------------
//  Usuarios 
// ------------------------------------------------

// get - add - uptade - delete

function nombre_us($email)
{
    $parametros =
        'SELECT u.* FROM usuarios u WHERE u.email = :email LIMIT 1';

    return ($fila = query_db($parametros, ['email' => $email])) ? $fila[0] : false;
}

// ------------------------------------------------
// Funciones para interactuar con la BD
// ------------------------------------------------

// Creo una función para agregar usuarios con un array con la info del usuario

function ins_columna($tabla, $param = [])
{

    // Mandos para parametros dinámicos

    $parametros = 'INSERT INTO ' . $tabla . ' 
    ' . ins_nombres($param) . ' 
    VALUES 
    ' . ins_placeholders($param) . '';

    // Ejecutar el query y se inserta el registro

    return ($id = query_db($parametros, $param)) ? $id : true;
}

function borrar_registro($table, $keys = [])
{
    $mando = 'DELETE FROM ' . $table;
    $cols = '';

    // Si hay keys se agregan al mando
    if (empty($keys)) {
        return false;
    }

    $mando .= ' WHERE ';

    foreach ($keys as $k => $v) {
        $cols .= $k . '=:' . $k . ' AND';
    }

    $cols = substr($cols, 0, -3);
    $mando .= $cols . ' LIMIT 1';

    return (query_db($mando, $keys, true)) ? true : false;
}

function actualizar($table, $keys = [], $param = [])
{
    // UPDATE table SET columna = :placeholder, columna = :placeholder WHERE id = ;id;
    $placeholders = '';
    $cols = '';

    foreach ($param as $k => $v) {
        $placeholders .= $k . '=:' . $k . ',';
    }

    $placeholders = substr($placeholders, 0, -1);

    $mando = 'UPDATE ' . $table . ' SET ' . $placeholders;

    // Si no hay keys se agregan al mando
    if (!empty($keys)) {
        $mando .= ' WHERE ';
        foreach ($keys as $k => $v) {
            $cols .= $k . '=:' . $k . ' AND';
        }

        $cols = substr($cols, 0, -3);
        $mando .= $cols;
    }

    // Ejecutar el query
    return (query_db($mando, array_merge($keys, $param))) ? true : false;
}

// Crear función para insertar diferentes procesos de registros en general

function ins_nombres($param)
{

    // (nombre, email, pass, navbar_color, creado) voy a convertir este string de forma dinámica para poder hacer inserts si es que se llegan a tener mil columnas por ejemplo, se puedan generar rápidamente

    $cols = '';
    if (empty($param)) {
        return false;
    }

    //  para ello hacemos un foreach para que por cada parametro, se genere una columna y concatenamos la variable cols con los paréntesis y las comas
    $cols .= '(';

    foreach ($param as $k => $v) {
        $cols .= $k . ',';
    }

    $cols = substr($cols, 0, -1);

    $cols .= ')';

    return $cols;
}

function ins_placeholders($param)
{

    // Con este genero los place holders automaticamente para los parametros de la base de datos, si es que se llegan a tener miles los concateno con los signos indicados que son ( : , )
    $placeholders = '';
    if (empty($param)) {
        return false;
    }

    $placeholders .= '(';

    foreach ($param as $k => $v) {
        $placeholders .= ':' . $k . ',';
    }

    $placeholders = substr($placeholders, 0, -1);

    $placeholders .= ')';

    return $placeholders;
}

// ------------------------------------------------
// Videojugos
// ------------------------------------------------

// Cargar los videojuegos del usuario actual

function juegos_us($id_usuario)
{
    // Quiero seleccionar todas las columnas de la tabla juegos del usuario que corresponda al $id_usuario pasado

    // con esto creo el mando para la variable parametros, quiero llamarlo v a los videojuegos para que seleccione todo de juegos v donde el id del usuario de la tabla juegos v sea igual a el id de usuario y que lo ordene de forma descendiente
    $parametros = 'SELECT v.* FROM juegos v WHERE v.id_usuario = :id_usuario ORDER BY v.id DESC';

    return ($filas = query_db($parametros, ['id_usuario' => $id_usuario])) ? $filas : false;
}

// Cargar un juego con id

function juego_id($id)
{
    // Aqui genero el id del videojuego y le doy un join para que se muestre en la modal cada plataforma, usuario y genero de forma dinamica entonces, quiero seleccionar de todos los videjuegos donde genero, plataforma y normbre de la tabla juegos, haga un join y los vaya mostrano segun el id de de cada juego
    $parametros = 'SELECT v.*, g.genero, p.plataforma, u.nombre FROM juegos v JOIN generos g ON v.id_genero = g.id JOIN plataformas p ON v.id_plataforma = p.id JOIN usuarios u ON v.id_usuario = u.id WHERE v.id = :id LIMIT 1';

    return ($filas = query_db($parametros, ['id' => $id])) ? $filas[0] : false;
}

function obt_juegos()
{
    // lo mismo para este 
    $parametros = 'SELECT v.*, g.genero, p.plataforma, u.nombre FROM juegos v JOIN generos g ON v.id_genero = g.id JOIN plataformas p ON v.id_plataforma = p.id JOIN usuarios u ON v.id_usuario = u.id';

    return ($filas = query_db($parametros)) ? $filas : false;
}
