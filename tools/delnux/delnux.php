#!/usr/bin/php
<?php

require dirname(__FILE__) . '/class/dnController.class.php';
require dirname(__FILE__) . '/class/dnJavaScript.class.php';
require dirname(__FILE__) . '/class/dnModel.class.php';
require dirname(__FILE__) . '/class/dnModule.class.php';
require dirname(__FILE__) . '/class/dnUtils.class.php';
require dirname(__FILE__) . '/class/dnView.class.php';


if (!isset($argv[1]) or !isset($argv[2])) {

	echo dnUtils::ok(
		"En módulos: module [name]\n" .
		"En un módulo: controller [user|admin]\n" .
		"En un módulo: model [table]\n" .
		"En un módulo: view [name] [user|admin]\n" .
		"En www/js/modules: js [module] [user|admin]\n"
	);

	exit;
}

$action = $argv[1];


switch ($action) {

	case 'module':

		$module = $argv[2];

		if ( dnModule::create($module) ) {

			dnUtils::ok("Se ha creado el módulo: ". $module);


		} else {

			dnUtils::error("Erro al crear el módulo: ". $module);

		}

		break;

	case 'controller':

		if ( !dnUtils::into_module() ) {
			dnUtils::error("No se encuentra dentro de un módulo");
			exit;
		}


		$controller = $argv[2];

		if ( dnController::create($controller) ) {

			dnUtils::ok("Se ha creado el controlador: ". $controller);


		} else {

			dnUtils::error("Erro al crear el controlador: ". $controller);

		}

	break;


	case 'model':

		$model = $argv[2];

		if ( !dnUtils::into_module() ) {
			dnUtils::error("No se encuentra dentro de un módulo");
			exit;
		}

		if ( dnModel::create($model) ) {

			dnUtils::ok("Se ha creado el modelo: ". $model);


		} else {

			dnUtils::error("Erro al crear el modelo: ". $model);

		}


	break;


	case 'view':


		if ( !dnUtils::into_module() ) {
			dnUtils::error("No se encuentra dentro de un módulo");
			exit;
		}


		$view = $argv[2];

		$controller = ( isset($argv[3]) ) ? $argv[3] : "user";

		if ( dnView::create($view, $controller) ) {

			dnUtils::ok("Se ha creado la vista: ". $view);


		} else {

			dnUtils::error("Erro al crear la vista: ". $view);

		}


	break;


	case 'js':

		$module = $argv[2];

		$controller = ( isset($argv[3]) ) ? $argv[3] : "user";

		if ( dnJavaScript::create($module, $controller) ) {

			dnUtils::ok("Se ha creado el archivo js: ". $module);


		} else {

			dnUtils::error("Erro al crear el archivo js: ". $module);

		}


	break;


	default:

		echo dnUtils::warning("No se reconoce la acción");

	break;
}




?>