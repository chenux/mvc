<?php
/**
 * @version   dnBase.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase base que implementa el patrón Singleton
 * (Una sola instancia de la clase).
 *
 * @package    dnMVC
 * @subpackage dnBase
 * @since      0.5
 */
class dnBase
{
    /**
     * @var   array Instancias de las subclases.
     * @since 0.5
     */
    private static $instances = array();

    /**
     * @var   array Errores.
     * @since 0.5
     */
    protected $errors = array();

    /**
     * Método constructor.
     *
     * @since 0.5
     */
    private function __construct() { }

    /**
     * Método para crear una instancia única de una subclase.
     *
     * @param  $class Nombre de la clase.
     * @return object
     * @since  0.5
     */
    public static function getInstance($class) {

        //
        if(!isset(self::$instances[$class])) {

            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

    /**
     * Método para establecer un error.
     *
     * @param string $error Mensaje del error.
     * @since 0.5
     */
    public function setError($error)
    {
        array_push($this->errors, $error);

    }

    /**
     * Método para obtener el último error.
     *
     * @return string
     * @since  0.5
     */
    public function getError()
    {
        return  end($this->errors);
    }
}
