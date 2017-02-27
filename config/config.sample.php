<?php

/**
 * Archivo de configuración del sistema.
 *
 * @version     config.php 1.1.0 2016-05-18
 * @package     dnMVC
 * @subpackage  dnConfig
 * @copyright   Copyright (c) 2010, Delnux System
 * @since       1.0
 */

// Configuración del sitio.
$config = array();

// Nombre de la plantilla principal.
$config['ap_theme'] = 'theme';

// Módulo por defecto.
$config['default_module'] = '';

// Controlador por defecto.
$config['default_controller'] = '';

// Acción por defecto.
$config['default_action'] = 'index';


// Servidor.
$config['db_driver']    = 'mysql';

$config['db_server']    = 'localhost';

// Nombre de la base de datos.
$config['db_database']  = '';

// Usuario.
$config['db_user']      = 'root';

// Contraseña.
$config['db_pass']      = '';

// Configuraciones del driver.
$config['db_config']    = array (
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
);

// Elementos por página.
$config['page_limit']   = 30;


// Correo del administrador.
$config['email_webmaster']   = '';




