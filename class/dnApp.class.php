<?php
/**
 * @version   dnApp.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase principal que se encarga de iniciar el sistema y
 * crear los objetos de las otras clases.
 *
 * @package    dnMVC
 * @subpackage dnApp
 * @since      0.5
 */
class dnApp extends dnBase{

	/**
	 * Método para crear una instancia única de la clase dnApp.
	 *
	 * @return dnApp
	 * @since  0.5
	 */
	public static function getInstance()
	{
		return parent::getInstance('dnApp');
	}

	/**
	 * Método para iniciar la aplicación.
	 *
	 * @since 0.5
	 */
	public function execute()
	{

		// Cargamos la configuración.
		if(!dnConfig::getInstance()->load()) {
			die('Error al cargar la configuración');
		}

		// Cargamos el controlador.
		if ($this->loadController()) {

			// Comprobamos si existe la clase y su método.
			if (is_callable(array($this->getModuleName(), $this->getActionName())) == false) {
				die('Error en el controlador acción no encontrada');
			}
		}
		else {
			die('Error al cargar el controlador');
		}

		// Crear y ejecutar el controlador.
		dnController::getInstance($this->getModuleName())
					->executeAction($this->getActionName());

	}

	/**
	 * Método para obtener el nombre del módulo.
	 *
	 * @return string
	 * @since  0.5
	 */
	public function getModuleName()
	{

		$module = dnConfig::getInstance()->get('default_module');
		return dnRequest::getInstance()->get('module', $module);

	}

	/**
	 * Método para obtener el tipo de controlador.
	 * - Administrado (admin.php)
	 * - Usuario (user.php)
	 * - Default (controller.php)
	 *
	 * @return string
	 * @since  1.0
	 */
	public function getController()
	{

		$controller = dnConfig::getInstance()->get('default_controller');
		return dnRequest::getInstance()->get('controller', $controller);

	}


	/**
	 * Método para obtener el nombre de la acción.
	 *
	 * @return string
	 * @since  0.5
	 */
	public function getActionName()
	{

		$action = dnConfig::getInstance()->get('default_action');
		return dnRequest::getInstance()->get('action', $action);

	}


	/**
	 * Método para cargar el controlador del módulo.
	 *
	 * @return boolean
	 * @since  0.5
	 */
	public function loadController()
	{

		$file_controller = dnConfig::getInstance()->getFileController( $this->getModuleName(), $this->getController() );

		if (is_file($file_controller)) {

			// Incluimos el archivo.
			require $file_controller;
			return true;

		}

		echo $file_controller;
		return false;
	}
}
