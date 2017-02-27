<?php

/**
 * @version   dnController.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase para invocar las acciones correspondientes
 * dependiendo de la petición.
 *
 * @package	dnMVC
 * @subpackage dnController
 * @since	  0.5
 */
class dnController extends dnBase
{

	/**
	 * Objeto dnApp.
	 *
	 * @since 0.5
	 */
	protected $app = null;

	/**
	 * Objeto dnConfig
	 *
	 * @since 0.5
	 */
	protected $config = null;

	/**
	 * Objeto dnRequest.
	 *
	 * @since 0.5
	 */
	protected $request = null;

	/**
	 * Objeto dnUser.
	 *
	 * @since 0.5
	 */
	protected $user = null;

	/**
	 * Objeto dnView.
	 *
	 * @since 0.5
	 */
	protected $view = null;

	/**
	 * Habilitar tema para una determinada acción.
	 *
	 * @since 0.5
	 */
	protected $action_theme = true;

	/**
	 * Nombre de modelo del controlador.
	 *
	 * @since 0.6
	 */
	protected $model = null;

	/**
	 * Método para crear una instancia única de la clase dnControlador.
	 *
	 * @param  $class Nombre de la clase.
	 * @return dnControlador
	 * @since  0.5
	 */
	public static function getInstance($class) {

		$instance = parent::getInstance($class);

		$instance->app	   = dnApp::getInstance();
		$instance->config  = dnConfig::getInstance();
		$instance->request = dnRequest::getInstance();
		$instance->user	   = dnUser::getInstance();
		$instance->view	   = dnView::getInstance();

		return $instance;
	}


	/**
	 * Método para la instalacióm.
	 *
	 * @since 1.0
	 */
	public function setup()
	{


	}


	/**
	 * Método que ejecuta la acción del módulo.
	 *
	 * @param string $accion Nombre del método a ejecutar.
	 * @since 0.5
	 */
	public function executeAction($action)
	{


		// Variables para el tema.
		$app	 = $this->app;
		$config  = $this->config;
		$request = $this->request;
		$user	 = $this->user;
		$view	 = $this->view;

		// Incluimos el helpers principales.
		$this->loadHelper('app');
		$this->loadHelper('html');
		$this->loadHelper('module');
		$this->loadHelper('util');
		$this->loadHelper('widget');


		// Instalamos.
		$this->setup();

		if (is_file($this->config->getFileTheme()) and !$this->request->isAJAX()) {

			// Cuando hay un tema y no es AJAX.

			// Obetenemos el búfer de la salida de la acción.
			ob_start();

				// Ejecutamos acción.
				$this->$action($this->request);
				$content = ob_get_contents();

			ob_end_clean();

			if ( $this->getActionTheme() ) {

				// Habilitado el tema para esta acción.
				require $this->config->getFileTheme( $this->request->get('theme', null) );

			} else {

				// Deshabilitado el tema para esta acción.
				echo $content;

			}

		} else {


			// AJAX.

			// Ejecutamos acción.
			$this->$action($this->request);
		}
	}

	/**
	 * Método para cargar un helper.
	 *
	 * @param string $helper Nombre del helper.
	 * @since 0.5
	 */
	public function loadHelper($helper, $module = null)
	{
		require_once dnConfig::getInstance()->getFileHelper($helper, $module);
	}

	/**
	 * Método para cargar una vista.
	 *
	 * @param string $view Archivo de la vista.
	 * @param string $data Datos para vista.
	 * @see   dnView
	 * @since 0.5
	 */
	public function loadView($view, $data = array(), $module = null, $return = false)
	{

		return $this->view->load($view, $data, $module, $return);

	}

	/**
	 * Método para cargar el archivo del modelo.
	 *
	 * @param  string Nombre del modelo.
	 * @return object
	 * @since  0.5
	 */
	public function loadModel($model, $module = null)
	{

		$class = dnModel::getInstance($model, $module);

		return $class;
	}


	public function getModel()
	{

		return $this->loadModel($this->model);

	}

	/**
	 * Método para Habilitar/Deshabilitar el tema.
	 *
	 * @param  bool $status Estado.
	 * @since  0.5
	 */
	public function setActionTheme($status)
	{
		$this->action_theme = (bool) $status;
	}

	/**
	 * Método para obtener el estado del tema.
	 *
	 * @return bool
	 * @since  0.5
	 */
	public function getActionTheme()
	{
		return $this->action_theme;
	}

	/**
	 * Método para redireccionar.
	 *
	 * @since  0.5
	 */
	public function redirect($url)
	{

		header("Location: " . $url);

	}



