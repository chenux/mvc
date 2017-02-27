<?php

// Evitar el acceso directo.
define('APPEXEC', 1);

// Mostrar todos los errores.
ini_set('display_errors', 'On');

error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_WARNING);
//error_reporting(E_ALL & ~E_NOTICE);

// Incluimos la clase que nos ayudara a cargar las demas clases del sistema.
require_once dirname(__FILE__) . '/class/dnAutoload.class.php';

// Registramos una función autoload.
dnAutoload::register();

// Creamos instancia única de la clase dnApp e iniciamos la aplicación.
dnApp::getInstance()->execute();
