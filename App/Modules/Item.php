<?php

namespace App\Modules;

use DB, Module;


class Item extends DB implements Module {

	private $time;

	public function __construct(){

	}

	public function get_categories(){
		$cats = explode(',', $this->categories);
		if($cats[0] == '') return ['no tags'];
		return $cats;
	}

	public function author(){
		return new user($this->user_id);
	}

	public function created(){
		return date('d/m/y', strtotime($this->time));
	}

}