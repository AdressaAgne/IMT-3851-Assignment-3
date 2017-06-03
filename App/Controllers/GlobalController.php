<?php

namespace App\Controllers;

class GlobalController {
	public function __construct($db){
		$this->db = $db;
	}

	/**
	 *  Get all categories in an array
	 * @method categories
	 * @author [Agne Ødegaard]
	 * @return Array with all categories
	 */
	public function categories(){
		return array_column($this->db->all('categories'), 'name');
	}

	/**
	 * get all categories with id's and names
	 * @method cats_with_ids
	 * @author [Agne Ødegaard]
	 * @return array with categories [id => x, name => y]
	 */
	public function cats_with_ids(){
		return $this->db->all('categories');
	}

}
