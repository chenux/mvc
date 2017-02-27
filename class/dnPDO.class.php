<?php
/**
 * @version   dnPDO.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase extendida para el acceso a la Base de Datos.
 *
 * @package    dnMVC
 * @subpackage dnPDO
 * @since      0.5
 */
class dnPDO extends PDO
{

    /**
     * @var dnPDO Instancia de la clase dnPDO.
     */
    private static $instance = null;

    /**
     * Método constructor.
     *
     * @since 0.5
     */
    public function __construct()
    {
        $config = dnConfig::getInstance();

        parent::__construct('mysql:host=' . $config->get('db_server') .
                            ';dbname=' . $config->get('db_database'),
                            $config->get('db_user'),
                            $config->get('db_pass'),
                            $config->get('db_config'));

        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->exec("SET lc_time_names = 'es_ES'; ");
    }

    /**
     * Método para crear una instancia única de la clase dnPDO.
     *
     * @return dnPDO
     * @since  0.5
     */
    public static function getInstance()
    {
        if(!self::$instance) {
            self::$instance = new dnPDO();
        }
        return self::$instance;
    }
}
