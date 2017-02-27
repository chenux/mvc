<?php
/**
 * Archivo donde se almacenan los helpers principales del sistema, este archivo se incluye
 * automaticamente.
 *
 * @version    helper_app.php 0.6.1 2010-09-01
 * @copyright  Copyright (c) 2010, Delnux System
 * @package    dnMVC
 * @subpackage Helpers
 * @since      0.5
 */



class AppHelper {




	/**
	 * Helper para obtener una url completa.
	 *
	 * @param  $module Nombre del módulo.
	 * @param  $controller Tipo del Controlador.
	 * @param  $action Nombre de la acción.
	 * @param  $args Argumentos adicionales.
	 * @return string
	 * @since  0.6
	 */
	public static function url($module, $controller = 'user', $action = 'index', $args = array()) {

		$url = "index.php?";

		$parameters = array_merge(array(
			'module'     => $module,
			'controller' => $controller,
			'action'     => $action),
		$args);

		return $url . http_build_query($parameters);
	}


	/**
	 * Helper para obtener una url de administrador .
	 *
	 * @param  $module Nombre del módulo.
	 * @param  $action Nombre de la acción.
	 * @param  $args Argumentos adicionales.
	 * @return string
	 * @since  1.1
	 */
	public static function url_admin($module, $action = 'index', $args = array()) {

		return AppHelper::url($module, 'admin', $action, $args);

	}


	/**
	 * Helper para obtener una url de usuario.
	 *
	 * @param  $module Nombre del módulo.
	 * @param  $action Nombre de la acción.
	 * @param  $args Argumentos adicionales.
	 * @return string
	 * @since  1.1
	 */
	public static function url_user($module, $action = 'index', $args = array()) {

		return AppHelper::url($module, 'user', $action, $args);

	}


	/**
	 * Helper para agregar un recurso.
	 *
	 * @param string $resource Dirección del archivo.
	 * @param string $tyoe Tipo (js|css).
	 * @since 0.6
	 */
	public static function add_resource($resource, $type) {

		dnView::getInstance()->addResource($resource, $type);

	}

	/**
	 * Helper para incluir los recursos dentro del tema.
	 *
	 * @param string $type Tipo del recurso.
	 * @since  0.6
	 */
	public static function include_resources($type) {
		$html = null;

		$resources = dnView::getInstance()->getResources($type);

		foreach ($resources  as $resource) {
			if ($type == 'js') {
				$html .= "<script type=\"text/javascript\" src=\"$resource\"></script>\n";
			} else {
				$html .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$resource\">";
			}
		}

		echo $html;
	}

	/**
	 * Incio de un bloque.
	 *
	 * @since  0.5
	 */
	public static function start_block() {
		ob_start();
	}

	/**
	 * Fin del bloque.
	 *
	 * @param $block Nombre del bloque acrear.
	 * @since 0.5
	 */
	public static function end_block($block) {

		$html = ob_get_contents();

		dnView::getInstance()->addBlock($block,$html);
		ob_end_clean();
	}

	/**
	 * Incluye un bloque.
	 *
	 * @param $block Nombre del bloque a incluir.
	 * @since 0.5
	 */
	public static function include_block($block) {
		echo dnView::getInstance()->getBlock($block);

	}



}
