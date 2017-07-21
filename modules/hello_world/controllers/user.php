<?php


defined('APPEXEC') or die;


class hello_world extends dnController
{


	public $name = 'hello_world';



	public function index($request) {


		$banners =  dnDB::table('tbl_table')->get();
		//$banners =  new dnQuery('tbl_banner')->get();

		print_r($banners);
		//echo "-_-";

	}



}

