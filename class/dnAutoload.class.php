<?php
/**
 * @version   dnAutoload.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase para incluir los archivos de las otras clases del sistema cuando se
 * intenta crear un objeto.
 *
 * @package    dnMVC
 * @subpackage dnAutoload
 * @since      0.5
 */
class dnAutoload
{

    /**
     * @var   dnAutoload Instancia de dnAutoload.
     * @since 0.5
     */
    private static $instance = null;

    /**
     * @var   string Directorio base.
     * @since 0.5
     */
    private $baseDir = null;

    /**
     * @var   array Archivos de las clases.
     * @since 0.5
     */
    private $classes = array(
        'dnApp'        => 'dnApp.class.php',
        'dnBase'       => 'dnBase.class.php',
        'dnConfig'     => 'dnConfig.class.php',
        'dnController' => 'dnController.class.php',
        'dnController' => 'dnController.class.php',
        'dnModel'      => 'dnModel.class.php',
        'dnModel'      => 'dnModel.class.php',
        'dnPDO'        => 'dnPDO.class.php',
        'dnRequest'    => 'dnRequest.class.php',
        'dnUser'       => 'dnUser.class.php',
        'dnUtil'       => 'dnUtil.class.php',
        'dnView'       => 'dnView.class.php',
        );

    /**
     * Método constructor.
     *
     * @since 0.5
     */
    private function __construct()
    {
        $this->baseDir = dirname(__FILE__);
    }

    /**
     * Método para crear una instancia única de la clase dnAutoload.
     *
     * @return dnAutoload
     * @since  0.5
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new dnAutoload();
        }
        return self::$instance;
    }

    /**
     * Registra una función autoload para cargar las clases automáticamente
     * al tratar de crear sus instancias.
     *
     * @since  0.5
     */
    public static function  register() {

        ini_set('unserialize_callback_func', 'spl_autoload_call');

        if (false === spl_autoload_register(array(self::getInstance(), 'autoload'))) {
            die ('Erro al intentar registrar la función autoload');
        }

    }

    /**
     * Autocarga para las clases del sistema.
     *
     * @param  string $class Nombre de la clase a cargar.
     * @return boolean
     * @since  0.5
     */
    public function autoload($class)
    {
        if ($path = $this->getClassPath($class)) {
          require $path;
          return true;
        }

        return false;
    }

    /**
     * Obtiene la ubicación de la clase.
     *
     * @param  string $class Nombre de la clase.
     * @return string
     * @since  0.5
     */
    public function getClassPath($class)
    {

        if (!isset($this->classes[$class])) {
          return null;
        }

        return $this->baseDir.'/'.$this->classes[$class];
    }

}
