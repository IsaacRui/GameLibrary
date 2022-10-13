<?php

/**
 * Inicialización de sesión de usuario
 */



/* URL Constantes sirven para poder tener siempre las url bien definidas y si en algun punto cambia tu proyecto, solo se tendrían que cambiar aquí */

define('PORT', '80');
define('BASEPATH', '/proyecto_final/');
define('URL', 'http://www.isaacruar.com' . BASEPATH);


/* Constantes para los paths de archivos */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', getcwd() . DS);
define('APP', ROOT . 'app' . DS);
define('INCLUDES', ROOT . 'includes' . DS);
define('VIEWS', ROOT . 'views' . DS);
define('MODULOS', VIEWS . 'modulos' . DS);

define('ASSETS', URL . 'assets/');
define('CSS', ASSETS . 'css/');
define('IMAGENES', ASSETS . 'img/');
define('JS', ASSETS . 'js/');
define('PLUGINS', ASSETS . 'plugins/');
define('UPLOADS',  '../assets/uploads/');


/**
 * Constantes adicionales
 */

define('AGREGAR', 'ContraFinal');
define('COMPANY_NAME', 'BGaming');
define('COMPANY_EMAIL', 'noreplay@bbgaming.com');

/**
 *  Constantes de la conexión a la base de datos
 */

define('DB_MOTOR', 'mysql');
define('DB_HOST', 'bbdd.isaacruar.com');
define('DB_PUERTO', '80');
define('DB_NOMBRE', 'ddb191450');
define('DB_USUARIO', 'ddb191450');
define('DB_CONTRASEÑA', 'Hardbeats24!');
define('DB_CHARSET', 'utf8');

/**
 * Incluir todas las funciones personalizadas
 */

require_once  'db.php';
require_once  'functions.php';
