<?php
/**
 * @version   dnModel.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase base para el modelo. Se usa para administrar la Base de Datos.
 *
 * @package	dnMVC
 * @subpackage dnModel
 * @since	  0.5
 */
class dnModel extends dnBase
{

	/**
	 * @var   string Nombre de la tabla.
	 * @since 0.5
	 */
	protected $table = null;

	/**
	 * @var   string Nombre del campo ID.
	 * @since 0.5
	 */
	protected $id = null;

	/**
	 * @var   string Campo papelera.
	 * @since 0.6
	 */
	protected $trash = "trash";

	/**
	 * @var   array Campos requeridos.
	 * @since 0.5
	 */
	protected $columns_required  = array();

	/**
	 * @var   Último elemento agregado o modificado.
	 * @since 0.5
	 */
	protected $lastid = null;

	/**
	 * @var   dnPDO Objeto dnPDO para el acceso a la base de datos.
	 * @since 0.5
	 */
	protected $db;

	/**
	 * Método para crear una instancia única de la clase dnModel.
	 *
	 * @param  $class Nombre de la clase.
	 * @return dnModel
	 * @since  0.5
	 */
	public static function getInstance($class, $module = null) {

		require_once dnConfig::getInstance()->getFileModel($class, $module);

		$model = parent::getInstance($class . 'Model');
		$model->setUp();

		return $model;
	}


	/**
	 * Método de instalación.
	 *
	 * @since 0.5
	 */
	public function setUp()
	{

		$this->db = dnPDO::getInstance();

	}



	/**
	 * Método para obtener los elements de la tabala.
	 *
	 * @param  array $filters Filtros.
	 * @param  int   $type Tipo de subcategoría (26 - Marcas, 27 - Grupos).
	 * @return boolean|mixed
	 * @since  1.0
	 */
	public function getItems($filters = array())
	{

		extract($filters);

		// SQL.
		$sql = "SELECT * FROM " . $this->table .  " ";

		// Páginado.
		if (isset($limit)) {

			$sql .= "LIMIT " . $limit . " ";

		} else if (isset($page)) {

			$sql .= "LIMIT " . $this->getPageBegin($page) . ", " . $this->getPageLimit();

		}

		return $this->select($sql);


	}


	/**
	 * Método para obtener los datos del producto.
	 *
	 * @param  array $id ID del producto.
	 * @return boolean|mixed
	 * @since  1.0
	 */
	public function getItem($id)
	{

		// SQL.
		$sql = "SELECT * FROM " . $this->table;

		return $this->get($sql, [$this->id => intval($id)]);


	}


	/**
	 * Método para obtener los productos del cotizador.
	 *
	 * @param  int $session_id Identificador de la sesión.
	 * @return boolean|PDOStatement
	 * @since  1.0
	 */
	public function select($sql, $parameters = [])
	{


		$parameters = $this->prepareFields($parameters);

		try {

			// Ejecutamos consulta.
			$query = $this->db->prepare($sql);
			$query->execute($parameters);
			//echo $sql;

			return $query->fetchAll(PDO::FETCH_OBJ);

		} catch (PDOException $e) {

			echo $sql . ' - ' . $e->getMessage();
			$this->setError($e->getMessage());
			return false;

		}


	}


	public function get($sql, $parameters = [] )
	{



		$sql .=  $this->getWhere($parameters);

		$parameters = $this->prepareFields($parameters);

		try {

			// Ejecutamos consulta.
			$query = $this->db->prepare($sql);
			$query->execute($parameters);

			return $query->fetch(PDO::FETCH_OBJ);

		} catch (PDOException $e) {

			echo $sql . ' - ' . $e->getMessage();
			$this->setError($e->getMessage());
			return false;

		}


	}



	/**
	 * Método para insertar un registro.
	 *
	 * @param  array $values Datos.
	 * @return boolean
	 * @since  1.0
	 */
	public function insert($values = array())
	{

		// Insertar.
		$sql = "INSERT INTO " . $this->table .  " ";
		$cont = 0;
		// Campos.
		$fields = '';
		$binds  = '';

		foreach($values as $key => $value) {

			$cont++;

			$fields .=  $key;
			$binds  .=  ":" . $key;

			// Agregar coma(,) si no es el último campo.
			if ( $cont < count($values) ) {

				$fields .= ", ";
				$binds  .= ", ";

			}

		}

		$sql .= "(" . $fields . ") VALUES (" . $binds . ") " ;


		$values = $this->prepareFields($values);

		try {

			// Ejecutamos consulta.
			$query = $this->db->prepare($sql);
			$query->execute($values);
			return true;

		} catch (PDOException $e) {

			// echo $sql . ' - ' . $e->getMessage();
			$this->setError('<strong>Insetar: </strong>' . $e->getMessage());
			return false;

		}

	}


	/**
	 * Método para actualizar los datos del expediente.
	 *
	 * @param  array $values Datos.
	 * @return boolean
	 * @since  1.0
	 */
	public function update($values = [], $where = [])
	{

		// Actualizar.
		$sql = "UPDATE " . $this->table . " SET ";

		$cont = 0;

		foreach($values as $key => $value) {

			// Omitimos el ID.
			if ( $this->id != $key ) {

				$cont++;

				// Agregamos coma(,).
				if ( $cont > 1 )
					$fields .= ", ";

				$fields .= $key . " = :" . $key;

			}

		}

		$sql .= $fields . " ";

		// Valores del where.
		foreach($where as $key => $value) {

			$values[$key] = $value;

		}

		// Where.
		$sql .=  $this->getWhere($where);
		$values = $this->prepareFields($values);


		try {

			// Ejecutamos consulta.
			$query = $this->db->prepare($sql);
			$query->execute($values);

		} catch (PDOException $e) {
			//echo $sql . ' - ' . $e->getMessage();
			$this->setError('<strong>Actualizar: </strong>' .
							$sql . ' - ' .$e->getMessage());
			return false;

		}

		return true;
	}


