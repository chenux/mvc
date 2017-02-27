<?php



class dnModule {


	public static function create($module = "blank") {



		$dirs = [
			$module,
			$module . "/controllers",
			$module . "/views",
			$module . "/views/user",
			$module . "/views/admin",
			$module . "/models",
			$module . "/helpers",
		];


		return dnUtils::create_dirs($dirs);


	}

}