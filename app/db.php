<?php

// Conexión a la base de datos
// Cree una función para meter todos los datos de la base de datos registrados en config.php y utilizarlos en una variable que llame $dsn
// Se utiliza PDO paar hacer la conexión y creo una variable llamada $dns para meter los datos de la base de datos y con try intentamos hacer la conexión con la BBDD
// Si sale con exito regreso la conexión si no con catch mando el error para que se muetre en el front, que mate el intento y que se muestre el error por el cual no se pudo realizar la conexión.

function db_conexion(
    $db_motor = DB_MOTOR,
    $db_host = DB_HOST,
    $db_nombre = DB_NOMBRE,
    $db_usuario = DB_USUARIO,
    $db_contraseña = DB_CONTRASEÑA,
    $db_charset = DB_CHARSET
) {

    try {
        $dsn = "$db_motor:host=$db_host;dbname=$db_nombre;charset=$db_charset";

        $conexion = new PDO($dsn, $db_usuario, $db_contraseña);
        return $conexion;
        
    } catch (Exception $error) {
        die('no se pudo conectar con la base de datos <br>' . $error->getMessage());
    }
};


// Petición a la base de datos: Creé una función donde voy a hacer peticiones a la BBDD voy a pasar un statement que va a ser la esta SELECT * FROM generos; y le paso los parametros que va a ser la información que vamos a insertar llamado CRUD y por último meto un debug en false para que si hay un error lo arroje en true y pueda ver cual es el error.


function query_db($mando, $parametros = [], $debug = false)
{   // hago una varibale llamando a la conexión de la base de datos para que se almacene en la variable
    $conector = db_conexion();

    // Esto es para preparar nuestro enunciado o consulta con la variable $query y se le asignan objetos como métodos y ejecutamos la petición de los parametros.

    $query = $conector -> prepare($mando);

    // Ejecutar la informacion dentro de query ($mando)

    // Esto puede ser true o false que significa que si se ejecuto con algún error ya que tiene el ! regresamos un false para que nos muestre el error con el debug.

    // los parametros trae sus placeholders con la info que se va a insertar y no se inserten en parametros.
    if (!$query -> execute($parametros)) {
        
        // no pudo insertase
        // no pudo borrarse
        // no se pudo actualizar

        if ($debug) {
            $error = $query -> errorInfo();
            echo $error[0];
            echo $error[1];
            echo $error[2];
        }
        return false;
    }

    // si te se pudo insertar
    // si se pudo actualizar 
    // si se pudo borrar
    
    $cuenta = 0;
    $cuenta = $query -> rowCount();

    //  esto sirve para buscar una palabra strung especifica, entonces queremos buscar en $mando la palabra SELECT, si encuentra una o más veces la palabra va a regresar el numero de veces pero si no se regresa un false
    if (strpos($mando, 'SELECT') !== false) {
        // seleción o busqueda de info
        // con esto necesito contarlos resultados y regresarlos 
        // con fetchall nos regresa todos lo resultados en un array
        if($cuenta > 0) {
            return $query -> fetchAll();

        }

        return false;

    } else if(strpos($mando,'INSERT INTO') !== false) {
        // necesito regresar el id de la fila insertada
        if($cuenta > 0) {
            return $conector -> lastInsertId();

        }

        return false;

    } else if(strpos($mando, 'UPDATE') !== false) {
        // necesito contar cuantos registros se actualizaron y si son mas de 0
        // regersar true

        if($cuenta >= 0) {
            return true;

        }

    } else if(strpos($mando, 'DELETE') !== false) {
        // regresar true si son 0 o mas filas afectadas

        if($cuenta > 0) {
            return true;

        }

        return false;
    }
    return true;
};
