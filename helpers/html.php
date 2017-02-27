<?php


class HTMLHelper {


	public static function a($url, $text) {

		$attributes = array(
			'href' => $url,
		);

		return HTMLHelper::make('a', $attributes, $text);

	}

	public static function file($name, $disabled = false) {

		$attributes = array(
			'type'  => 'file',
			'id'    => $name,
			'name'  => $name,
		);

		if ( $disabled ) {
			$attributes['disabled'] = 'disabled';
		}

		return HTMLHelper::make('input', $attributes, null, false);

	}

	public static function date($name, $value = '', $disabled = false) {

		$attributes = array(
			'type'  => 'date',
			'id'    => $name,
			'name'  => $name,
			'value' => $value,
		);

		if ( $disabled ) {
			$attributes['disabled'] = 'disabled';
		}

		return HTMLHelper::make('input', $attributes, null, false);

	}


	/**
	 * Ayudante para crear una lista de selección.
	 *
	 * @param  array $args Propiedades.
	 * @return string
	 * @since  0.5
	 */
	public static function select($name, $items = array(), $select = null, $disabled = false) {


		$options = '';

		// Etiquetas option.
		foreach ($items as $value => $text) {

			$options .=  HTMLHelper::option($value, $text, $select == $value);

		}


		// Etiqueta select.
		$attributes = array (
			'id'   => $name,
			'name' => $name,
		);

		if ( $disabled ) {
			$attributes['disabled'] = 'disabled';
		}

		return HTMLHelper::make('select', $attributes, $options);

	}


	public static function option($value, $text, $selected = false) {

		$attributes = array (
			'value' => $value,
		);

		if ( $selected ) {
			$attributes['selected'] = 'selected';
		}

		return HTMLHelper::make('option', $attributes, $text);

	}

	public static function password($name, $value = '', $size = 20, $disabled = false) {

		$attributes = array(
			'type'  => 'password',
			'id'    => $name,
			'name'  => $name,
			'value' => $value,
			'size'  => $size,
		);

		if ( $disabled ) {
			$attributes['disabled'] = 'disabled';
		}

		return HTMLHelper::make('input', $attributes, null, false);

	}


	public static function text($name, $value = '', $placeholder = '', $size = 20, $disabled = false) {

		$attributes = array(
			'type'  => 'text',
			'id'    => $name,
			'name'  => $name,
			'value' => $value,
			'placeholder' => $placeholder,
			'size'  => $size,
		);

		if ( $disabled ) {
			$attributes['disabled'] = 'disabled';
		}

		return HTMLHelper::make('input', $attributes, null, false);

	}


	public static function checkbox($name, $value = '', $id = '', $checked = false, $disabled = false) {


		$attributes = array(
			'type'  => 'checkbox',
			'id'    => $id,
			'name'  => $name,
			'value' => $value,
			'size'  => $size,
		);

		if ( $checked ) {
			$attributes['checked'] = 'checked';
		}


		if ( $disabled ) {
			$attributes['disabled'] = 'disabled';
		}

		return HTMLHelper::make('input', $attributes, null, false);

	}


	public static function radio($name, $id, $value, $checked = false) {

		$attributes = array(
			'type'  => 'radio',
			'id'    => $id,
			'name'  => $name,
			'value' => $value,
		);

		if ( $checked ) {

			$attributes['checked'] = 'checked';

		}

		return HTMLHelper::make('input', $attributes, null, false);

	}


	public static function hidden($name, $value = '') {


		$attributes = array(
			'type'  => 'hidden',
			'id'    => $name,
			'name'  => $name,
			'value' => $value,
		);

		return HTMLHelper::make('input', $attributes, null, false);

	}


	public static function label($text, $for = '') {

		$attributes = array(
			'for' => $for,
		);

		return HTMLHelper::make('label', $attributes, $text);

	}


	public static function textarea($name, $text = '', $placeholder = '',  $rows = 2, $cols = 20) {

		$attributes = array(
			'id'            => $name,
			'name'          => $name,
			'rows'          => $rows,
			'cols'          => $cols,
			'placeholder'   => $placeholder,
		);

		return HTMLHelper::make('textarea', $attributes, $text);

	}


	public static function button($name, $text, $class = 'default blue', $style = '', $title = '') {

		$attributes = array (
			'class' => $class,
			'id'    => $name,
			'name'  => $name,
			'style' => $style,
			'title' => $title,
		);

		return HTMLHelper::make('button', $attributes, $text);

	}

	public static function css($styles = array()) {


		// Estilos.
		foreach ($styles as $style => $value) {
			$out .= "$style: $value; " ;
		}

		return $out;


	}


	public static function make($label, $attributes = array(), $html = '', $closed = true) {

		$vars = '';

		// Atributos de la Etiqueta
		foreach ($attributes as $attribute => $value) {
			$vars .= " $attribute=\"$value\"";
		}

		// Cerrar
		if ($closed) {
			$out = "<$label$vars>";
		// No Cerrar
		} else {
			$out = "<$label$vars";
		}


		if ($html and $closed) {
			$out .= $html;
		}

		// Cerrar
		if ($closed) {
			$out .= "</$label>";
		// No Cerrar
		} else {
			$out .= ">";
		}


		return $out;

	}


	public static function tag_closed($label, $attributes = [], $html = '') {

		return self::make($label, $attributes, $html);

	}

	public static function tag_unclosed($label, $attributes = []) {


		return self::make($label, $attributes, '', false);


	}
}