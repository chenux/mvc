<?php


class %CLASS%Model extends dnModel
{

	protected $table = 'tbl_%TABLE%';


	protected $id = 'id';


	protected $trash = "";


	public function getSQL() {

		// SQL.
		$sql = "SELECT SQL_CALC_FOUND_ROWS " .
					"t%TABLE_SHORT%.* " .
				"FROM tbl_%TABLE% AS t%TABLE_SHORT% ";

		return $sql;

	}


	public function getItems($filters = []) {

		extract($filters);

		// SQL.
		$sql = $this->getSQL() . "WHERE 1 ";

		$parameters = [];

		// Ordenar.
		$sql .= "ORDER BY t%TABLE_SHORT%.id DESC ";

		// Páginado.
		if (isset($limit)) {

			$sql .= "LIMIT " . $limit;

		} else if (isset($page)) {

			$sql .= "LIMIT " . $this->getPageBegin($page) . ", " . $this->getPageLimit();

		}

		// Filas.
		return $this->select($sql, $parameters);

	}



	public function getItem($id) {

		// SQL.
		$sql = $this->getSQL();

		// Fila.
		return  $this->get($sql, ['t%TABLE_SHORT%.id' => intval($id)]);


	}


}