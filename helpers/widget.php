<?php


class WidgetHelper {


	public static function select_enum($model, $module, $name, $select = null, $column = null, $text = 'Ninguno') {

		$values = dnModel::getInstance($model, $module)
				  ->getEnumValues( ($column) ? $column : $name );

		$items = array('' => $text);

		foreach($values as $value) {
			$items[$value] = $value;
		}

		return HTMLHelper::select($name, $items, $select);
	}


	/**
	 * Mediante un ENUM muestra las opciones
	 * utilizando radios.
	 *
	 * @param  string $model Nombre del Modelo.
	 * @param  string $module Nombre del Módulo.
	 * @param  string $name Nombre del control.
	 * @param  string $checked Opción seleccionada.
	 * @return string $column Se especifica una columna ENUM.
	 * @since  1.1
	 */
	public static function radio_enum($model, $module, $name, $checked = null, $column = null) {


		// Nombre del campo.
		$field = ($column) ? $column : $name;

		$values = dnModel::getInstance($model, $module)->getEnumValues( $field );

		// print_r($values);

		$html = '';
		$i = 0;

		foreach($values as $value) {

			$id = $name . "_" . ++$i;

			// Nombre, Valor.
			$html .= 	HTMLHelper::radio($name, $id, $value, $checked == $value) .
						HTMLHelper::label($value, $id) . ' ' ;


		}

		return $html;

	}


	public static function checkbox_row($id) {

		return HTMLHelper::checkbox('row', $id);

	}



	public static function select_table($model, $module, $name, $select = null, $column = 'name', $id = 'id', $text = 'Ninguno') {

		$values = dnModel::getInstance($model, $module)
				  ->getItems( ['all' => true] );

		$items = array('' => $text);

		foreach($values as $value) {

			$items[$value->$id] = $value->$column;

		}

		return HTMLHelper::select($name, $items, $select);

	}


	public static function message($html, $class) {

		$attributes = array(
			'class' => 'widget-message ' . $class,
		);

		return HTMLHelper::make('div', $attributes, $html);

	}


	public static function message_info($html) {

		echo WidgetHelper::message($html, 'widget-message-info');

	}


	public static function message_alert($html) {

		echo WidgetHelper::message($html, 'widget-message-alert');

	}


	public static function message_error($html) {

		echo WidgetHelper::message($html, 'widget-message-error');

	}


	public static function message_session($html) {

		if( !$html ) $html = 'Su sesión ha excedido el tiempo límite. Por favor, ingrese de nuevo.';

		echo WidgetHelper::message($html, 'widget-message-alert');

	}


	public static function window($name, $class = '', $html = '') {

		// Mensaje.
		$message = HTMLHelper::make('div', array(
			'class' => 'widget-message widget-message-info',
			'id'    => 'message_' . $name,
			'style' => 'display: none',
		));

		// Contenido.
		$content = HTMLHelper::make('div', array(
			'class' => 'widget-window-content',
			'id'    => 'window_content_' . $name,
			'style' => 'clear: both',
		), $html);

		// Cargador...
		$loading = WidgetHelper::spinner($name);

		// Fondo.
		$html .= HTMLHelper::make('div', array(
			'class' => 'widget-window-background',
			'style' => 'display: none',
		));

		// Ventana.
		$html .= HTMLHelper::make('div', array(
			'class' => 'widget-window ' . $class,
			'id'    => 'window_' . $name,
			'style' => 'display: none',

		), $message . $content . $loading);


		return $html;

	}


	public static function spinner($name, $text = 'Cargando...') {

		// Span Icon.
		$html = HTMLHelper::tag_closed('span', [
			'class' => 'icon-spin animate-spin'

		]);

		// Span Text.
		$html .= HTMLHelper::tag_closed('span', [], $text);

		// Div
		$html = HTMLHelper::tag_closed('div', [
			'class' => 'widget-loading',
			'id'    => 'loading_'. $name,
		], $html);

		return $html;

	}



	public static function button_icon($id, $title, $icon) {

		$span = HTMLHelper::make('span', array (
			'class' => $icon,
		));

		$text = HTMLHelper::make('span', [], $title);

		return  HTMLHelper::button($id, $span . $text, '' ,'' , $title);

	}


	public static function button_add() {

		return WidgetHelper::button_icon('add', 'Agregar', 'icon-add-circle-outline');

	}

	public static function button_edit($title = 'Editar') {

		return WidgetHelper::button_icon('edit', 'Editar', 'icon-edit');

	}


	public static function button_remove($title = 'Eliminar') {

		return WidgetHelper::button_icon('remove', 'Eliminar', 'icon-delete');

	}


	public static function button_cancel($id, $title, $icon) {

		return WidgetHelper::button_icon('cancel', 'Cancelar', 'icon-cancel');

	}


	public static function button_save($id, $title, $icon) {

		return WidgetHelper::button_icon('save', 'Guardar', 'icon-save');

	}

}
