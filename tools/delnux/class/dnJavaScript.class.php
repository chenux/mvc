<?php



class dnJavaScript {

	public static function create($module = 'blanck', $controller = "user") {

		dnUtils::create_dirs([$module]);

		$data = dnUtils::get_contents_template("javascript");

		$html = dnUtils::replace($data, [
			'CONTROLLER'  => $controller,
			'MODULE'      => $module,
		]);

		return dnUtils::save_file( $module . DIRECTORY_SEPARATOR . $controller, $html, '.js');

	}


}

