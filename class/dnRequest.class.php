<?php
/**
 * @version   dnRequest.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase para obtener información sobre la
 * petición del usuario.
 *
 * @package    dnMVC
 * @subpackage dnRequest
 * @since      0.5
 */
class dnRequest extends dnBase
{

	/**
	 * Método para crear una instancia única de la clase dnRequest.
	 *
	 * @return dnRequest
	 * @since  0.5
	 */
	public static function getInstance() {
		return parent::getInstance('dnRequest');
	}


	/**
	 * Método para comprobar si existe una variable en la
	 * petición.
	 *
	 * @param  string $var Nombre de la variable.
	 * @return boolean
	 * @since  0.5
	 */
	public static function exists($var)
	{

		if (isset($_REQUEST[$var])) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Método para obtener el valor de una variable.
	 *
	 * @param  string $var Nombre de la variable.
	 * @param  string $value Valor por default de la variable.
	 * @return mixed
	 * @since  0.5
	 */
	public static function get($var, $value = null)
	{

		if (isset($_REQUEST[$var])) {
			return $_REQUEST[$var];
		} else {
			return $value;
		}

	}


	public function __get($name) {

			return $this->get($name);

	}

	public static function set($var, $value = null)
	{

		$_REQUEST[$var] = $value;

	}

	public function __set($name, $value)
	{

		$this->set($name, $value);

	}


	/**
	 * Sobrecarga- Comprueba si existe una variable.
	 *
	 * @param  string $var Nombre de la variable.
	 * @return bool
	 * @since  0.5
	 */
	public function __isset($name) {

			return isset($_REQUEST[$name]);

	}

	public function getUpper($var, $value = null)
	{

		return mb_strtoupper($this->get($var, trim($value)), 'UTF-8');

	}

	public function getDate($var, $value = null)
	{

		return UtilHelper::convertDate( $this->get($var, $value ) );

	}


	/**
	 * Método para obtener los datos de un archivo.
	 *
	 * @param  string $file Nombre del archivo.
	 * @return mixed
	 * @since  0.6
	 */
	public static function getFile($file)
	{
		if (isset($_FILES[$file])) {
			return (object) $_FILES[$file];
		} else {
			return null;
		}
	}

	/**
	 * Método para saber si es una petición XMLHttpRequest.
	 *
	 * @return boolean
	 * @since  0.5
	 */
	public function isAJAX()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		} else {
			return false;
		}
	}

}
