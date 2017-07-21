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
class dnQuery
{

	/**
	 * @var dnPDO Objecto para la base de datos.
	 */
	protected $db = null;


	/**
	 * @var string Tabla principal.
	 */
	protected $table = [];

	protected $id = 'id';

	//protected $symbol_val = '?';

	protected $select_columns = ['*'];

	/**
	 * @var array Campos de condiciones.
	 */
	protected $where_columns = [];
	protected $where_values = [];
	protected $order_column = '';

	// /**
	//  * Método para crear una instancia única de la clase dnUtil.
	//  *
	//  * @return dnUtil
	//  * @since  0.6
	//  */
	// public static function getInstance() {

	// 	return parent::getInstance('dnQuery');

	// }


	/**
	 * Método constructor.
	 *
	 * @param string $table Nombre de la tabla principal.
	 */
	public function __construct($table) {

		$this->table = $table;
		$this->db = dnPDO::getInstance();

		return $this;
	}

	/**
	 * Obtener código SQL del SELECT.
	 *
	 */
	private function getSelect()
	{

		$sql  = 'SELECT ';
		$sql .= join(', ', $this->select_columns);

		return $sql;
	}

	/**
	 * Obtener código SQL del FROM.
	 *
	 */
	private function getFrom()
	{

		$sql  = 'FROM ' . $this->table;
		return $sql;
	}

	private function getSQL()
	{
		return $this->getSelect() . ' ' . $this->getFrom() ;

	}


	public function get()
	{

		try {

			// Ejecutamos consulta.
			$query = $this->db->prepare($this->getSQL());
			$query->execute();
			//echo $sql;

			return $query->fetchAll(PDO::FETCH_OBJ);

		} catch (PDOException $e) {

			echo $sql . ' - ' . $e->getMessage();
			//$this->setError($e->getMessage());
			return false;

		}

	}
	public function first()
	{
		# code...
	}




}
