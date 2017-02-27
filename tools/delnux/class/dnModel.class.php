<?php



class dnModel {


	public static $MODELS_DIR = 'models';


	public static function create($model = "blank") {

		$data = dnUtils::get_contents_template("model");

		dnUtils::create_dirs([self::$MODELS_DIR]);

		$html = dnUtils::replace($data, [
			'CLASS'          => ucfirst($model),
			'MODEL_PROPERTY' => $model,
			'TABLE'          => $model,
			'TABLE_SHORT'    => substr($model, 0, 3),
		]);

		return dnUtils::save_file(self::$MODELS_DIR . "/" . $model, $html);

	}

}