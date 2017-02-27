<?php
/**
 * @version   dnView.class.php 0.5.1 2010-09-01
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Clase para cargar las plantillas y el tema
 * y así generar la apariencia del sitio.
 *
 * @package	dnMVC
 * @subpackage dnView
 * @since	  0.5
 */
class dnView extends dnBase
{

	/**
	 * @var   array Recursos.
	 * @since 0.6
	 */
	protected $resources = array();

	/**
	 * Método para crear una instancia única de la clase dnView.
	 *
	 * @return dnView
	 * @since  0.5
	 */
	public static function getInstance()
	{
		return parent::getInstance('dnView');
	}

	/**
	 * Método para cargar una vista.
	 *
	 * @param string $file Archivo de la vista.
	 * @param string $data Datos para vista.
	 * @param  boolean $return Si retorna el contenido de la vista.
	 * @param string $module Módulo.
	 * @since 0.5
	 */
	public function load($file, $data = array(), $module = '', $return = false)
	{

		$app     = dnApp::getInstance();
		$config  = dnConfig::getInstance();
		$request = dnRequest::getInstance();
		$user    = dnUser::getInstance();
		$view    = dnView::getInstance();

		if (!$module) {
			$module = $app->getModuleName();
		}

		if (is_array($data)) {
			extract($data);
		}

		if (is_file(dnConfig::getInstance()->getFileView($module, $file))) {
			// Cargamos vista.
			if ( $return ) {

				 ob_start();
				 require dnConfig::getInstance()->getFileView($module, $file);
				 $html =  ob_get_contents();
				 ob_end_clean();
				 return $html;

			} else  {
				require dnConfig::getInstance()->getFileView($module, $file);
			}
		} else {
			die('Error al cargar la vista: ' . $file);
		}
	}

	/**
	 * Método para agregar recurso.
	 *
	 * @param string $resource Dirección del archivo.
	 * @param string $type Tipo del archivo.
	 * @since 0.6
	 */
	public function addResource($resource, $type)
	{
		$this->resources[] = array ('file' => $resource, 'type' => $type);
	}

	/**
	 * Método para obtener todos los archivos css.
	 *
	 * @param string $type Tipo del recurso.
	 * @return array
	 * @since  0.5
	 */
	public function getResources($type)
	{
		$resources = array();

		foreach ($this->resources  as $resource) {
			if ($resource['type'] == $type) {
				$resources[] = $resource['file'];
			}
		}

		return $resources;
	}

	/**
	 * Método para agregar un block html.
	 *
	 * @param string $block Nobre del block.
	 * @param sting $html Código html del block.
	 * @since 0.5
	 */
	public function addBlock($block, $html)
	{
		$this->blocks[$block] = $html;
	}

	/**
	 * Método para obtener un block.
	 *
	 * @param  string $block Nombre del block.
	 * @return string
	 * @since  0.5
	 */
	public function getBlock($block)
	{
	   return $this->blocks[$block];
	}


}