	/**
	 * Método para eliminar los elementos.
	 *
	 * @param  int $id Identificador del elemento.
	 * @return boolean
	 * @since  0.5
	 */
	public function delete($where)
	{

		// SQL.
		$sql = "DELETE FROM " . $this->table;

		$sql .=  $this->getWhere($where);
		$where = $this->prepareFields($where);


		// Ejecutamos consulta.
		try {

			$query = $this->db->prepare($sql);
			$query->execute($where);

			return true;

		} catch (PDOException $e) {
			echo $sql . ' - ' . $e->getMessage();
			$this->setError($e->getMessage());
			return false;
		}


	}


	public function getWhere($fields = [])	{

		// Error.
		if ( empty($fields) ) { return false; }

		//SQL.
		$sql = " WHERE ";

		$cont = 0;

		foreach ($fields as $key => $value) {

			$cont++;

			// Agregamos operador.
			if ($cont > 1 ) { $sql .= " AND "; }

			$sql .= $key . " = :" . str_replace('.', '_', $key);


		 }

		return $sql;

	}


	public function prepareFields($fields = [], $symbol  = ":")
	{

		$values = [];

		foreach($fields as $key => $value) {

			$key = str_replace('.', '_', $key);

			$values[ $symbol . $key ] = $value;

		}

		return $values;

	}


	public function get_order_by($field, $fields = array(), $default = "")
	{

		foreach($fields as $key => $value) {

			if ($field == $key) {
				return "ORDER BY $value ";
			}

		}

		return "ORDER BY $default ";

	}


	public function setTrash($id)
	{

		// Actualizar.
		$sql = "UPDATE " . $this->table . " SET " . $this->trash . " = 'SI' " .
			   "WHERE id = :id ";

		try {

			// Ejecutamos consulta.
			$query = $this->db->prepare($sql);
			$query->execute(array(':id' => $id));

		} catch (PDOException $e) {

			$this->setError($e->getMessage());
			return false;

		}

		return true;
	}


	/**
	 * Método para el ID del último elemento modificado o agregado.
	 *
	 * @return int
	 * @since  0.5
	 */
	public function getLastID()
	{
		return $this->db->lastInsertId();
	}


	public function getColumns()
	{

		// SQL.
		$sql = "DESCRIBE " . $this->table;

		// Ejecutamos consulta.
		try {

			$query = $this->db->prepare($sql);
			$query->execute();
			return $query->fetchAll();

		} catch (PDOException $e) {

			return array();

		}

	}


	public function getColumnsRequired()
	{

		return $this->columns_required;

	}

	public function checkColumns($row)
	{

		$columns = $this->getColumns();

		foreach ($row as $column => $value) {

			foreach ($columns AS $field) {

				if ( $column == $field['Field']) {

					/* Requerido */
					if ( $field['Null'] == 'NO' and empty($field['Default']) ) {


						if ( trim($value) === '') {
							$this->columns_required[] = $column;
						}

					}

				}

			}

		}

		return empty($this->columns_required);

	}

	/**
	 * Método para obtener los valores de una columna ENUM.
	 *
	 * @param  $table Nombre de la tabla.
	 * @param  $column Nombre de la columna.
	 * @return array
	 * @since  0.5
	 */
	public function getEnumValues($column)
	{

		// SQL.
		$sql = "SHOW COLUMNS FROM ".$this->table . " WHERE Field = :column ";

		// Ejecutamos consulta.
		try {
			$query = $this->db->prepare($sql);

			$query->execute(array(":column" => $column));

			$enum = $query->fetch();

			preg_match_all("/\'(.+?)\'/", $enum['Type'], $values);

			$items = array();

			foreach (end($values) as $value) {
				$items[] = $value ;
			}

			return $items;


		} catch (PDOException $e) {

			return array();

		}

	}


	/**
	 * Método para obtener el inicio de la página.
	 *
	 * @return int
	 * @since  0.5
	 */
	public function getPageBegin($page)
	{
		$page = ($page) ? $page : 1;
		return ($page - 1) * $this->getPageLimit() ;
	}

	/**
	 * Método para obtener el límite de la página.
	 *
	 * @return int
	 * @since  0.5
	 */
	public function getPageLimit()
	{
		return dnConfig::getInstance()->get('page_limit');
	}

	/**
	 * Método para obtener el número total de elementos.
	 *
	 * @return int
	 * @since  0.5
	 */
	public function getPageItems()
	{

		// SQL.
		$sql = "SELECT FOUND_ROWS() as items ";

		// Ejecutamos consulta.
		try {
			$query = $this->db->prepare($sql);
			$query->execute();
		} catch (PDOException $e) {
			$this->setError($e->getMessage());
			return false;
		}

		$result = $query->fetchObject();
		return $result->items;
	}

	/**
	 * Método para obtener todos los datos de la paginación.
	 *
	 * @return array
	 * @since  0.5
	 */
	public function getPageAll($page)
	{
		$items = $this->getPageItems();

		$page = ($page) ? $page : 1;

		return array(
			// Número de Página
			'page'  => $page,
			// Total de Páginas
			'total' => ceil($items/$this->getPageLimit()),
			// Inicio (LIMIT)
			'begin' => $this->getPageBegin($page),
			// Fin (LIMIT)
			'limit' => $this->getPageLimit(),
			// Número de Registros
			'items' => $items,
		);
	}
}
