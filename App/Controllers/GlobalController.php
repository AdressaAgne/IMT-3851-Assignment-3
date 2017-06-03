<?php

namespace App\Controllers;

class GlobalController {
	public function __construct($db){
		$this->db = $db;
	}

	// Get all categories in an array
	public function categories(){
		return array_column($this->db->all('categories'), 'name');
	}

	// get all categories with id's and names
	public function cats_with_ids(){
		return $this->db->all('categories');
	}

}
