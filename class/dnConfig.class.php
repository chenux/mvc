<?php
/**
 * @version   dnConfig.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase que se encarga de establecer la configuración del sistema.
 *
 * @package    dnMVC
 * @subpackage dnConfig
 * @since      0.5
 */
class dnConfig extends dnBase
{

	/**
	 * @var   array Valores de la configuración.
	 * @since 0.5
	 */
	private $config = array(
		'ap_theme'       => null,
		'no_theme'       => null,
		'default_module' => 'default',
		'default_action' => 'index',
		'db_server'      => null,
		'db_database'    => null,
		'db_user'        => null,
		'db_pass'        => null,
		'db_config'      => null,
		'page_limit'     => 20,
	);

	/**
	 * @var   array Nombre de las carpetas del sistema.
	 * @since 0.5
	 */
	private $directory = array(
		'config'        => 'config',
		'helpers'       => 'helpers',
		'lib'           => 'lib',
		'models'        => 'models',
		'modules'       => 'modules',
		'themes'        => 'themes',
		'www'           => 'www',
		'controllers'   => 'controllers',
		'views'         => 'views',
	);

	/**
	 * @var   array Nombre de los archivos del sistema.
	 * @since 0.5
	 */
	private $file = array(
		//'controller'  => 'controller.php',
		'config'      => 'config.php',
	);

	/**
	 * Método para crear una instancia única de la clase dnConfig.
	 *
	 * @return dnConfig
	 * @since  0.5
	 */
	public static function getInstance()
	{
		return parent::getInstance('dnConfig');
	}

	/**
	 * Método para obtener el valor de una variable.
	 *
	 * @param  string $name Nombre de la variable.
	 * @return mixed
	 * @since  0.5
	 */
	public function get($name)
	{
		if (array_key_exists($name, $this->config)) {
			return $this->config[$name];
		} else {
			return null;
		}
	}


	public function __get($name) {

			return $this->get($name);

	}


	/**
	 * Método para establecer una variable.
	 *
	 * @param string $name Nombre de la variable.
	 * @param mixed $value Valor de la variable.
	 * @since 0.5
	 */
	public function set($name, $value)
	{
		$this->config[$name] = $value;
	}


	public function __set($name, $value)
	{

		$this->set($name, $value);

	}

	/**
	 * Método para agregar variables.
	 *
	 * @param array $vars Variables.
	 * @since 0.5
	 */
	public function add($vars)
	{
		$this->config = array_merge($this->config, $vars);
	}

	/**
	 * Método para cargar la configuración.
	 *
	 * @return boolean
	 * @since  0.5
	 */
	public function load()
	{

		$file_config =  $this->getFileConfig();

		if(is_file($file_config)) {

			// Incluimos el archivo.
			require $file_config;

			$this->add($config);
			return true;
		}
		else {
			return false;
		}
	}


	/**
	 * Método para obtener el directorio principal.
	 *
	 * @return string
	 * @since  0.5
	 */
	function getRootDir()
	{
		return dirname(dirname(__FILE__));

	}

	/**
	 * Método para obtener directorio.
	 *
	 * @return string
	 * @since  0.5
	 */
	function getDirectory($dir)
	{
		return $this->directory[$dir];
	}

	/**
	 * Método para obtener el directorio donde se ecuentran los módulos.
	 *
	 * @return string
	 * @since  0.5
	 */
	function getModulesDir()
	{
		return $this->getRootDir() . '/' . $this->directory['modules'];
	}

	/**
	 * Método para obtener el archivo de configuración.
	 *
	 * @return string
	 * @since  0.5
	 */
	function getFileConfig()
	{

		// Incluimos el archivo de configuración de la siguiente forma.
		// [aplicación]/config/config.php
		return $this->getRootDir() . '/' . $this->directory['config'] . '/' .$this->file['config'];
	}

	/**
	 * Método para obtener el archivo del controlador.
	 *
	 * @param  stirng $module Nombre del módulo.
	 * @param  stirng $type Tipo del controlador.
	 * @return string
	 * @since  0.5
	 */
	function getFileController($module, $type)
	{

		// Incluimos el archivo del controlador de la siguiente forma.
		// [aplicación]/modules/[módulo]/controller/controller.php
		return $this->getModulesDir() . '/' . $module . '/' .
			   $this->directory['controllers'] . '/' . $type . '.php' ;
	}

	/**
	 * Método para obtener el archivo del tema.
	 *
	 * @return string
	 * @since  0.5
	 */
	public function getFileTheme($theme = null)
	{

		$ap_theme = ( $theme ) ? $theme : $this->config['ap_theme'] ;

		// Incluimos el archivo del tema de la siguiente forma.
		// [aplicación]/themes/[tema].php
		return  $this->getRootDir() . '/' . $this->directory['themes'] . '/' .
				$ap_theme . '.php';
	}

	/**
	 * Método para obtener el archivo de la vista.
	 *
	 * @param  string $module Nombre del módulo.
	 * @param  string $view Archivo de la vista.
	 * @return string
	 * @since  0.5
	 */
	public function getFileView($module, $view)
	{
		// Incluimos el archivo de la vista de la siguiente forma.
		// [aplicación]/modules/[módulo]/views/[vista].php
		return  $this->getModulesDir() . '/' . $module .'/' .
				$this->directory['views'] . '/' . $view . '.php';
	}

	/**
	 * Método para obtener el archivo del modelo.
	 *
	 * @param  string $module Nombre del modulo.
	 * @param  string $view Archivo del modelo.
	 * @return string
	 * @since  0.5
	 */
	public function getFileModel($model, $module = null)
	{

		if ($module) {

			// Incluimos el archivo del modelo de la siguiente forma.
			// [aplicación]/modules/[module]/models/[modelo].php
			return  $this->getModulesDir() . '/' . $module .
					'/' . $this->directory['models'] . '/' . strtolower( $model ) . '.php';

		} else {

			// Incluimos el archivo del modelo de la siguiente forma.
			// [aplicación]/models/[modelo].php
			return  $this->getRootDir() . '/' . $this->directory['models'] . '/' . strtolower( $model ) . '.php';

		}

	}

	/**
	 * Método para obtener el archivo del helper.
	 *
	 * @param  string $helper Nombre del helper.
	 * @return string
	 * @since  0.5
	 */
	public function getFileHelper($helper, $module = null)
	{

		if ($module) {

			// Incluimos el archivo del helper de la siguiente forma.
			// [aplicación]/modules/[module]/helpers/[helper].php
			return	$this->getRootDir() . '/' . $this->directory['modules'] . '/' .
					$module . '/' . $this->directory['helpers'] . '/' . $helper . '.php';


		} else {

			// Incluimos el archivo del helper de la siguiente forma.
			// [aplicación]/helpers/[helper].php
			return  $this->getRootDir() . '/' . $this->directory['helpers'] .
					'/' . $helper . '.php';

		}
	}

}
