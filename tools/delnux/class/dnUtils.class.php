
<?php


class dnUtils {


	public static  $MODULES_DIR = "modules";


	public static function color($text, $status = "SUCCESS") {

		$out = "";

		switch($status) {
			case "SUCCESS":
				$out = "\e[32m"; //Green background
			break;

			case "FAILURE":
			$out = "\e[31m"; //Red background

			break;
			case "WARNING":
				$out = "\e[33m"; //Yellow background
			break;


		}

		return "$out" . "$text" . "\e[0m";
	}

	public static function ok($msg) {

		echo dnUtils::color($msg, "SUCCESS") ."\n\n";

	}


	public static function error($msg) {

		echo dnUtils::color($msg, "FAILURE") ."\n\n";

	}


	public static function warning($msg) {

		echo self::color($msg, "WARNING") ."\n\n";

	}

	public static function get_dir() {

		return realpath(dirname(__FILE__) . "/../");

	}

	public static function create_dirs($dirs = []) {

		foreach ($dirs as $dir) {

			if ( !is_dir( $dir) and !file_exists($dir) ) {

				if ( !mkdir($dir) ) {

					return false;

				}

			}

		}

		return true;


	}


	public static function get_contents_template($template) {

		$file = self::get_dir() . "/templates/" . $template . ".tpl";

		$contents = file_get_contents( $file );

		return $contents;

	}

	public static function replace($data, $texts = []) {

		foreach ($texts as $key => $value) {
			$data = str_replace("%" . $key . "%", $value, $data);
		}

		return $data;

	}



	public static function put_contents($file, $data) {

		$current = getcwd();

		return file_put_contents($current . "/" . $file, $data);
	}

	public static function get_module() {

		return basename(getcwd());

	}


	public static function get_basename() {

		return realpath(getcwd() . "/../../");

	}

	public static function query($sql) {

		//global $config;

		require self::get_basename() . "/config/config.php";

 		$dns = 	$config['db_driver'] .
 				':dbname='. $config['db_database'] .
 				";host=". $config['db_server'];

 		try {

 			$DB = new PDO($dns, $config['db_user'], $config['db_pass'], $config['db_config']);

 			// print $sql;

 			$result = $DB->query($sql);

 			//var_dump($result);

 			return $result->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			dnUtils::error( "Error al ejuctar la consulta: " . $e->getMessage() );
			die();
		}

	}


	public static function into_module() {

		return basename(realpath(getcwd() . "/..")) == self::$MODULES_DIR;

	}


	public static function get_type_column($type) {

		$patterns = [
			'INT'     => '/^int\(\d+\)$/',
			'VARCHAR' => '/^varchar\(\d+\)$/',
			'TEXT'    => '/^text$/',
			'DATE'    => '/^date$/',
			'DECIMAL' => '/^decimal\(\d+\,\d+\)$/',
			'ENUM'    => '/^enum\(.+\)$/',
		];

		foreach ($patterns as $key => $value) {

			if ( (preg_match($value, $type)) ) {
				return $key;
			}

		}

		return 'VARCHAR';

	}

	public static function save_file($file, $html, $extension = ".php") {

		$file = $file . $extension;

		if ( file_put_contents($file, $html) === false ) {
			dnUtils::error('Error al guardar el archivo: ' . $file );
			return false;
		}

		return true;

	}

}