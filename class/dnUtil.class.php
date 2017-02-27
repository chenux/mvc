<?php
/**
 * @version   dnUtil.class.php 0.5.1 2013-07-02
 * @copyright Copyright (c) 2010, Delnux System
 */

/**
 * Evitar el acceso directo.
 */
defined('APPEXEC') or die;

/**
 * Funciones generales.
 *
 * @package	dnMVC
 * @subpackage dnRequest
 * @since	  0.6
 */
class dnUtil extends dnBase
{

	/**
	 * Método para crear una instancia única de la clase dnUtil.
	 *
	 * @return dnUtil
	 * @since  0.6
	 */
	public static function getInstance() {

		return parent::getInstance('dnUtil');

	}


	/**
	 * Método para convertir una fecha
	 * utilizando un formato.
	 *
	 * @param  string $date_string Fecha en formato d-m-Y o Y-m-d.
	 * @param  string $format Formato destino.
	 * @return string
	 * @since  0.8
	 */
	public static function formatDate($date_string, $format = "%d-%m-%Y")
	{

		setlocale(LC_ALL, "es_MX.UTF-8");


		$date_string = str_replace('/', '-', $date_string);


		if ( $date_string ) {

			return strftime($format, strtotime( trim( $date_string ) ) );

		} else {

			return null;

		}

	}


	public static function convertDate($date_string, $format_src = "d/m/Y", $format_des = "Y-m-d")
	{

		if ( $date_string) {

			$date = DateTime::createFromFormat( $format_src,  trim($date_string) );

			if ($date) {

				return $date->format( $format_des );;

			} else {
				return "0000-00-00";
			}

		} else {

			return "0000-00-00";

		}

	}

	public static function upper($string, $encoding = 'UTF-8')
	{

		return mb_convert_case($string, MB_CASE_UPPER, $encoding);

	}

	public static function upper_title($string, $encoding = 'UTF-8')
	{

		if (!$string) return $string;


		// Palabras para ignorar (Minúsculas).
		$lowercases = array("de", "del", "la", "las", "y",
					   "of", "des", "di", "en", "a", "the", "and", "in", "e", "i",
					   "di", "dei");

		// Convertimos la cadena a Título y creamos un array.
		$words = explode(' ',mb_convert_case($string, MB_CASE_TITLE, $encoding));

		foreach ($words as $key => $word)
		{

			// Convertimos a Minúsculas.
			$word = mb_convert_case($word, MB_CASE_LOWER, $encoding);

			// Ignoramos la primera palabra y word debe de estar en lowercases (Minúsculas).
			if ( ($key > 0) and in_array($word, $lowercases) ) {
				$words[$key] = $word;
			}

		}

		return implode(' ', $words);

	}


	public static function lower($string, $encoding = 'UTF-8')
	{

		return mb_convert_case($string, MB_CASE_LOWER, $encoding);

	}




	public static function make_css($styles = array()) {


		// Estilos.
		foreach ($styles as $style => $value) {
			$out .= "$style: $value; " ;
		}

		return $out;


	}

	public static function make_tag($label, $attributes = array(), $html = '', $closed = true) {


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



	public static function check_email($email) {

		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function floattostr( $val ) {

	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');

	}


}
