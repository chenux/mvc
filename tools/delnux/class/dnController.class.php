<?php



class dnController {

	public static $CONTROLLER_DIR = 'controllers';

	public static function create($controller = "user") {

		dnUtils::create_dirs([self::$CONTROLLER_DIR]);

		// Columnas.
		$columns = dnView::get_columns(['id', 'update']);

		$rows = '';
		$first  = current($columns);
		foreach ($columns as $column) {

			if ($first !== $column) { $rows .= "\n\t\t\t"; }

			$data = '\'%FIELD%\' => $request->%FIELD%,';
			$rows .= dnUtils::replace($data, [
				'FIELD' => $column['Field']
			]);

		}


		$data = dnUtils::get_contents_template("controller");

		$data = dnUtils::replace($data, [
			'CLASS'       => dnUtils::get_module(),
			'CONTROLLER'  => $controller,
			'MODEL'       => dnUtils::get_module(),
			'MODEL_CLASS' => ucfirst(dnUtils::get_module()),
			'MODULE'      => dnUtils::get_module(),
			'ROWS'        => $rows,
		]);

		// Seguridad.
		if ($controller == 'admin') {

			$html = dnUtils::replace($data, [
				'CHECK_SECURITY' => dnUtils::get_contents_template('security_admin'),
			]);

		} else {

			$html = dnUtils::replace($data, [
				'CHECK_SECURITY' => dnUtils::get_contents_template('security_user'),
			]);

		}

		return dnUtils::save_file(self::$CONTROLLER_DIR . "/" . $controller, $html);

	}


}

