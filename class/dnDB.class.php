<?php
/**
 * @version   dbQuery.class.php 0.5.1 2017-03-01
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
 * @subpackage dbQuery
 * @since      0.5
 */
class dnDB
{

	// public static function getInstance() {

	// 	return parent::getInstance('dnDB');

	// }


	public static function table($table)
	{
		return new dnQuery($table);
	}


}