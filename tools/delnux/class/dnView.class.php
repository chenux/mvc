<?php



class dnView {


	public static $FORM_DIR   = "form";
	public static $INDEX_DIR  = "index";
	public static $INPUTS_DIR = "inputs";
	public static $REMOVE_DIR  = "remove";
	public static $SHOW_DIR   = "show";
	public static $TABLE_DIR  = "table";
	public static $VIEWS_DIR  = "views";


	public static function create($view = "index", $controller = "user") {


		$dirs = [
			"views",
			"views/" . $controller,
		];


		dnUtils::create_dirs($dirs);


		switch ($view) {

			case 'index':

				if (self::view_index($controller)) {

					return true;

				} else {

					return false;

				}

				break;


			case 'form':

				if (self::view_form($controller)) {

					return true;

				} else {

					return false;

				}

				break;

			case 'remove':

				if (self::view_remove($controller)) {

					return true;

				} else {

					return false;

				}

				break;

			case 'show':

				if (self::view_show($controller)) {

					return true;

				} else {

					return false;

				}

				break;


			default:

				return false;

				break;
		}


		return false;

	}


	public static function get_contents_view($view) {

		return dnUtils::get_contents_template(
			self::$VIEWS_DIR  . "/" . $view
		);

	}


	public static function get_contents_input($input) {

		return self::get_contents_view(
			self::$INPUTS_DIR . "/" . $input
		);

	}


	public static function get_columns($ignore = ['id']) {

		// Columnas.
		$result = [];

		$columns =  dnUtils::query("SHOW FULL COLUMNS FROM tbl_" . dnUtils::get_module());

		foreach ($columns as $column) {

			if ( in_array($column['Field'], $ignore) == false ) {
				$result[] = $column;
			}

		}

		return $result;

	}


	public static function view_index($controller = "user") {


		$module    = dnUtils::get_module();
		$index_dir = self::$VIEWS_DIR . "/" . $controller . "/" . self::$INDEX_DIR;
		$table_dir = self::$VIEWS_DIR . "/" . $controller . "/" . self::$TABLE_DIR;

		// Creamos el directorio de la vista.
		dnUtils::create_dirs([
			self::$VIEWS_DIR,
			self::$VIEWS_DIR . "/" . $controller,
			$index_dir,
			$table_dir,
		]);

		// Index.
		$data = self::get_contents_view("index/index");

		$html = dnUtils::replace($data, [
			'MODULE'     => dnUtils::get_module(),
			'CONTROLLER' => $controller,
		]);


		if ( dnUtils::save_file($index_dir . '/' . 'index', $html) == false ) {

			return false;

		}

		// Columnas.
		$columns = self::get_columns(['id']);


		// Table
		$header = "";
		// Elemento final.
		$end  = end($columns);
		foreach ($columns as $column) {

			$header .= '<div class="theme-table-cell">' . $column['Comment'] . '</div>';

			if ($column !== $end) {
				$header .= "\n\t";
			}

		}

		$data = self::get_contents_view("index/table");

		// Row
		$rows = "";
		foreach ($columns as $column) {

			$rows .= '<div class="theme-table-cell"><?php echo $row->' . $column['Field'] . ' ?></div>';
			if ($column !== $end) {
				$rows .= "\n\t";
			}

		}


		$html = dnUtils::replace($data, [
			'CONTROLLER' => $controller,
			'HEADER'     => $header,
			'MODULE'     => dnUtils::get_module(),
			'ROWS'       => $rows,
		]);




		if ( dnUtils::save_file($table_dir . '/' . 'table', $html) == false ) {

			return false;

		}

		return true;
	}



	public static function view_form($controller = "user") {

		$module  = dnUtils::get_module();

		$form_dir = self::$VIEWS_DIR . "/" . $controller . "/" . self::$FORM_DIR;

		dnUtils::create_dirs([
			self::$VIEWS_DIR,
			self::$VIEWS_DIR . "/" . $controller,
			$form_dir,
		]);

		$columns = self::get_columns(['id', 'update']);


		$inputs = '';
		$first  = current($columns);

		foreach ($columns as $column) {

			$type = dnUtils::get_type_column($column['Type']);

			switch ($type) {

				case 'TEXT':
					$data = self::get_contents_input('textarea');
					break;

				case 'DATE':
					$data = self::get_contents_input('date');
					break;

				case 'ENUM':
					$data = self::get_contents_input('select_enum');
					break;


				case 'INT':
				case 'VARCHAR':
					$data = self::get_contents_input('text');
					break;

				default:
					$data = self::get_contents_input('text');
					break;
			}

			if ($first !== $column) { $inputs .= "\n"; }

			$inputs .=  dnUtils::replace($data, [
				'MODEL'  => ucfirst($module),
				'MODULE' => $module,
				'LABEL'  => $column['Comment'],
				'INPUT'  => $column['Field'],
			]);

		}


		$data = self::get_contents_view('form/form');

		$html = dnUtils::replace($data, [
			'CONTROLLER' => $controller,
			'MODULE'     => $module,
			'INPUTS'     => $inputs,
		]);

		return dnUtils::save_file( $form_dir . '/' . 'form', $html);
	}


	public static function view_show($controller = "user") {

		$module   = dnUtils::get_module();

		$show_dir = self::$VIEWS_DIR . "/" . $controller . "/" . self::$SHOW_DIR;

		// Creamos el directorio de la vista.
		dnUtils::create_dirs([
			self::$VIEWS_DIR,
			self::$VIEWS_DIR . "/" . $controller,
			$show_dir,
		]);

		$columns = self::get_columns(['id']);

		$rows = '';
		$first  = current($columns);
		foreach ($columns as $column) {

			$data = self::get_contents_view('show/row');

			if ($first !== $column) { $rows .= "\n"; }

			$rows .=  dnUtils::replace($data, [
				'COMMENT' => $column['Comment'],
				'COLUMN'  => $column['Field'],
			]);

		}

		$data = self::get_contents_view('show/show');

		$html = dnUtils::replace($data, [
			'ROWS' => $rows,
		]);

		return dnUtils::save_file($show_dir . '/' . 'show', $html);
	}


	public static function view_remove($controller = "user") {

		$module = dnUtils::get_module();

		$remove_dir = self::$VIEWS_DIR . "/" . $controller . "/" . self::$REMOVE_DIR;

		// Creamos el directorio de la vista.
		dnUtils::create_dirs([
			self::$VIEWS_DIR,
			self::$VIEWS_DIR . "/" . $controller,
			$remove_dir,
		]);

		$data = self::get_contents_view('remove/form');

		$html = dnUtils::replace($data, [
			'CONTROLLER' => $controller,
			'MODULE'     => $module,
		]);

		return dnUtils::save_file($remove_dir . '/' . 'form', $html);
	}
}

