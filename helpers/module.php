<?php



/**
 * Archivo que contiene los helpers del sistema.
 *
 * @version     helper_modules.php 1.1.0 2011-01-11
 * @copyright   Copyright (c) 2011, Delnux System
 * @package     CompuMax
 * @subpackage  Helpers
 * @since       1.0
 */



class ModuleHelper {



	const TYPE_DONE = 'DONE';


	const TYPE_SESSION = 'SESSION';


	const TYPE_ERROR = 'ERROR';


	const TYPE_WARNING = 'WARNING';


	const TYPE_INCOMPLETE = 'INCOMPLETE';


	const TYPE_EXISTS = 'EXISTS';



	public static function doneJSON($data = null, $message = 'Se guardaron los datos correctamente.') {

		$message = '<span>Información:</span> <span>' . $message . '</span>';


			echo json_encode([
				'data'    => $data,
				'message' => $message,
				'type'    => self::TYPE_DONE,
			]);

	}


	public static function sessionJSON($data = null, 
		$message = 'Su sesión ha excedido el tiempo límite. Por favor, ingrese de nuevo.') {

		$message = '<span>Alerta:</span> <span>' . $message . '</span>';

		echo json_encode([
			'data'    => $data,
			'message' => $message,
			'type'    => self::TYPE_SESSION,
		]);

	}


	public static function warningJSON($data = null, 
		$message = 'Verifica la información que has introducido.') {

		$message = '<span>Alerta:</span> <span>' . $message . '</span>';

		echo json_encode([
			'data'    => $data,
			'message' => $message,
			'type'    => self::TYPE_WARNING,
		]);

	}


	public static function errorJSON($message = 'Ha ocurrido un error') {
		
		$message = '<span>Error:</span> <span>' . $message . '</span>';

		echo json_encode([
			'message' => $message,
			'type'    => self::TYPE_ERROR,
		]);

	}


	public static function incompleteJSON($data = null, $message = 'Completa el formulario correctamente.') {
		
		$message = '<span>Error:</span> <span>' . $message . '</span>';

		echo json_encode([
			'data'    => $data,
			'message' => $message,
			'type'    => self::TYPE_INCOMPLETE,
		]);

	}


	public static function existsJSON($message = 'El registro ya existe.') {

		$message = '<span>Alerta:</span> <span>' . $message . '</span>';

		echo json_encode([
			'message' => $message,
			'type'    => self::TYPE_EXISTS,
		]);

	}

}