	public function index($request)
	{

		if (!$this->user->isAuthenticated()) {
			return $this->redirect(AppHelper::url_user('user', 'login'));
		}

		$this->loadView('index');

	}


	public function table($request)
	{

		if (!$this->user->isAuthenticated()) {
			return $this->sessionHTML();
		}

		$rows = $this->getModel()->getAll(
			$request->get('filters')
		);

		$page = $this->getModel()->getPageAll();

		$this->loadView('xtable', array (
			'rows'  => $rows,
			'page'  => $page,
		));

	}


	public function add($request)
	{

		if (!$this->user->isAuthenticated()) {
			return $this->sessionHTML();
		}

		$this->loadView('xform');

	}


	public function edit($request)
	{

		if (!$this->user->isAuthenticated()) {
			return $this->sessionHTML();
		}

		$row = $this->getModel()->get (
			$request->get('id')
		);

		if (!$row) {

			echo "Error: No se encontro el registro - " . $this->getModel()->getError();

		} else {

			$this->loadView('xform', $row);

		}

	}



	public function xsave($request)
	{


		$row = $this->getRow($request);

		if ( $request->get('id') ) {
			$row[':id'] = $request->get('id');
		}

		$model = $this->getModel();

		/* Comprobamos campos */
		if ( !$model->checkColumns($row) ) {

			echo $this->warningJSON($row, $model->getColumnsRequired());
			return;

		}

		/* Guardamos los datos */
		if ( $model->set($row) ) {

			/* Actualizar (Obtener registro) */
			if ( $row[':id'] ) {

				$row = $model->get($row[':id']);

			/* Insertar (Obtener registro) */
			} else {

				$row = $model->get($model->getLastID());

			}

			echo $this->doneJSON($row);

			return $row['id'];

		/* Error SQL */
		} else {

			echo $this->errorJSON($row, $model->getError());

		}

	}




	/**
	 * Método para guardar los datos del formulario.
	 * Resṕonde datos en JSON.
	 *
	 * @param dnRequest $request Objeto petición.
	 * @since 8.5
	 */
	public function save($request)
	{


		// Obtenemos el Registro.
		$row = $this->getRow($request);

		// Modelo.
		$model = $this->getModel();

		// Comprobamos Campos.
		if ( !$model->checkColumns($row) ) {

			return $this->json_response( array (
				'type'    => 2,
				'columns' => $model->getColumnsRequired(),
				'message' => 'Verifica la información que has introducido.',
			));

		}

		// Guardamos los Datos.
		if ( $model->set($row) ) {

			// Actualizar (Obtener ID).
			if ( $request->id ) {

				$id = $request->id;

			// Insertar (Obtener ID).
			} else {

				$id = $model->getLastID();

			}

			// Sin errores.
			$this->json_response( array (
				'type'    => 0,
				'id'      => $id,
				'message' => 'Los datos se han guardado correctamente.',
			));

			return $id;

		/* Error SQL */
		} else {

			return $this->json_response( array (
				'type'    => 3,
				'message' => 'Ha ocurrdio un error: ' . $model->getError(),
			));

		}


	}


	public function json_response($response) {

		// Codificamos en JSON.
		echo json_encode( $response );

	}


	public function sessionHTML() {

			echo 'Su sesión ha expirado...';
			header('HTTP/1.0 401 Unauthorized');

	}


	public function sessionJSON()
	{

		echo json_encode( array (
			'error'   => 1,
			'message' => 'Su sesión ha expirado...',
		));

	}


	public function errorSession( $type = '' )
	{


		$message = 'Su sesión ha expirado...';

		// En JSON.
		if ( $type == 'json' ) {

			return $this->json_response ( array (
				'type'    => 1,
				'message' => $message,
			));

		// En Código.
		} if ( $type == 'code' ) {

			echo $message;
			header('HTTP/1.0 401 Unauthorized');

		// En HTML.
		} else {

			echo WidgetHelper::message_alert($message);

		}

	}



	public function errorAdmin( $type = '' )
	{


		$message = 'No tiene permisos para acceder a esta función...';

		// En JSON.
		if ( $type == 'json' ) {

			return $this->json_response ( array (
				'type'    => 1,
				'message' => $message,
			));

		// En Código.
		} if ( $type == 'code' ) {

			echo $message;
			header('HTTP/1.0 401 Unauthorized');

		// En HTML.
		} else {

			echo WidgetHelper::message_alert($message);

		}

	}


	public function requireLibrary( $library ) {

		require("lib/" . $library . ".class.php");

	}

}




