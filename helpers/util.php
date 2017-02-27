<?php
/**
 * @version   UtilHelper.class.php 0.5.1 2013-07-02
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
class UtilHelper {


	public static function date($date, $format = '%d %B %Y') {

		return UtilHelper::formatDate($date, $format);

	}

	public static function date_log($date, $format = '%d %B %Y %H:%M:%S') {

		return UtilHelper::formatDate($date, $format);

	}


	/**
	 * Método para convertir una fecha
	 * utilizando un formato.
	 *
	 * @param  string $date_string Fecha en formato d/m//Y, d-m-Y o Y-m-d.
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


	public static function check_email($email) {

		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function floattostr( $val ) {

	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');

	}


	/**
	 * Ayudante para seleccionar el turno.
	 *
	 * @param  int $num Cantidad.
	 * @param  int $numdec Número decimales.
	 * @return string
	 * @since  1.0
	 */
	public static function format($num, $round = false, $numdec = 2, $sepdec = '.', $sepmil = ',')
	{
		return number_format (($round) ? round($num, 0) : $num, $numdec , $sepdec , $sepmil);
	}

	public static function send_mail($email_to, $subject, $message, $email_from, $name_from = null)
	{

		// Datos
		$subject    = strtoupper($subject);

		$headers =  "From: $namefull <$email_from>\r\n" .
		"Reply-To: $email_from\r\n" .
		'X-Mailer: PHP/6.0' . phpversion();

		return mail($email_to, $subject, $message, $headers);


	}

}
