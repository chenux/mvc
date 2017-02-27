<?php


defined('APPEXEC') or die;


class %CLASS% extends dnController
{


	public $name = '%MODULE%';

	/**
	 * Modelo.
	 *
	 * @var %MODEL_CLASS%Model
	 */
	private $%MODEL% = null;


	public function setUp() {

		$this->%MODEL% = $this->loadModel('%MODEL_CLASS%', '%MODULE%');

		$this->loadHelper('%MODULE%', '%MODULE%');

	}



	private function getRow($request) {

		return [
			%ROWS%
		];

	}



	public function index($request) {
		%CHECK_SECURITY%
		$this->loadView('%CONTROLLER%/index/index');

	}



	public function table($request) {

		%CHECK_SECURITY%
		// Filas.
		$rows = $this->%MODEL%->getItems([
			'page' => $request->get('page', 1),
		]);

		// Páginado.
		$page = $this->%MODEL%->getPageAll(
			$request->get('page', 1)
		);

		if ($rows) {

			// Vista.
			$this->loadView('%CONTROLLER%/table/table', [
				'rows' => $rows,
				'page' => $page,
			]);

		} else {

			WidgetHelper::message_alert('No hay registros para mostrar');

		}

	}

	public function rows($request) {

		%CHECK_SECURITY%
		// Filas.
		$rows = $this->%MODEL%->getItems([
			'page' => $request->get('page', 1),
		]);

		if ($rows) {

			// Vista.
			$this->loadView('%CONTROLLER%/table/table', [
				'rows' => $rows,
			]);

		} else {

			echo 'No hay registros para mostrar';

		}

	}



	public function show($request) {
		%CHECK_SECURITY%
		$row = $this->%MODEL%->getItem(
		 	$request->id
		);


		if ($row) {

			// Vista.
			$this->loadView('%CONTROLLER%/show/show', [
				'row' => $row
			]);

		} else {

			WidgetHelper::message_alert('No se encontro el registro');

		}

	}



	public function add($request) {
		%CHECK_SECURITY%
		// Vista.
		$this->loadView('%CONTROLLER%/form/form', [
			'action' => 'insert',
			'title'  => 'Agregar',
		]);

	}



	public function insert($request) {
		%CHECK_SECURITY%
		// Fila.
		$row = $this->getRow($request);

		// Comprobar campos.
		if ( !$this->%MODEL%->checkColumns($row) ) {

			return ModuleHelper::incompleteJSON($this->%MODEL%->getColumnsRequired());

		}

		if ( $this->%MODEL%->insert($row) ) {

			// Insertar.
			return ModuleHelper::doneJSON($this->%MODEL%->getLastID(), 'Se agrego el registro');

		} else {

			// Error SQL.
			return ModuleHelper::errorJSON($this->%MODEL%->getError());

		}

	}



	public function edit($request) {
		%CHECK_SECURITY%
		// Fila.
		$row = $this->%MODEL%->getItem($request->id);


		if ($row) {

			// Vista.
			$this->loadView('%CONTROLLER%/form/form', [
				'row'    => $row,
				'action' => 'update',
				'title'  => 'Editar',
			]);

		} else {

			WidgetHelper::message_alert('No se encontro el registro');

		}

	}



	public function update($request) {
		%CHECK_SECURITY%
		// Fila.
		$row = $this->getRow($request);
		$id  = $request->id;


		// Comprobar campos.
		if ( !$this->%MODEL%->checkColumns($row) ) {

			return ModuleHelper::incompleteJSON($this->%MODEL%->getColumnsRequired());

		}

		if ( $this->%MODEL%->update($row, ['id' => $id]) ) {

			// Actualizar.
			return ModuleHelper::doneJSON($id, 'Se actualizo el registro');

		} else {

			// Error SQL.
			return ModuleHelper::errorJSON($this->%MODEL%->getError());

		}


	}



	public function remove($request) {
		%CHECK_SECURITY%
		$row = $this->%MODEL%->getItem($request->id);
		$id  = $request->id;

		if ($row) {

			// Vista.
			$this->loadView('%CONTROLLER%/remove/form', [
				'row'   => $row,
				'title' => 'Eliminar',
			]);

		} else {

			return WidgetHelper::message_alert('No se encontro el registro');

		}

	}


	public function delete($request) {
		%CHECK_SECURITY%

		// Id.
		$id = $request->id;

		if ( $this->%MODEL%->delete(['id' => $id]) ) {

			// Eliminar.
			return ModuleHelper::doneJSON($id, 'Se elimino el registro');

		} else {

			// Error SQL.
			return ModuleHelper::errorJSON($this->%MODEL%->getError());
		}


	}


}

