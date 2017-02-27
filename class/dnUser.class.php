<?php
/**
 * @version   dnUser.class.php 0.7.0 2012-09-26
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase que contiene métodos para administrar los usuarios
 * del sitio.
 *
 * @package	dnMVC
 * @subpackage dnUser
 * @since	  0.6
 */
class dnUser extends dnBase
{

	/**
	 * Método para crear una instancia única de la clase dnUser.
	 *
	 * @return dnUser
	 * @since  0.6
	 */
	public static function getInstance() {

		#if ( !isset($_SESSION) ) {
		//if ( !isset($_COOKIE['PHPSESSID']) ) {
		if (!session_id()) {

			session_start();

		}


		//}

		return parent::getInstance('dnUser');

	}

	/**
	 * Método para cerrar la sesión.
	 *
	 * @return string|boolean
	 * @since  0.6
	 */
	public function closeSession()
	{

		session_start();

		session_unset();
		session_destroy();

	}

	/**
	 * Método para obtener el identificador de la sesión.
	 *
	 * @return string|boolean
	 * @since  0.6
	 */
	public function getSessionId()
	{
		if (session_id()) {
			return session_id();
		} else {
			return false;
		}
	}

	/**
	 * Método para agregar datos al usuario.
	 *
	 * @param string $var Variable.
	 * @param string $val Valor.
	 * @since  0.7
	 */
	public function setVars($vars = array() ) {


		foreach ($vars as $key => $value) {
			$_SESSION[$key] = $value;
		}

	}



	/**
	 * Método para agregar datos al usuario.
	 *
	 * @param string $var Variable.
	 * @param string $val Valor.
	 * @since  0.7
	 */
	public function setVar($var, $val) {

		$_SESSION[$var] = $val;

	}

	public function __set($name, $value)
	{

		$_SESSION[$name] = $value;

	}



	/**
	 * Método para obtener los datos del usuario.
	 *
	 * @param string $var Variable.
	 * @return mixed Valor.
	 * @since  0.7
	 */
	public function getVar($var) {

		return $_SESSION[$var];

	}



	public function __get($name) {

			return $_SESSION[$name];

	}

	/**
	 * Método para obtener los datos del usuario.
	 *
	 * @param string $var Variable.
	 * @return mixed Valor.
	 * @since  0.7
	 */
	public function Access($type) {

		return $_SESSION['access'] == $type;

	}


	/**
	 * Método para obtener el estado de la autentificación.
	 *
	 * @return boolean
	 * @since  0.6
	 */
	public function isAuthenticated() {

		return $_SESSION['authenticated'];

	}


	/**
	 * Método para obtener el estado de la autentificación.
	 *
	 * @return boolean
	 * @since  0.6
	 */
	public function isAdmin() {

		return $_SESSION['access'] == 'Administrador';

	}


	/**
	 * Método para establecer el estado de la autentificación.
	 *
	 * @param boolean $status Estado.
	 * @since  0.6
	 */
	public function setAuthenticated($status) {

		$_SESSION['authenticated'] = $status;

	}


	/**
	 * Método para comprobar el acceso al módulo.
	 *
	 * @param string $module Nombre del módulo.
	 * @return boolean
	 * @since  0.7
	 */
	public function checkPermission($module) {


		if ($this->isAuthenticated() and in_array($module, $_SESSION['credentials'])) {
			return true;
		} else {
			return false;
		}

	}


	/**
	 * Método para establecer un mensaje al usuario.
	 *
	 * @param string $message Mensaje.
	 * @since  0.7
	 */
	public function setMessage($mensaje) {

		$_SESSION['message'] = $message;

	}


	/**
	 * Método para obtener el mensaje.
	 *
	 * @return string|boolean Mensaje.
	 * @since  0.7
	 */
	public function getMessage() {

		$message = $_SESSION['message'];

		$_SESSION['message'] = '';

		return ($message) ? $message : false ;

	}

}

?>